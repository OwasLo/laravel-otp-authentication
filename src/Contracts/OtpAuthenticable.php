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
     * Determine if the user has verified their phone address.
     *
     * @return bool
     */
    public function hasVerifiedPhone();

    /**
     * Mark the given user's phone as verified.
     *
     * @return bool
     */
    public function markPhoneAsVerified();

    /**
     * Send the phone verification notification.
     *
     * @return void
     */
    public function sendOtpAuthenticationNotification();

    /**
     * Get the phone address that should be used for verification.
     *
     * @return string
     */
    public function getPhoneForVerification();
}
