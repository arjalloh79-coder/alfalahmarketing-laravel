<footer class="bg-dark text-white">
    <!-- Main Footer Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <!-- Company Info -->
            <div>
                <div class="flex items-center space-x-2 mb-6">
                    <div class="w-10 h-10 rounded-lg overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('assets/images/alfalah.webp') }}" alt="Al-Falah Marketing Logo" width="1408" height="792" loading="lazy" decoding="async"
                            class="w-full h-full object-contain">
                    </div>

                    <span class="text-2xl font-bold tracking-tighter">
                        Al-Falah<span class="text-primary">Marketing</span>
                    </span>
                </div>
                <p class="text-gray-400 mb-6 leading-relaxed">
                    {{ trans('messages.footer_about_text') }}
                </p>
                <div class="mb-6">
                    @include('partials.contact-info', ['style' => 'dark'])
                </div>
                <div class="flex space-x-3">
                    <a href="https://www.facebook.com/profile.php?id=61573274222922" aria-label="Al-Falah Marketing on Facebook"
                        class="w-10 h-10 bg-white/10 rounded-md flex items-center justify-center text-white hover:bg-primary hover:scale-110 transition-all duration-200">
                        <i class="fab fa-facebook-f" aria-hidden="true"></i>
                    </a>
                    <a href="https://youtube.com/@al-falahmarketing-official?si=tt2bDxU_qv5g8M0o" aria-label="Al-Falah Marketing on YouTube"
                        class="w-10 h-10 bg-white/10 rounded-md flex items-center justify-center text-white hover:bg-primary hover:scale-110 transition-all duration-200">
                        <i class="fab fa-youtube" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/al-falah-marketing-inc/" aria-label="Al-Falah Marketing on LinkedIn"
                        class="w-10 h-10 bg-white/10 rounded-md flex items-center justify-center text-white hover:bg-primary hover:scale-110 transition-all duration-200">
                        <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.instagram.com/alfalahmarketinginc/" aria-label="Al-Falah Marketing on Instagram"
                        class="w-10 h-10 bg-white/10 rounded-md flex items-center justify-center text-white hover:bg-primary hover:scale-110 transition-all duration-200">
                        <i class="fab fa-instagram" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-bold mb-6 uppercase tracking-wider">{{ trans('messages.footer_services') }}</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}"
                            class="text-gray-400 hover:text-primary transition-colors font-medium">{{ trans('messages.nav_home') }}</a></li>
                    <li><a href="{{ route('about') }}"
                            class="text-gray-400 hover:text-primary transition-colors font-medium">{{ trans('messages.nav_about') }}</a></li>
                    <li><a href="{{ route('service') }}"
                            class="text-gray-400 hover:text-primary transition-colors font-medium">{{ trans('messages.nav_services') }}</a></li>
                    <li><a href=""
                            class="text-gray-400 hover:text-primary transition-colors font-medium">{{ trans('messages.nav_portfolio') }}</a></li>
                    <li><a href="{{ route('blog') }}"
                            class="text-gray-400 hover:text-primary transition-colors font-medium">{{ trans('messages.nav_blog') }}</a></li>
                    <li><a href="{{ route('contact') }}"
                            class="text-gray-400 hover:text-primary transition-colors font-medium">{{ trans('messages.nav_contact') }}</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h3 class="text-lg font-bold mb-6 uppercase tracking-wider">{{ trans('messages.footer_services') }}</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('services.web-development') }}"
                            class="text-gray-400 hover:text-primary transition-colors font-medium">{{ trans('services.web_title') }}</a>
                    </li>
                    <li><a href="{{ route('services.digital-marketing') }}"
                            class="text-gray-400 hover:text-primary transition-colors font-medium">{{ trans('services.social_title') }}</a>
                    </li>
                    <li><a href="{{ route('services.branding') }}"
                            class="text-gray-400 hover:text-primary transition-colors font-medium">{{ trans('services.branding_title') }}</a>
                    </li>
                    <li><a href="{{ route('services.automation') }}"
                            class="text-gray-400 hover:text-primary transition-colors font-medium">{{ trans('services.automation_title') }}</a>
                    </li>
                    <li><a href="{{ route('services.content') }}"
                            class="text-gray-400 hover:text-primary transition-colors font-medium">{{ trans('services.content_title') }}</a>
                    </li>
                    <li><a href="{{ route('services.solution') }}"
                            class="text-gray-400 hover:text-primary transition-colors font-medium">{{ trans('services.solutions_title') }}</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                @if (session('success'))
                    <div class="mb-3 bg-green-500 text-white px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-3 bg-red-500 text-white px-4 py-3 rounded">
                        {{ $errors->first() }}
                    </div>
                @endif
                <h3 class="text-lg font-bold mb-6 uppercase tracking-wider">{{ trans('messages.footer_subscribe_heading') }}</h3>
                <p class="text-gray-400 mb-4">{{ trans('messages.footer_subscribe_text') }}</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                    @csrf
                    @include('components.spam-protection')

                    <label for="newsletter-email" class="sr-only">Subscribe to our newsletter</label>
                    <input id="newsletter-email" type="email" name="email" placeholder="Your email" required aria-label="Your email address"
                        class="w-full h-12 bg-white/10 rounded-md px-4 text-white placeholder-gray-500 focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-primary transition-all">

                    <button type="submit"
                        class="w-full h-12 bg-primary text-white rounded-md font-bold text-sm uppercase tracking-wider transition-all duration-200 hover:scale-105 hover:bg-blue-600">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t-2 border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                <p class="text-gray-400 text-sm">
                    {{ trans('messages.footer_copyright') }}
                </p>
                <div class="flex space-x-6 text-sm">
                    <a href="{{ route('privacy.policy') }}"
                        class="text-gray-400 hover:text-primary transition-colors font-medium">{{ trans('messages.footer_privacy') }}</a>
                    <a href="{{ route('terms.conditions') }}"
                        class="text-gray-400 hover:text-primary transition-colors font-medium">{{ trans('messages.footer_terms') }}</a>
                    {{-- <a href="#" class="text-gray-400 hover:text-primary transition-colors font-medium">Cookie Policy</a> --}}
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- FLOATING WHATSAPP BUTTON -->
<a href="{{ \App\Support\Contact::whatsappUrl() }}" target="_blank"
    class="fixed bottom-8 left-8 w-16 h-16 bg-[#25D366] text-white rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-all duration-300 z-50 group">

    <!-- Pulse Effect -->
    <span
        class="absolute inline-flex h-full w-full rounded-full bg-[#25D366] opacity-75 animate-ping group-hover:hidden"></span>

    <i class="fab fa-whatsapp text-3xl relative z-10"></i>

    <!-- Tooltip -->
    <span
        class="absolute left-20 bg-white text-dark text-xs font-bold px-3 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xl whitespace-nowrap pointer-events-none">
        Chat with us!
        <span class="absolute top-1/2 -left-1 -translate-y-1/2 border-8 border-transparent border-r-white"></span>
    </span>
</a>

<!-- Scroll to Top Button -->
<button id="scrollTopBtn"
    class="fixed bottom-8 right-8 w-14 h-14 bg-primary text-white rounded-lg items-center justify-center hidden hover:scale-110 transition-all duration-200 z-50 shadow-lg">
    <i class="fas fa-arrow-up text-xl"></i>
</button>

<script>
    // Scroll to top functionality
    const scrollTopBtn = document.getElementById('scrollTopBtn');

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            scrollTopBtn.classList.remove('hidden');
            scrollTopBtn.classList.add('flex');
        } else {
            scrollTopBtn.classList.add('hidden');
            scrollTopBtn.classList.remove('flex');
        }
    });

    scrollTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>
