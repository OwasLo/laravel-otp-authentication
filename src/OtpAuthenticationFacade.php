<?php

namespace Owaslo\OtpAuthentication;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Owaslo\OtpAuthentication\OtpAuthentication
 */
class OtpAuthenticationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-otp-authentication';
    }
}
