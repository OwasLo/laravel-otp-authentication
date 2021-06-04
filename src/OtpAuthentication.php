<?php

namespace Owaslo\OtpAuthentication;

use Owaslo\OtpAuthentication\Contracts\OtpAuthenticable;
use Owaslo\OtpAuthentication\Exceptions\OtpHasNotSent;
use Illuminate\Support\Carbon;
use Owaslo\OtpAuthentication\Exceptions\OtpExpired;
use Owaslo\OtpAuthentication\Models\OtpToken;

class OtpAuthentication
{
    public function sendOTP(OtpAuthenticable $user)
    {
        $user->sendOtpAuthenticationNotification();
    }

    public function verifyOTP(OtpAuthenticable $user, $otp)
    {
        $otpToken = $user->otpToken();

        if ($otpToken==null) {
            return [
                'status'=>false,
                'message'=>"OTP_NOT_SENT"
            ];
        }

        if ($otpToken->expires_at < Carbon::now()) {
            return [
                'status'=>false,
                'message'=>"OTP_EXPIRED"
            ];
        }

        if($otpToken->otp != $otp){
            return [
                'status'=>false,
                'message'=>"OTP_INVALID"
            ];
        }

        return [
            'status'=>true,
            'message'=>"OTP_SUCCESSFUL"
        ];

    }
}
