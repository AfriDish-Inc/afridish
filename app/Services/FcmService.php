<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Sends push notifications through Firebase Cloud Messaging's HTTP v1 API.
 *
 * The legacy "server key" API (a single static key in the Authorization
 * header) was shut off by Google in 2024. v1 instead authenticates as a
 * service account: a JSON key file (Firebase console -> Project settings
 * -> Service accounts -> Generate new private key) is used to sign a JWT,
 * which is exchanged for a short-lived OAuth2 access token.
 */
class FcmService
{
    private const TOKEN_URL = 'https://oauth2.googleapis.com/token';
    private const SCOPE = 'https://www.googleapis.com/auth/firebase.messaging';

    /**
     * Send a notification to a single device token.
     * Returns the decoded FCM response, or null if the token was empty
     * or credentials aren't configured.
     */
    public function send(?string $deviceToken, string $title, string $body, array $data = []): ?array
    {
        if (! $deviceToken) {
            return null;
        }

        $projectId = config('services.fcm.project_id');
        $accessToken = $this->getAccessToken();

        if (! $projectId || ! $accessToken) {
            return null;
        }

        $message = [
            'message' => [
                'token' => $deviceToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
            ],
        ];

        if ($data) {
            $message['message']['data'] = array_map('strval', $data);
        }

        $response = Http::withToken($accessToken)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", $message);

        return $response->json();
    }

    /**
     * Send the same notification to several device tokens.
     * Returns one result per token, in the same order.
     */
    public function sendToMany(array $deviceTokens, string $title, string $body, array $data = []): array
    {
        return array_map(
            fn ($token) => $this->send($token, $title, $body, $data),
            $deviceTokens
        );
    }

    /**
     * Exchange the service account's private key for a short-lived OAuth2
     * access token, cached for just under its 1 hour lifetime.
     */
    private function getAccessToken(): ?string
    {
        return Cache::remember('fcm_v1_access_token', 3500, function () {
            $credentialsPath = config('services.fcm.credentials');

            if (! $credentialsPath || ! File::exists($credentialsPath)) {
                return null;
            }

            $credentials = json_decode(File::get($credentialsPath), true);

            if (empty($credentials['client_email']) || empty($credentials['private_key'])) {
                throw new RuntimeException('FCM service account file is missing client_email/private_key.');
            }

            $now = time();
            $header = $this->base64UrlEncode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
            $claims = $this->base64UrlEncode(json_encode([
                'iss' => $credentials['client_email'],
                'scope' => self::SCOPE,
                'aud' => self::TOKEN_URL,
                'iat' => $now,
                'exp' => $now + 3600,
            ]));

            $signature = '';
            openssl_sign("{$header}.{$claims}", $signature, $credentials['private_key'], OPENSSL_ALGO_SHA256);
            $jwt = "{$header}.{$claims}.".$this->base64UrlEncode($signature);

            $response = Http::asForm()->post(self::TOKEN_URL, [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ]);

            return $response->json('access_token');
        });
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
