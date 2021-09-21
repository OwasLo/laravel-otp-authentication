<?php

namespace Owaslo\OtpAuthentication;

use Illuminate\Support\Carbon;
use Owaslo\OtpAuthentication\Contracts\OtpAuthenticable;
use Owaslo\OtpAuthentication\Helpers\OtpStatusMessage;
use Owaslo\OtpAuthentication\Models\OtpToken;
use Owaslo\Textit\Textit;
use Owaslo\Textit\TextitMessage;

class OtpAuthentication
{
    public static function getOtpExpireDuration()
    {
        return config('otp-authentication.otp.expire_duration', 5);
    }

    public static function getOtpLength()
    {
        return config('otp-authentication.otp.length', 5);
    }

    public static function getOtpCharacters()
    {
        return config('otp-authentication.otp.characters', '0123456789');
    }

    public static function getIsBlockSms()
    {
        return config('otp-authentication.is_block_sms', true);
    }

    public static function sendPhoneVerificationCode($phone)
    {
        $otpToken = OtpToken::updateOrCreate(
            ['phone' => $phone],
            ['otp' => OtpToken::generateOTP(), 'expires_at' => Carbon::now()->addMinutes(self::getOtpExpireDuration())]
        );
        if (! OtpAuthentication::getIsBlockSms()) {
            app(Textit::class)->send(new TextitMessage($phone, 'Code:' . $otpToken->otp . ', Please enter this code to verify your phone number'));
        }
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
                'message' => OtpStatusMessage::getOtpNotSentMessage(),
            ];
        }

        if ($otpToken->expires_at < Carbon::now()) {
            return [
                'status' => false,
                'message' => OtpStatusMessage::getOtpExpiredMessage(),
            ];
        }

        if ($otpToken->otp != $otp) {
            return [
                'status' => false,
                'message' => OtpStatusMessage::getOtpInvalidMessage(),
            ];
        }

        return [
            'status' => true,
            'message' => OtpStatusMessage::getOtpValidMessage(),
        ];
    }
}
