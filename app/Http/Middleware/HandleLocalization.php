<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HandleLocalization
{
    public function handle(Request $request, Closure $next)
    {
        // Get locale from URL segment
        $locale = $request->segment(1);

        if (in_array($locale, ['en', 'fr'])) {
            // Route is /fr/... or /en/...
            app()->setLocale($locale);
            Session::put('locale', $locale);
        } else {
            // Root route or non-localized - default to English
            app()->setLocale('en');
            if (!Session::has('locale')) {
                Session::put('locale', 'en');
            }
        }

        return $next($request);
    }
}
