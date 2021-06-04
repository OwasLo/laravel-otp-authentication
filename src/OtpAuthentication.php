<?php

namespace Owaslo\OtpAuthentication;

use Illuminate\Support\Carbon;
use Owaslo\OtpAuthentication\Contracts\OtpAuthenticable;

class OtpAuthentication
{
    public function sendOTP(OtpAuthenticable $user)
    {
        $user->sendOtpAuthenticationNotification();
    }

    public function verifyOTP(OtpAuthenticable $user, $otp)
    {
        $otpToken = $user->otpToken();

        if ($otpToken == null) {
            return [
                'status' => false,
                'message' => "OTP_NOT_SENT",
            ];
        }

        if ($otpToken->expires_at < Carbon::now()) {
            return [
                'status' => false,
                'message' => "OTP_EXPIRED",
            ];
        }

        if ($otpToken->otp != $otp) {
            return [
                'status' => false,
                'message' => "OTP_INVALID",
            ];
        }

        return [
            'status' => true,
            'message' => "OTP_SUCCESSFUL",
        ];
    }
}
