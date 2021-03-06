<?php

namespace Owaslo\OtpAuthentication\Contracts;

interface OtpAuthenticable
{
    /**
     * Determine the otp token for a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function otpToken();

    /**
     * Send the phone verification notification.
     *
     * @return void
     */
    public function sendOtpAuthenticationNotification();

    /**
     * Login user using otp
     *
     * @return array
     */
    public function otpLogin($otp, $guard = "users");

    /**
     * Logout user
     *
     * @return void
     */
    public function otpLogout($session, $guard = "users");

    /**
     * Get user by phone number
     *
     * @return OTPAuthenticable
     */
    public static function findUserByPhone($phone, $attribute = "phone");
}
