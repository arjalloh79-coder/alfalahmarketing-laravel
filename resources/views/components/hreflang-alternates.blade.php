<!-- Hreflang Alternates for Multilingual SEO -->
@php
    $currentUrl = url()->current();
    $currentLocale = app()->getLocale();
    
    // Get all supported locales
    $langs = LaravelLocalization::getSupportedLocales();
@endphp

@foreach($langs as $langKey => $lang)
    @php
        // Generate localized URL for this language
        $localizedUrl = LaravelLocalization::getLocalizedURL($langKey, $currentUrl);
    @endphp
    <link rel="alternate" hreflang="{{ $langKey }}" href="{{ $localizedUrl }}">
@endforeach

<!-- x-default hreflang for undeclared languages (defaults to EN) -->
<link rel="alternate" hreflang="x-default" href="{{ LaravelLocalization::getLocalizedURL('en', $currentUrl) }}">
