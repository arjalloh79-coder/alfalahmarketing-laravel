<!-- Language Switcher Component -->
<div class="language-switcher flex items-center gap-2">
    @php
        $currentLocale = app()->getLocale();
        $currentPath = request()->path();

        // Generate URLs for EN and FR
        if (str_starts_with($currentPath, 'fr/')) {
            // Currently on /fr/something - remove fr prefix for EN
            $enPath = '/' . substr($currentPath, 3);
            $frPath = '/' . $currentPath;
        } elseif ($currentPath === 'fr') {
            // Currently on /fr root - go to / for EN
            $enPath = '/';
            $frPath = '/fr';
        } else {
            // Currently on EN path - add fr prefix for FR
            $enPath = '/' . $currentPath;
            $frPath = $currentPath === '/' ? '/fr' : '/fr/' . ltrim($currentPath, '/');
        }
    @endphp

    <!-- English Button -->
    <a href="{{ url($enPath) }}"
       class="lang-switcher-btn px-3 py-2 rounded transition-all text-sm font-medium
              {{ $currentLocale === 'en'
                 ? 'bg-primary text-white'
                 : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
       aria-label="Switch to English"
       title="English">
        <span class="mr-1">🇬🇧</span>EN
    </a>

    <!-- French Button -->
    <a href="{{ url($frPath) }}"
       class="lang-switcher-btn px-3 py-2 rounded transition-all text-sm font-medium
              {{ $currentLocale === 'fr'
                 ? 'bg-primary text-white'
                 : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
       aria-label="Switch to French"
       title="Français">
        <span class="mr-1">🇫🇷</span>FR
    </a>
</div>

<style>
.language-switcher {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.lang-switcher-btn {
    white-space: nowrap;
}

/* Mobile: stack vertically */
@media (max-width: 768px) {
    .language-switcher {
        flex-direction: column;
        gap: 0.25rem;
    }

    .lang-switcher-btn {
        width: 100%;
        text-align: center;
    }
}
</style>
