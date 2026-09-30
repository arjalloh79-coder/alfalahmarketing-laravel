<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Digital Marketing Agency - Transform Your Brand')</title>
    <meta name="description" content="@yield('description', 'Web design, SEO, ads & AI automation for SMBs in Guinea, Sierra Leone and the USA. Bilingual FR/EN team.')">
    @yield('robots')
    {{--
        @section('name', 'literal string') auto-escapes its content (Laravel's
        Factory::startSection does this), the same way the <title> @yield above
        already relies on. So everything below is echoed raw with {!! !!} / @yield,
        never {{ }} — wrapping already-escaped content in {{ }} would escape it
        twice (e.g. "Guinea & USA" -> "Guinea &amp;amp; USA").
    --}}
    @php
        $ogTitle = trim($__env->yieldContent('og_title')) ?: trim($__env->yieldContent('title', 'Digital Marketing Agency - Transform Your Brand'));
        $ogDescription = trim($__env->yieldContent('og_description')) ?: trim($__env->yieldContent('description', 'Web design, SEO, ads & AI automation for SMBs in Guinea, Sierra Leone and the USA. Bilingual FR/EN team.'));
        $canonical = trim($__env->yieldContent('canonical')) ?: e(url()->current());
        $ogImage = trim($__env->yieldContent('og_image')) ?: e(asset('assets/images/og-default.jpg'));
        $ogType = trim($__env->yieldContent('og_type')) ?: 'website';

        // Auto BreadcrumbList for every page except Home — no per-page
        // work needed. Service subpages and the blog post page get a
        // 3-level trail (Home > section > page); everything else gets
        // Home > page.
        $routeName = request()->route()?->getName();
        $currentLabel = html_entity_decode($ogTitle, ENT_QUOTES);
        if ($routeName && $routeName !== 'home') {
            $breadcrumbItems = ['Home' => route('home')];
            if (str_starts_with($routeName, 'services.')) {
                $breadcrumbItems['Services'] = route('service');
            } elseif ($routeName === 'blog.show') {
                $breadcrumbItems['Blog'] = route('blog');
            }
            $breadcrumbItems[$currentLabel] = null;
        }
    @endphp
    @if (!empty($breadcrumbItems))
        @push('jsonld')
            {!! \App\Support\Seo::jsonLd(\App\Support\Seo::breadcrumbs($breadcrumbItems)) !!}
        @endpush
    @endif
    <link rel="canonical" href="{!! $canonical !!}">

    <!-- Open Graph -->
    <meta property="og:title" content="{!! $ogTitle !!}">
    <meta property="og:description" content="{!! $ogDescription !!}">
    <meta property="og:image" content="{!! $ogImage !!}">
    <meta property="og:url" content="{!! $canonical !!}">
    <meta property="og:type" content="{!! $ogType !!}">
    <meta property="og:site_name" content="Al-Falah Marketing">
    <meta property="og:locale" content="{{ app()->getLocale() === 'fr' ? 'fr_GN' : 'en_US' }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{!! $ogTitle !!}">
    <meta name="twitter:description" content="{!! $ogDescription !!}">
    <meta name="twitter:image" content="{!! $ogImage !!}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/apple-touch-icon.png') }}">

    <!-- Google Fonts - Outfit (only the weights the site uses) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Compiled Tailwind + site styles (resources/css/app.css, built with `npm run build`) -->
    @vite('resources/css/app.css')

    <!-- Font Awesome: loaded without blocking first paint -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    
    @yield('styles')

    @stack('jsonld')
</head>
<body class="antialiased">
    
    @include('User.header')
    
    <main>
        @yield('main-section')
    </main>
    
  @unless(
    request()->routeIs('user.dashboard') ||
    request()->routeIs('admin.dashboard') ||
    request()->routeIs('user.domains.index')
)
    @include('User.footer')
@endunless
    
    @yield('scripts')

    <div id="google_translate_element" style="display:none;"></div>

<script>
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,fr',
        autoDisplay: false
    }, 'google_translate_element');
}

function setLanguage(lang) {
    if (lang === 'en') {
        // Clear Google Translate cookie
        document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=" + window.location.hostname;
        document.cookie = "lang=en; path=/; max-age=" + (30 * 24 * 60 * 60);
    } else {
        // Set Google Translate cookie
        document.cookie = "googtrans=/en/" + lang + "; path=/;";
        document.cookie = "googtrans=/en/" + lang + "; path=/; domain=" + window.location.hostname;
        document.cookie = "lang=" + lang + "; path=/; max-age=" + (30 * 24 * 60 * 60);
    }
    localStorage.setItem('lang', lang);
    window.location.reload();
}

function updateLanguageUI() {
    // Determine language, defaulting to en
    let lang = localStorage.getItem('lang') || 'en';
    
    // Double check cookies
    let match = document.cookie.match(new RegExp('(^| )googtrans=([^;]+)'));
    if (match) {
        let val = decodeURIComponent(match[2]);
        let parts = val.split('/');
        if (parts.length >= 3) {
            lang = parts[2].toLowerCase();
        }
    }

    // Set HTML lang attribute
    document.documentElement.lang = lang;

    // Highlight desktop buttons
    const btnEn = document.getElementById('lang-btn-en');
    const btnFr = document.getElementById('lang-btn-fr');
    if (btnEn && btnFr) {
        if (lang === 'fr') {
            btnFr.classList.add('bg-primary', 'text-white');
            btnFr.classList.remove('hover:bg-gray-200');
            btnEn.classList.remove('bg-primary', 'text-white');
            btnEn.classList.add('hover:bg-gray-200');
        } else {
            btnEn.classList.add('bg-primary', 'text-white');
            btnEn.classList.remove('hover:bg-gray-200');
            btnFr.classList.remove('bg-primary', 'text-white');
            btnFr.classList.add('hover:bg-gray-200');
        }
    }

    // Highlight mobile buttons
    const mBtnEn = document.getElementById('mobile-lang-btn-en');
    const mBtnFr = document.getElementById('mobile-lang-btn-fr');
    if (mBtnEn && mBtnFr) {
        if (lang === 'fr') {
            mBtnFr.classList.add('bg-primary', 'text-white');
            mBtnFr.classList.remove('border-gray-300', 'bg-white');
            mBtnEn.classList.remove('bg-primary', 'text-white');
            mBtnEn.classList.add('border-gray-300', 'bg-white');
        } else {
            mBtnEn.classList.add('bg-primary', 'text-white');
            mBtnEn.classList.remove('bg-primary', 'text-white');
            mBtnEn.classList.add('border-gray-300', 'bg-white');
            mBtnFr.classList.remove('bg-primary', 'text-white');
            mBtnFr.classList.add('border-gray-300', 'bg-white');
        }
    }
}

// Run language UI update immediately
document.addEventListener('DOMContentLoaded', updateLanguageUI);
if (document.readyState === 'interactive' || document.readyState === 'complete') {
    updateLanguageUI();
}
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
</body>
</html>