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
    public function sendPhoneVerificationCode($phone)
    {
        $otpToken = $this->otpToken()->updateOrCreate(
            ['phone' => $phone],
            ['otp' => OtpToken::generateOTP(), 'expires_at' => Carbon::now()->addMinutes(2)]
        );
        $this->app->make(Textit::class)->send(TextitMessage($phone, 'Code:'.$otpToken->otp.', Please enter this code to verify your phone number'));
    }

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
<<<<<<< HEAD
                'message' => "OTP_NOT_SENT"
=======
                'message' => "OTP_NOT_SENT",
>>>>>>> 8a5f16ed8d19ba56a525c62710b6b31513b9fbbd
            ];
        }

        if ($otpToken->expires_at < Carbon::now()) {
            return [
                'status' => false,
<<<<<<< HEAD
                'message' => "OTP_EXPIRED"
=======
                'message' => "OTP_EXPIRED",
>>>>>>> 8a5f16ed8d19ba56a525c62710b6b31513b9fbbd
            ];
        }

        if ($otpToken->otp != $otp) {
            return [
                'status' => false,
<<<<<<< HEAD
                'message' => "OTP_INVALID"
=======
                'message' => "OTP_INVALID",
>>>>>>> 8a5f16ed8d19ba56a525c62710b6b31513b9fbbd
            ];
        }

        return [
            'status' => true,
<<<<<<< HEAD
            'message' => "OTP_SUCCESSFUL"
=======
            'message' => "OTP_SUCCESSFUL",
>>>>>>> 8a5f16ed8d19ba56a525c62710b6b31513b9fbbd
        ];
    }
}
