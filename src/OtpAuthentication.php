<?php

namespace Owaslo\OtpAuthentication;

use Illuminate\Support\Carbon;
use Owaslo\OtpAuthentication\Contracts\OtpAuthenticable;
use Owaslo\OtpAuthentication\Models\OtpToken;
use Owaslo\Textit\Textit;
use Owaslo\Textit\TextitMessage;

class OtpAuthentication
{
    public static function getOtpExpireDuration()
    {
        return config('otp-authentication.otp.expire_duration');
    }
    
    public static function getOtpLength()
    {
        return config('otp-authentication.otp.length');
    }
    
    public static function getOtpCharacters()
    {
        return config('otp-authentication.otp.characters');
    }

    public static function sendPhoneVerificationCode($phone)
    {
        $otpToken = OtpToken::updateOrCreate(
            ['phone' => $phone],
            ['otp' => OtpToken::generateOTP(), 'expires_at' => Carbon::now()->addMinutes(self::getOtpExpireDuration())]
        );
        app(Textit::class)->send(new TextitMessage($phone, 'Code:' . $otpToken->otp . ', Please enter this code to verify your phone number'));
    }

    public static function verifyPhone($phone, $otp)
    {
        $otpToken = OtpToken::where('phone', $phone)->first();
        
        return OtpAuthentication::isOtpAuthenticable($otpToken, $otp);
    }

    public static function sendOTP(OtpAuthenticable $user)
    {
        $user->sendOtpAuthenticationNotification();
    }

    public static function verifyOTP(OtpAuthenticable $user, $otp)
    {
        $otpToken = $user->otpToken;

        return OtpAuthentication::isOtpAuthenticable($otpToken, $otp);
    }

    public static function isOtpAuthenticable($otpToken, $otp)
    {
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
