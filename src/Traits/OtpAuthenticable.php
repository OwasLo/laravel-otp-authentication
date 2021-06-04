<?php

namespace Owaslo\OtpAuthentication\Traits;

use Owaslo\OtpAuthentication\Models\OtpToken;
use Illuminate\Support\Carbon;
use Owaslo\OtpAuthentication\Notifications\VerifyPhone;

trait OtpAuthenticable
{
    /**
     * Determine the otp token for a user.
     */
    public function otpToken()
    {
        return $this->morphOne(OtpToken::class, 'optAuthenticable');
    }

    /**
     * Determine if the user has verified their phone address.
     *
     * @return bool
     */
    public function hasVerifiedPhone()
    {
        return !is_null($this->phone_verified_at);
    }

    /**
     * Mark the given user's phone as verified.
     *
     * @return bool
     */
    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Send the phone verification notification.
     *
     * @return void
     */
    public function sendOtpAuthenticationNotification()
    {
        $otpToken = $this->otpToken()->updateOrCreate(
            ['otpAuthenticable_id' => $this->id, 'otpAuthenticable_type' => get_class($this)],
            ['otp' => OtpToken::generateOTP(), 'expires_at' => Carbon::now()->addMinutes(2)]
        );
        
        $this->notify(new VerifyPhone($otpToken->otp));
    }

    /**
     * Get the phone address that should be used for verification.
     *
     * @return string
     */
    public function getPhoneForVerification()
    {
        return $this->phone;
    }
}