<?php

namespace Owaslo\OtpAuthentication\Contracts;

interface OtpAuthenticable
{
    /**
     * Determine the otp token for a user.
     *
     * @return bool
     */
    public function otpToken();


    /**
     * Send the phone verification notification.
     *
     * @return void
     */
    public function sendOtpAuthenticationNotification();
}
