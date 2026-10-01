<!-- Cookie Consent Banner (Lightweight, no JS library) -->
@php
    $lang = app()->getLocale();
    $consent = \App\Support\CookieConsent::getStatus();
@endphp

@if(!$consent)
<div id="cookieConsentBanner" class="fixed bottom-0 left-0 right-0 bg-dark text-white p-4 shadow-lg z-40">
    <div class="max-w-6xl mx-auto flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
        <!-- Content -->
        <div class="flex-1">
            @if($lang === 'fr')
                <p class="text-sm mb-2">
                    <strong>Conformité aux cookies</strong> — Nous utilisons Google Analytics, Meta Pixel et Microsoft Clarity pour améliorer votre expérience.
                    <a href="{{ route('privacy.policy') }}" class="text-primary hover:underline">Politique de confidentialité</a>
                </p>
            @else
                <p class="text-sm mb-2">
                    <strong>Cookie Consent</strong> — We use Google Analytics, Meta Pixel, and Microsoft Clarity to improve your experience.
                    <a href="{{ route('privacy.policy') }}" class="text-primary hover:underline">Privacy Policy</a>
                </p>
            @endif
        </div>

        <!-- Buttons -->
        <div class="flex gap-3">
            <button id="rejectConsent" class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700 transition-colors">
                {{ $lang === 'fr' ? 'Refuser' : 'Reject' }}
            </button>
            <button id="acceptConsent" class="px-4 py-2 bg-primary text-white rounded-md text-sm hover:bg-blue-600 transition-colors font-bold">
                {{ $lang === 'fr' ? 'Accepter' : 'Accept' }}
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const banner = document.getElementById('cookieConsentBanner');
    const acceptBtn = document.getElementById('acceptConsent');
    const rejectBtn = document.getElementById('rejectConsent');

    // Handle accept
    if (acceptBtn) {
        acceptBtn.addEventListener('click', function() {
            fetch('{{ route("consent.accept") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                banner.remove();
                // Reload to load tracking scripts
                window.location.reload();
            });
        });
    }

    // Handle reject
    if (rejectBtn) {
        rejectBtn.addEventListener('click', function() {
            fetch('{{ route("consent.reject") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                banner.remove();
            });
        });
    }
});
</script>
@endif
