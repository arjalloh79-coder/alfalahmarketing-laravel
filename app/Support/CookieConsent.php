<?php

namespace App\Support;

use Illuminate\Support\Facades\Cookie;

/**
 * Cookie consent manager.
 *
 * Stores user's tracking consent choice in a first-party cookie.
 * Cookie persists for 1 year.
 */
class CookieConsent
{
    private const COOKIE_NAME = 'tracking_consent';
    private const COOKIE_LIFETIME = 60 * 24 * 365; // 1 year in minutes

    /**
     * Get current consent status.
     *
     * @return 'accepted'|'rejected'|null
     */
    public static function getStatus(): ?string
    {
        return request()->cookie(self::COOKIE_NAME);
    }

    /**
     * Check if user has made a consent choice.
     */
    public static function hasChosen(): bool
    {
        return self::getStatus() !== null;
    }

    /**
     * Accept tracking consent.
     */
    public static function accept(): array
    {
        return [
            self::COOKIE_NAME => 'accepted',
            'path' => '/',
            'secure' => true,
            'httpOnly' => false, // Must be accessible to JS
            'sameSite' => 'lax',
            'expires' => now()->addMinutes(self::COOKIE_LIFETIME),
        ];
    }

    /**
     * Reject tracking consent.
     */
    public static function reject(): array
    {
        return [
            self::COOKIE_NAME => 'rejected',
            'path' => '/',
            'secure' => true,
            'httpOnly' => false, // Must be accessible to JS
            'sameSite' => 'lax',
            'expires' => now()->addMinutes(self::COOKIE_LIFETIME),
        ];
    }

    /**
     * Get cookie name (for JS access).
     */
    public static function cookieName(): string
    {
        return self::COOKIE_NAME;
    }
}
