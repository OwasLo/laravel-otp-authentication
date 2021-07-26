<?php

namespace Owaslo\OtpAuthentication\Helpers;

/**
 * @method static self invalidInput()
 */
class OtpStatusMessage
{
    const OTP_NOT_SENT = "Otp is not sent to the user";

    const OTP_EXPIRED = "Otp is expired. Resend the Otp";

    const OTP_INVALID = "Otp is invalid";

    const OTP_VALID = "Otp is Valid";

    public static function getOtpNotSentMessage()
    {
        return self::OTP_NOT_SENT;
    }

    public static function getOtpExpiredMessage()
    {
        return self::OTP_EXPIRED;
    }

    public static function getOtpInvalidMessage()
    {
        return self::OTP_INVALID;
    }

    public static function getOtpValidMessage()
    {
        return self::OTP_VALID;
    }
}
