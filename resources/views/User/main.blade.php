<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', trans('pages.home_hero_title') . ' | Al-Falah Marketing')</title>
    <meta name="description" content="@yield('description', trans('pages.home_hero_subtitle'))">
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

    <!-- Hreflang alternates for multilingual SEO -->
    @include('components.hreflang-alternates')
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

    <!-- Tracking Scripts (GA4, Meta Pixel, Clarity) -->
    @include('components.tracking-scripts')

    <!-- WhatsApp Click Tracking -->
    @include('components.whatsapp-tracking')

    <!-- Cookie Consent Banner -->
    @include('components.cookie-consent-banner')

</body>
</html>