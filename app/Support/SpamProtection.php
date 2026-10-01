<?php

namespace App\Support;

use Illuminate\Http\Request;

/**
 * Spam protection using honeypot + time-trap, and optional Cloudflare Turnstile.
 *
 * Honeypot: Hidden field that should remain empty. Bots fill it.
 * Time-trap: Form submission must take > 3 seconds. Bots are fast.
 * Turnstile: Optional CAPTCHA when TURNSTILE_SITE_KEY is configured.
 */
class SpamProtection
{
    private const HONEYPOT_FIELD = 'website_url';
    private const TIMESTAMP_FIELD = 'form_timestamp';
    private const MIN_SUBMISSION_TIME = 3; // seconds

    /**
     * Validate a form submission for spam signals.
     * Throws exception if spam is detected.
     */
    public static function validate(Request $request): bool
    {
        // Check honeypot
        if (! static::checkHoneypot($request)) {
            return false;
        }

        // Check time-trap
        if (! static::checkTimeTrap($request)) {
            return false;
        }

        // Check Cloudflare Turnstile if enabled
        if (config('app.turnstile_enabled')) {
            if (! static::checkTurnstile($request)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check honeypot field (should be empty).
     */
    private static function checkHoneypot(Request $request): bool
    {
        $honeypot = $request->input(static::HONEYPOT_FIELD);

        // If honeypot is filled, it's a bot
        if (! empty($honeypot)) {
            return false;
        }

        return true;
    }

    /**
     * Check time-trap (form must take min time to fill).
     */
    private static function checkTimeTrap(Request $request): bool
    {
        $timestamp = $request->input(static::TIMESTAMP_FIELD);

        if (! $timestamp) {
            return false;
        }

        // Timestamp is microtime when form was rendered
        $timeElapsed = microtime(true) - floatval($timestamp);

        // Form submission too fast (< 3 seconds) = likely bot
        if ($timeElapsed < static::MIN_SUBMISSION_TIME) {
            return false;
        }

        return true;
    }

    /**
     * Validate Cloudflare Turnstile CAPTCHA response.
     */
    private static function checkTurnstile(Request $request): bool
    {
        $token = $request->input('cf-turnstile-response');

        if (! $token) {
            return false;
        }

        $siteKey = config('app.turnstile_site_key');
        $secretKey = config('app.turnstile_secret_key');

        if (! $secretKey) {
            return false; // Secret key not configured
        }

        try {
            $response = \Illuminate\Support\Facades\Http::asForm()
                ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => $secretKey,
                    'response' => $token,
                ])
                ->json();

            return $response['success'] ?? false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get honeypot field name.
     */
    public static function honeypotField(): string
    {
        return static::HONEYPOT_FIELD;
    }

    /**
     * Get timestamp field name.
     */
    public static function timestampField(): string
    {
        return static::TIMESTAMP_FIELD;
    }

    /**
     * Check if Turnstile is enabled.
     */
    public static function isTurnstileEnabled(): bool
    {
        return ! empty(config('app.turnstile_site_key'));
    }

    /**
     * Get Turnstile site key.
     */
    public static function getTurnstileSiteKey(): ?string
    {
        return config('app.turnstile_site_key');
    }
}
