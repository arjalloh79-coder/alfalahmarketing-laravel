<!-- Hreflang Alternates for Multilingual SEO -->
@php
    $currentPath = request()->path();

    // Generate correct URLs for both languages
    if (str_starts_with($currentPath, 'fr/')) {
        // Currently on /fr/something
        $enUrl = url('/' . substr($currentPath, 3));
        $frUrl = url('/' . $currentPath);
    } elseif ($currentPath === 'fr') {
        // Currently on /fr root
        $enUrl = url('/');
        $frUrl = url('/fr');
    } else {
        // Currently on EN path
        $enUrl = url('/' . $currentPath);
        $frUrl = $currentPath === '' ? url('/fr') : url('/fr/' . ltrim($currentPath, '/'));
    }
@endphp

<!-- English alternate link -->
<link rel="alternate" hreflang="en" href="{{ $enUrl }}">

<!-- French alternate link -->
<link rel="alternate" hreflang="fr" href="{{ $frUrl }}">

<!-- x-default hreflang for undeclared languages (defaults to EN) -->
<link rel="alternate" hreflang="x-default" href="{{ $enUrl }}">
