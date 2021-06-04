<?php

namespace Owaslo\OtpAuthentication;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Owaslo\OtpAuthentication\Commands\OtpAuthenticationCommand;

class OtpAuthenticationServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-otp-authentication')
            ->hasMigration('create_otp_tokens_table');
    }
}
