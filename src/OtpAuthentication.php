<?php

namespace Owaslo\OtpAuthentication;

use Illuminate\Support\Carbon;
use Owaslo\OtpAuthentication\Exceptions\OtpExpired;
use Owaslo\OtpAuthentication\Models\OtpToken;
use Owaslo\Textit\Textit;
use Owaslo\Textit\TextitMessage;
use Owaslo\OtpAuthentication\Contracts\OtpAuthenticable;

class OtpAuthentication
{
    public static function sendPhoneVerificationCode($phone)
    {
        $otpToken = $this->otpToken()->updateOrCreate(
            ['phone' => $phone],
            ['otp' => OtpToken::generateOTP(), 'expires_at' => Carbon::now()->addMinutes(2)]
        );
        $this->app->make(Textit::class)->send(TextitMessage($phone, 'Code:'.$otpToken->otp.', Please enter this code to verify your phone number'));
    }

    public static function sendOTP(OtpAuthenticable $user)
    {
        $user->sendOtpAuthenticationNotification();
    }

    public static function verifyOTP(OtpAuthenticable $user, $otp)
    {
        $otpToken = $user->otpToken();

        if ($otpToken == null) {
            return [
                'status' => false,
                'message' => "OTP_NOT_SENT"
            ];
        }

        if ($otpToken->expires_at < Carbon::now()) {
            return [
                'status' => false,
                'message' => "OTP_EXPIRED"
            ];
        }

        if ($otpToken->otp != $otp) {
            return [
                'status' => false,
                'message' => "OTP_INVALID"
            ];
        }

        return [
            'status' => true,
            'message' => "OTP_SUCCESSFUL"
        ];
    }
}
