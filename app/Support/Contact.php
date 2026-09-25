<?php

namespace App\Support;

/**
 * Central source of truth for Al-Falah Marketing's contact details, so a
 * phone number or WhatsApp link never has to be hard-coded in a Blade file.
 * Add new numbers/locations here, not in templates.
 */
class Contact
{
    public const EMAIL = 'info@al-falahmarketing.com';

    public const GUINEA_NUMBER_DISPLAY = '+224 611 351 302';
    public const GUINEA_NUMBER_WA = '224611351302'; // digits only, no + — wa.me format

    public const US_NUMBER_DISPLAY = '+1 240-280-6137';
    public const US_NUMBER_WA = '12402806137'; // digits only, no + — wa.me format

    public const GUINEA_ADDRESS = 'Conakry / Coyah, Guinea';
    public const US_ADDRESS = '8468 Winding Trail, Laurel, MD 20724';

    public const HOURS_WEEKDAY = 'Mon–Thu 8:00–16:30';
    public const HOURS_WEEKEND = 'Sat–Sun 10:00–17:00';
    public const HOURS_CLOSED = 'Friday closed';

    /**
     * WhatsApp number to lead with for the current locale: Guinea (FR) or US (EN).
     */
    public static function whatsappNumber(): string
    {
        return app()->getLocale() === 'fr' ? self::GUINEA_NUMBER_WA : self::US_NUMBER_WA;
    }

    public static function whatsappDisplay(): string
    {
        return app()->getLocale() === 'fr' ? self::GUINEA_NUMBER_DISPLAY : self::US_NUMBER_DISPLAY;
    }

    /**
     * A ready-to-use wa.me URL. Pass a page-specific message; falls back to
     * a generic greeting in the current locale. Always rawurlencode()'d so
     * spaces/apostrophes never break in-app browsers.
     */
    public static function whatsappUrl(?string $message = null): string
    {
        $message = $message ?? self::defaultMessage();

        return 'https://wa.me/' . self::whatsappNumber() . '?text=' . rawurlencode($message);
    }

    public static function defaultMessage(): string
    {
        return app()->getLocale() === 'fr'
            ? 'Bonjour Al-Falah, je souhaite en savoir plus sur vos services.'
            : "Hello Al-Falah, I'd like to learn more about your services.";
    }
}
