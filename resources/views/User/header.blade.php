<style>
    /* Header Styles */
    .header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        background: white;
        transition: all 200ms;
    }

    .header.scrolled {
        border-bottom: 2px solid #E5E7EB;
    }

    /* Mobile menu */
    .mobile-menu {
        transform: translateX(-100%);
        transition: transform 300ms;
    }

    .mobile-menu.active {
        transform: translateX(0);
    }
</style>

<header class="header" id="mainHeader">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <img src="{{ asset('assets/images/alfalah.webp') }}" alt="Al-Falah Marketing Logo"
                    class="h-12 w-auto object-contain transition-transform duration-200 group-hover:scale-105">

                <div>
                    <span class="text-2xl font-bold text-dark tracking-tight">
                        Al-Falah
                        <span class="text-primary">Marketing</span>
                    </span>
                </div>

            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center space-x-8">
                <a href="{{ route('home') }}"
                    class="nav-link text-sm font-semibold text-dark hover:text-primary transition-colors duration-200 uppercase tracking-wider">Home</a>
                <a href="{{ route('about') }}"
                    class="nav-link text-sm font-semibold text-dark hover:text-primary transition-colors duration-200 uppercase tracking-wider">About</a>
                <a href="{{ route('service') }}"
                    class="nav-link text-sm font-semibold text-dark hover:text-primary transition-colors duration-200 uppercase tracking-wider">Services</a>
                <a href="{{ route('portfolio') }}"
                    class="nav-link text-sm font-semibold text-dark hover:text-primary transition-colors duration-200 uppercase tracking-wider">Portfolio</a>
                <a href="{{ route('blog') }}"
                    class="nav-link text-sm font-semibold text-dark hover:text-primary transition-colors duration-200 uppercase tracking-wider">Blog</a>
                <a href="{{ route('contact') }}"
                    class="nav-link text-sm font-semibold text-dark hover:text-primary transition-colors duration-200 uppercase tracking-wider">Contact</a>
            </nav>

            <!-- Desktop Right Side Buttons / Dashboard Icon -->
            <div class="hidden lg:flex items-center space-x-4">



                <!-- Language Switch -->
    <div class="flex items-center bg-muted rounded-md overflow-hidden border border-gray-200">
        <button onclick="setLanguage('en')" id="lang-btn-en"
            class="px-3 h-10 text-xs font-bold uppercase transition">
            🇬🇧 EN
        </button>

        <button onclick="setLanguage('fr')" id="lang-btn-fr"
            class="px-3 h-10 text-xs font-bold uppercase transition">
            🇫🇷 FR
        </button>
    </div>
                @guest
                    <!-- अगर यूजर लॉग इन नहीं है तो ये बटन दिखेंगे -->
                    <a href="{{ route('login') }}"
                        class="px-6 h-12 border-2 border-primary text-primary rounded-md font-semibold text-sm uppercase tracking-wider flex items-center justify-center transition-all duration-200 hover:bg-primary hover:text-white">
                        Login
                    </a>
                    <a href="{{ route('signup') }}"
                        class="px-6 h-12 bg-primary text-white rounded-md font-semibold text-sm uppercase tracking-wider flex items-center justify-center transition-all duration-200 hover:scale-105 hover:bg-blue-600">
                      Signup
                    </a>
                @endguest

                @auth
                    <!-- अगर यूजर लॉग इन है तो केवल उसका नाम और डैशबोर्ड लिंक आइकॉन दिखेगा -->
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.index') : route('user.dashboard') }}"
                        class="flex items-center space-x-3 px-4 h-12 bg-muted hover:bg-gray-200 text-dark rounded-md font-bold text-sm uppercase tracking-wider transition-colors duration-200">
                        <div
                            class="w-8 h-8 bg-primary text-white font-bold rounded-full flex items-center justify-center text-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <i class="fas fa-arrow-right text-xs text-primary"></i>
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button class="lg:hidden w-10 h-10 bg-muted rounded-md flex items-center justify-center"
                onclick="toggleMobileMenu()">
                <i class="fas fa-bars text-dark text-xl" id="menuIcon"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu fixed top-0 left-0 w-full h-full bg-white z-50 lg:hidden" id="mobileMenu">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between p-6 border-b-2 border-gray-200">
                <span class="text-2xl font-bold text-dark tracking-tighter">MARKET<span
                        class="text-primary">PRO</span></span>
                <button class="w-10 h-10 bg-muted rounded-md flex items-center justify-center"
                    onclick="toggleMobileMenu()">
                    <i class="fas fa-times text-dark text-xl"></i>
                </button>
            </div>

            <nav class="flex-1 px-6 py-8 space-y-4 overflow-y-auto">
                <a href="{{ route('home') }}" onclick="toggleMobileMenu()"
                    class="block py-3 text-lg font-bold text-dark hover:text-primary transition-colors uppercase tracking-wider">Home</a>
                <a href="{{ route('about') }}" onclick="toggleMobileMenu()"
                    class="block py-3 text-lg font-bold text-dark hover:text-primary transition-colors uppercase tracking-wider"> About </a>
                <a href="{{ route('service') }}" onclick="toggleMobileMenu()"
                    class="block py-3 text-lg font-bold text-dark hover:text-primary transition-colors uppercase tracking-wider">Services</a>
                <a href="{{ route('portfolio') }}" onclick="toggleMobileMenu()"
                    class="block py-3 text-lg font-bold text-dark hover:text-primary transition-colors uppercase tracking-wider">Portfolio</a>
                <a href="{{ route('blog') }}" onclick="toggleMobileMenu()"
                    class="block py-3 text-lg font-bold text-dark hover:text-primary transition-colors uppercase tracking-wider">Blog</a>
                <a href="{{ route('contact') }}" onclick="toggleMobileMenu()"
                    class="block py-3 text-lg font-bold text-dark hover:text-primary transition-colors uppercase tracking-wider">Contact</a>
            </nav>

           <div class="flex justify-center gap-3 mb-6">
    <button onclick="setLanguage('en')" id="mobile-lang-btn-en"
        class="px-4 py-2 rounded-md border font-semibold transition">
        🇬🇧 EN
    </button>

    <button onclick="setLanguage('fr')" id="mobile-lang-btn-fr"
        class="px-4 py-2 rounded-md border font-semibold transition">
        🇫🇷 FR
    </button>
