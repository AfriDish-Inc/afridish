<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Str;
use Validator;

class PasswordResetController extends Controller
{
    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 200);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user)
            return response()->json([
                'status' => false,
                'message' => "We can't find a user with that e-mail address."
            ], 200);
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => Str::random(60)
            ]
        );
        if ($user && $passwordReset)
            $user->notify(
                new PasswordResetRequest($passwordReset->token)
            );
        return response()->json([
            'status' => true,
            'message' => 'We have e-mailed your password reset link!'
        ]);
    }
    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $status = 1;
        $message = '';
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset) {
            $status = 0;
            $message = "This password reset token is invalid.";
        }
        else if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            $status = 0;
            $message = "This password reset token is invalid.";
        }

        $data['passwordReset'] = $passwordReset;
        return view('auth.passwords.reset')->with($data)->with("status", $status)->with("message", $message);
        // return response()->json($passwordReset);
    }
    /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|alpha_num|min:6|max:20',
            'password_confirmation' => 'required|same:password',
            'token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response(
                [
                    'status' => false,
                    'errors' => $validator->errors()
                ],
                200
            );
        }

        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset)
            return response()->json([
                'status' => false,
                'inavlid' => 'This email or password reset token is invalid.'
            ], 200);
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user)
            return response()->json([
                'status' => false,
                'message' => "We can't find a user with that e-mail address."
            ], 200);
        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));
        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully. You can login now.'
        ], 200);
        // return view('passwordChanged')->with('success','Password updated successfully.You can login now.');
        // return response()->json($user);
    }
}
