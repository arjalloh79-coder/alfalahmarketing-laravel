<!-- Hreflang Alternates for Multilingual SEO -->
@php
    $root = rtrim(request()->root(), '/');
    $currentPath = request()->path();

    // Generate correct URLs for both languages
    if (str_starts_with($currentPath, 'fr/')) {
        // Currently on /fr/something
        $enUrl = $root . '/' . substr($currentPath, 3);
        $frUrl = $root . '/' . $currentPath;
    } elseif ($currentPath === 'fr') {
        // Currently on /fr root
        $enUrl = $root;
        $frUrl = $root . '/fr';
    } else {
        // Currently on EN path (including root /)
        if ($currentPath === '') {
            // Root homepage
            $enUrl = $root;
            $frUrl = $root . '/fr';
        } else {
            // Other EN pages
            $enUrl = $root . '/' . $currentPath;
            $frUrl = $root . '/fr/' . ltrim($currentPath, '/');
        }
    }
@endphp

<!-- English alternate link -->
<link rel="alternate" hreflang="en" href="{{ $enUrl }}">

<!-- French alternate link -->
<link rel="alternate" hreflang="fr" href="{{ $frUrl }}">

<!-- x-default hreflang for undeclared languages (defaults to EN) -->
<link rel="alternate" hreflang="x-default" href="{{ $enUrl }}">
