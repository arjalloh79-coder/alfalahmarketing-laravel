<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Security headers for every page Laravel renders.
 *
 * The same headers are also set in the root .htaccess (which covers static
 * files too). This middleware is the fallback in case Hostinger's setup
 * doesn't apply .htaccess headers to PHP responses.
 */
class SecurityHeaders
{
    private const HEADERS = [
        'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
        'X-Frame-Options' => 'SAMEORIGIN',
        'X-Content-Type-Options' => 'nosniff',
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
        'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        foreach (self::HEADERS as $name => $value) {
            // HSTS only means anything over HTTPS; browsers ignore it on HTTP.
            if ($name === 'Strict-Transport-Security' && ! $request->secure()) {
                continue;
            }
            $response->headers->set($name, $value);
        }

        // Stop leaking the PHP version (e.g. "PHP/8.4.19").
        $response->headers->remove('X-Powered-By');
        if (! headers_sent()) {
            header_remove('X-Powered-By');
        }

        return $response;
    }
}