</div>

            <!-- Mobile Menu Auth Block -->
            <div class="p-6 space-y-4 border-t-2 border-gray-200">
                @guest
                    <a href="{{ route('login') }}"
                        class="w-full h-14 border-2 border-primary text-primary rounded-md font-bold text-sm uppercase tracking-wider flex items-center justify-center transition-all duration-200 hover:bg-primary hover:text-white">
                        Login
                    </a>
                    <a href="{{ route('signup') }}"
                        class="w-full h-14 bg-primary text-white rounded-md font-bold text-sm uppercase tracking-wider flex items-center justify-center transition-all duration-200 hover:scale-105">
                        Signup
                    </a>
                @endguest

                @auth
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.index') : route('user.dashboard') }}"
                        class="w-full h-14 bg-primary text-white rounded-md font-bold text-sm uppercase tracking-wider flex items-center justify-center space-x-3 transition-all duration-200">
                        <div
                            class="w-8 h-8 bg-white text-primary font-bold rounded-full flex items-center justify-center text-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span>Go to Dashboard</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

<script>
    // Header scroll effect
    window.addEventListener('scroll', () => {
        const header = document.getElementById('mainHeader');
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Mobile menu toggle
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('active');
    }

    // Active link highlighting
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');

    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 100;
            if (window.pageYOffset >= sectionTop) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('text-primary');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('text-primary');
            }
        });
    });
</script>
