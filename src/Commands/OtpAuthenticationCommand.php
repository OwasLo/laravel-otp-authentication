<?php

namespace Owaslo\OtpAuthentication\Commands;

use Illuminate\Console\Command;

class OtpAuthenticationCommand extends Command
{
    public $signature = 'laravel-otp-authentication';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
