<?php

namespace Owaslo\OtpAuthentication\Exceptions;

class OtpExpired extends \Exception
{
    public static function serviceRespondedWithAnError()
    {
        return new static("OTP_Expired");
    }
}
