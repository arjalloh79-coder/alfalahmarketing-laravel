{{--
    Unified contact block: both offices, both phones, email and hours.
    Used on the homepage contact section, the Contact page, and the footer
    so the same information never drifts out of sync across pages.

    Props:
      $style = 'light' (default, icon boxes on a white/muted background — homepage/Contact page)
             | 'dark'  (compact list for the dark footer)
--}}
@php($style = $style ?? 'light')

@if ($style === 'dark')
    <ul class="space-y-3 text-gray-400">
        <li class="flex items-start">
            <i class="fab fa-whatsapp mt-1 mr-3 text-primary"></i>
            <span>
                <a href="tel:+224611351302" class="hover:text-primary transition-colors">{{ \App\Support\Contact::GUINEA_NUMBER_DISPLAY }}</a>
                <span class="text-xs">(WhatsApp, Guinea)</span>
            </span>
        </li>
        <li class="flex items-start">
            <i class="fas fa-phone mt-1 mr-3 text-primary"></i>
            <a href="tel:+12402806137" class="hover:text-primary transition-colors">{{ \App\Support\Contact::US_NUMBER_DISPLAY }}</a>
            <span class="text-xs ml-1">(USA)</span>
        </li>
        <li class="flex items-start">
            <i class="fas fa-envelope mt-1 mr-3 text-primary"></i>
            <a href="mailto:{{ \App\Support\Contact::EMAIL }}" class="hover:text-primary transition-colors">{{ \App\Support\Contact::EMAIL }}</a>
        </li>
        <li class="flex items-start">
            <i class="fas fa-clock mt-1 mr-3 text-primary"></i>
            <span>{{ \App\Support\Contact::HOURS_WEEKDAY }} &middot; {{ \App\Support\Contact::HOURS_WEEKEND }} &middot; {{ \App\Support\Contact::HOURS_CLOSED }}</span>
        </li>
    </ul>
@else
    <div class="space-y-6">
        <div class="flex items-start">
            <div class="w-14 h-14 bg-primary rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fab fa-whatsapp text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h4 class="font-bold text-dark mb-1">Guinea (WhatsApp)</h4>
                <a href="tel:+224611351302" class="text-gray-600 hover:text-primary transition-colors">{{ \App\Support\Contact::GUINEA_NUMBER_DISPLAY }}</a>
                <p class="text-gray-500 text-sm">{{ \App\Support\Contact::GUINEA_ADDRESS }}</p>
            </div>
        </div>

        <div class="flex items-start">
            <div class="w-14 h-14 bg-secondary rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-phone text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h4 class="font-bold text-dark mb-1">USA</h4>
                <a href="tel:+12402806137" class="text-gray-600 hover:text-primary transition-colors">{{ \App\Support\Contact::US_NUMBER_DISPLAY }}</a>
                <p class="text-gray-500 text-sm">{{ \App\Support\Contact::US_ADDRESS }}</p>
            </div>
        </div>

        <div class="flex items-start">
            <div class="w-14 h-14 bg-accent rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-envelope text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h4 class="font-bold text-dark mb-1">Email</h4>
                <a href="mailto:{{ \App\Support\Contact::EMAIL }}" class="text-gray-600 hover:text-primary transition-colors">{{ \App\Support\Contact::EMAIL }}</a>
            </div>
        </div>

        <div class="flex items-start">
            <div class="w-14 h-14 bg-dark rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-clock text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h4 class="font-bold text-dark mb-1">Hours</h4>
                <p class="text-gray-600">{{ \App\Support\Contact::HOURS_WEEKDAY }} &middot; {{ \App\Support\Contact::HOURS_WEEKEND }}</p>
                <p class="text-gray-500 text-sm">{{ \App\Support\Contact::HOURS_CLOSED }}</p>
            </div>
        </div>
    </div>
@endif
