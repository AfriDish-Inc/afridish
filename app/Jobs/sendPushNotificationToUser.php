<?php

namespace App\Jobs;

use App\Models\FcmToken;
use App\Services\FcmService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class sendPushNotificationToUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $notification;

    public function __construct($data, $notification)
    {
        $this->data = $data;
        $this->notification = $notification;
    }

    public function handle()
    {
        $results = [];

        foreach ($this->data['users'] as $user_id) {
            $this->notification->user()->attach($user_id);

            $userDeviceToken = optional(FcmToken::where('user_id', $user_id)->latest()->first())->fcm_token;

            $results[$user_id] = app(FcmService::class)->send(
                $userDeviceToken,
                $this->data['title'],
                $this->data['body'],
                ['type' => 1]
            );
        }

        return $results;
    }
}
