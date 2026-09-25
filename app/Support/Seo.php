<?php

namespace App\Support;

/**
 * Builds JSON-LD structured-data arrays. Mirrors App\Support\Contact's
 * pattern: one place to hold this data instead of duplicating it in Blade
 * files. Business facts (addresses, hours, socials) come from the audit
 * brief, not invented.
 */
class Seo
{
    public static function organization(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'ProfessionalService',
            'name' => 'Al-Falah Marketing',
            'url' => url('/'),
            'logo' => asset('assets/images/og-default.jpg'),
            'image' => asset('assets/images/og-default.jpg'),
            'email' => Contact::EMAIL,
            'sameAs' => [
                'https://www.facebook.com/profile.php?id=61573274222922',
                'https://www.instagram.com/alfalahmarketinginc/',
                'https://www.linkedin.com/company/al-falah-marketing-inc/',
                'https://youtube.com/@al-falahmarketing-official',
            ],
            'areaServed' => ['GN', 'SL', 'US'],
            'knowsLanguage' => ['fr', 'en'],
            'department' => self::localBusinesses(),
        ];
    }

    public static function localBusinesses(): array
    {
        $hours = [
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday'],
                'opens' => '08:00',
                'closes' => '16:30',
            ],
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Saturday', 'Sunday'],
                'opens' => '10:00',
                'closes' => '17:00',
            ],
        ];

        return [
            [
                '@type' => 'LocalBusiness',
                'name' => 'Al-Falah Marketing — Guinea',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Conakry / Coyah',
                    'addressCountry' => 'GN',
                ],
                'telephone' => Contact::GUINEA_NUMBER_DISPLAY,
                'openingHoursSpecification' => $hours,
            ],
            [
                '@type' => 'LocalBusiness',
                'name' => 'Al-Falah Marketing — USA',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => '8468 Winding Trail',
                    'addressLocality' => 'Laurel',
                    'addressRegion' => 'MD',
                    'postalCode' => '20724',
                    'addressCountry' => 'US',
                ],
                'telephone' => Contact::US_NUMBER_DISPLAY,
                'openingHoursSpecification' => $hours,
            ],
        ];
    }

    public static function service(string $name, string $description): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'serviceType' => $name,
            'description' => $description,
            'provider' => [
                '@type' => 'ProfessionalService',
                'name' => 'Al-Falah Marketing',
                'url' => url('/'),
            ],
            'areaServed' => ['Guinea', 'Sierra Leone', 'USA'],
        ];
    }

    public static function article(\App\Models\Blog $blog): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $blog->title,
            'author' => [
                '@type' => 'Person',
                'name' => $blog->author ?: 'Abdulrahman Jalloh',
            ],
            'datePublished' => $blog->created_at?->toAtomString(),
            'dateModified' => $blog->updated_at?->toAtomString(),
            'image' => asset('storage/public/' . $blog->image),
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Al-Falah Marketing',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('assets/images/og-default.jpg'),
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => route('blog.show', $blog->slug),
            ],
        ];
    }

    /**
     * @param array<string, string|null> $items name => url (null for the
     * current/last page, which has no link).
     */
    public static function breadcrumbs(array $items): array
    {
        $position = 0;
        $listItems = [];

        foreach ($items as $name => $url) {
            $entry = ['@type' => 'ListItem', 'position' => ++$position, 'name' => $name];
            if ($url) {
                $entry['item'] = $url;
            }
            $listItems[] = $entry;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ];
    }

    public static function jsonLd(array $data): string
    {
        return '<script type="application/ld+json">'
            . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            . '</script>';
    }
}
