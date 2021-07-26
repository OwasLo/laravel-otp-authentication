<?php

namespace Owaslo\OtpAuthentication\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Owaslo\OtpAuthentication\OtpAuthentication;
use RandomLib\Factory as RandomLibFactory;

class OtpToken extends Model
{
    use HasFactory;

    // Disable Laravel's mass assignment protection
    protected $guarded = [];

    /**
     * Get the parent otp authenticable model.
     */
    public function otpAuthenticable()
    {
        return $this->morphTo(__FUNCTION__, 'otp_authenticable_type', 'otp_authenticable_id');
    }

    public static function generateOTP()
    {
        $factory = new RandomLibFactory();
        $generator = $factory->getLowStrengthGenerator();

        //return $generator->generateString(OtpAuthentication::getOtpLength(), OtpAuthentication::getOtpCharacters());
        return "12345";
    }
}
