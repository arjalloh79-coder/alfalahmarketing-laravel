<!-- Language Switcher Component -->
<div class="language-switcher flex items-center gap-2">
    @php
        $currentLocale = app()->getLocale();
        $langs = LaravelLocalization::getSupportedLocales();
    @endphp

    @foreach($langs as $langKey => $lang)
        @php
            $isActive = $currentLocale === $langKey;
            $url = LaravelLocalization::getLocalizedURL($langKey);
            $flag = $langKey === 'en' ? '🇬🇧' : '🇫🇷';
            $label = $langKey === 'en' ? 'EN' : 'FR';
        @endphp

        <a href="{{ $url }}"
           class="lang-switcher-btn px-3 py-2 rounded transition-all text-sm font-medium
                  {{ $isActive 
                     ? 'bg-primary text-white' 
                     : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
           aria-label="Switch to {{ $lang['name'] }}"
           title="Switch to {{ $lang['name'] }}">
            <span class="mr-1">{{ $flag }}</span>{{ $label }}
        </a>
    @endforeach
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
