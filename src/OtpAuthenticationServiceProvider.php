<?php

namespace Owaslo\OtpAuthentication;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasConfigFile()
            ->hasMigration('create_otp_tokens_table');
    }
}
