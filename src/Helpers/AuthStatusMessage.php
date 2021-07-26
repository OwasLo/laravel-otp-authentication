<?php

namespace Owaslo\OtpAuthentication\Helpers;

/**
 * @method static self invalidInput()
 */
class AuthStatusMessage
{
    const AUTHENTICATION_SUCCESSFUL = "User Authenticated Successfully";

    const AUTHENTICATION_UNSUCCESSFUL = "User Authentication Failed";

    public static function getAuthenticationSuccessfulMessage()
    {
        return self::AUTHENTICATION_SUCCESSFUL;
    }

    public static function getAuthenticationUnsuccessfulMessage()
    {
        return self::AUTHENTICATION_UNSUCCESSFUL;
    }
}
