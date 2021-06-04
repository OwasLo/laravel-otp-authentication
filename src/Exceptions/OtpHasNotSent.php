<?php

namespace Owaslo\OtpAuthentication\Exceptions;

class OtpHasNotSent extends \Exception
{
    public static function serviceRespondedWithAnError()
    {
        return new static("Otp has not been generated for this user.");
    }
}
