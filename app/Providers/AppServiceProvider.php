<?php

namespace App\Providers;

use App\Support\AuditContentFix;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Canonical URLs must be apex even if production .env still has www.
        URL::forceRootUrl('https://al-falahmarketing.com');
        URL::forceScheme('https');

        AuditContentFix::run();
    }
}
