<!-- Hreflang Alternates for Multilingual SEO -->
@php
    $baseUrl = 'https://al-falahmarketing.com';
    $currentPath = request()->path();

    // Generate correct URLs for both languages
    if (str_starts_with($currentPath, 'fr/')) {
        // Currently on /fr/something
        $enPath = substr($currentPath, 3);
        $enUrl = $baseUrl . '/' . $enPath;
        $frUrl = $baseUrl . '/' . $currentPath;
    } elseif ($currentPath === 'fr') {
        // Currently on /fr root
        $enUrl = $baseUrl;
        $frUrl = $baseUrl . '/fr';
    } else {
        // Currently on EN path (including root /)
        if ($currentPath === '' || $currentPath === '/') {
            // Root homepage
            $enUrl = $baseUrl;
            $frUrl = $baseUrl . '/fr';
        } else {
            // Other EN pages
            $enUrl = $baseUrl . '/' . $currentPath;
            $frUrl = $baseUrl . '/fr/' . ltrim($currentPath, '/');
        }
    }
@endphp

<!-- English alternate link -->
<link rel="alternate" hreflang="en" href="{{ $enUrl }}">

<!-- French alternate link -->
<link rel="alternate" hreflang="fr" href="{{ $frUrl }}">

<!-- x-default hreflang for undeclared languages (defaults to EN) -->
<link rel="alternate" hreflang="x-default" href="{{ $enUrl }}">
