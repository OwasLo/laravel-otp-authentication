<?php

namespace Owaslo\OtpAuthentication\Traits;

use ColumnNotFoundException;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Owaslo\OtpAuthentication\Helpers\AuthStatusMessage;
use Owaslo\OtpAuthentication\Models\OtpToken;
use Owaslo\OtpAuthentication\Notifications\VerifyPhone;
use Owaslo\OtpAuthentication\OtpAuthentication;

trait OtpAuthenticable
{
    /**
     * Determine the otp token for a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function otpToken()
    {
        return $this->morphOne(OtpToken::class, 'otpAuthenticable', 'otp_authenticable_type', 'otp_authenticable_id');
    }

    /**
     * Send otp notification.
     *
     * @return void
     */
    public function sendOtpAuthenticationNotification()
    {
        $otpToken = $this->otpToken()->updateOrCreate(
            ['otp_authenticable_id' => $this->id, 'otp_authenticable_type' => get_class($this)],
            ['otp' => OtpToken::generateOTP(), 'expires_at' => Carbon::now()->addMinutes(OtpAuthentication::getOtpExpireDuration())]
        );
        if (! OtpAuthentication::getIsBlockSms()) {
            $this->notify(new VerifyPhone($otpToken->otp));
        }
    }

    /**
     * Send otp notification.
     *
     * @return array
     */
    public function otpLogin($otp, $guard = "users")
    {
        $otpToken = $this->otpToken;

        $response = OtpAuthentication::isOtpAuthenticable($otpToken, $otp);
        if ($response['status']) {
            Auth::guard($guard)->login($this, $remember = true);

            return ["status" => true, "message" => AuthStatusMessage::getAuthenticationSuccessfulMessage()];
        }

        return $response;
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

    /**
     * Send otp notification.
     *
     * @return OTPAuthenticable
     */
    public static function findUserByPhone($phone, $attribute = "phone")
    {
        try {
            $className = get_called_class();
            $tableName = with(new $className)->getTable();
            if (! Schema::hasColumn($tableName, $attribute)) {
                throw new ColumnNotFoundException($attribute);
            }
            $user = $className::where($attribute, $phone)->first();

            return $user;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
