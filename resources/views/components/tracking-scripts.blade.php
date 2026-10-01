<!-- Tracking Scripts (GA4, Meta Pixel, Clarity) - Load only after consent -->
@php
    $tracking = new \App\Support\Tracking();
    $hasConsent = $tracking->hasConsent();
    $ga4Id = $tracking->getGA4MeasurementId();
    $pixelId = $tracking->getMetaPixelId();
    $clarityId = $tracking->getClarityProjectId();
@endphp

@if($hasConsent)
    <!-- Google Analytics 4 -->
    @if($ga4Id)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4Id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $ga4Id }}', {
                'page_path': window.location.pathname,
                'allow_google_signals': false,
                'allow_ad_personalization_signals': false
            });
        </script>
    @endif

    <!-- Meta Pixel -->
    @if($pixelId)
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $pixelId }}');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id={{ $pixelId }}&ev=PageView&noscript=1" /></noscript>
    @endif

    <!-- Microsoft Clarity -->
    @if($clarityId)
        <script type="text/javascript">
            (function(c,l,a,r,i,t,y){
                c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
                t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
                y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
            })(window, document, "clarity", "script", "{{ $clarityId }}");
        </script>
    @endif
@endif
