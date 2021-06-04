<?php

namespace Owaslo\OtpAuthentication\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        return $this->morphTo();
    }

    public static function generateOTP()
    {
        $factory = new RandomLibFactory();
        $generator = $factory->getLowStrengthGenerator();

        return $generator->generateInt(1000, 9999);
    }
}
