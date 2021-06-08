<?php

namespace Owaslo\OtpAuthentication\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Owaslo\OtpAuthentication\Models\OtpToken;
use Owaslo\OtpAuthentication\Notifications\VerifyPhone;
use Owaslo\OtpAuthentication\OtpAuthentication;

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
     * Send otp notification.
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
     * Send otp notification.
     *
     * @return void
     */
    public function otpLogin($guard = "users", $otp)
    {
        $otpToken = $this->otpToken();

        if (OtpAuthentication::isOtpAuthenticable($otpToken, $otp)['status']) {
            Auth::guard($guard)->login($this, $remember = true);
        }
    }

    /**
     * Send otp notification.
     *
     * @return void
     */
    public function otpLogout($session, $guard = "users")
    {
        Auth::guard($guard)->logout();

        $session->invalidate();

        $session->regenerateToken();
    }

    public static function findUserByPhone($phone, $attribute = "phone")
    {
        return __CLASS__::where($attribute, $phone)->first();
    }
}
