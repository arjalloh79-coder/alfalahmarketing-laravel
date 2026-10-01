<?php

namespace App\Support;

/**
 * Tracking service for GA4, Meta Pixel, Microsoft Clarity.
 *
 * Loads only when:
 * 1. Corresponding .env ID is set
 * 2. User has given consent (checked via cookie)
 *
 * Events are fired via JavaScript after page load.
 */
class Tracking
{
    /**
     * Check if user has given analytics consent.
     */
    public static function hasConsent(): bool
    {
        $consent = request()->cookie('tracking_consent');
        return $consent === 'accepted';
    }

    /**
     * Get GA4 measurement ID (if configured).
     */
    public static function getGA4MeasurementId(): ?string
    {
        return config('app.ga4_measurement_id');
    }

    /**
     * Get Meta Pixel ID (if configured).
     */
    public static function getMetaPixelId(): ?string
    {
        return config('app.meta_pixel_id');
    }

    /**
     * Get Microsoft Clarity project ID (if configured).
     */
    public static function getClarityProjectId(): ?string
    {
        return config('app.clarity_project_id');
    }

    /**
     * Check if any tracking is configured.
     */
    public static function isTrackerConfigured(): bool
    {
        return (bool) (
            static::getGA4MeasurementId() ||
            static::getMetaPixelId() ||
            static::getClarityProjectId()
        );
    }

    /**
     * Fire a tracking event (client-side via JavaScript).
     * Used in Blade templates via @push('scripts').
     */
    public static function fireEvent(string $event, array $data = []): string
    {
        $jsonData = json_encode($data);

        return <<<JS
        <script>
        (function() {
            const fireEvent = () => {
                // GA4
                if (typeof gtag !== 'undefined') {
                    gtag('event', '$event', $jsonData);
                }
                // Meta Pixel
                if (typeof fbq !== 'undefined') {
                    fbq('track', '$event', $jsonData);
                }
            };

            // Fire immediately, and also on page load for safety
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', fireEvent);
            } else {
                fireEvent();
            }
        })();
        </script>
        JS;
    }
}
