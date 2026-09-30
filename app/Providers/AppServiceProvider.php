<?php

namespace App\Providers;

use App\Support\AuditContentFix;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
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

        // Hostinger's document root is the project root, not public/, so the
        // Vite build in public/build/ is reached at /public/build/... (same as
        // the existing /public/assets/... files). Remove this if the document
        // root is ever repointed to public/ (see MANUAL-TASKS.md).
        Vite::createAssetPathsUsing(fn (string $path, ?bool $secure = null) => asset('public/'.$path, $secure));
    }
}
