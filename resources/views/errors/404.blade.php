@extends('User.main')

@section('title', 'Page Not Found - Al-Falah Marketing')

@section('main-section')

<section class="py-32 lg:py-40 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="text-8xl font-bold text-primary mb-6 tracking-tighter">404</div>

        <h1 class="text-3xl lg:text-4xl font-bold text-dark mb-4 tracking-tighter">
            Page not found.
        </h1>

        <p class="text-lg text-gray-600 mb-10 leading-relaxed">
            The page you're looking for doesn't exist or may have moved. Let's get you back on track.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" class="h-14 px-8 bg-primary text-white rounded-md font-bold text-sm uppercase tracking-wider inline-flex items-center justify-center transition-all duration-200 hover:scale-105">
                <i class="fas fa-home mr-2"></i> Home
            </a>
            <a href="{{ route('service') }}" class="h-14 px-8 border-2 border-primary text-primary rounded-md font-bold text-sm uppercase tracking-wider inline-flex items-center justify-center transition-all duration-200 hover:bg-primary hover:text-white">
                <i class="fas fa-briefcase mr-2"></i> Services
            </a>
            <a href="{{ \App\Support\Contact::whatsappUrl() }}" class="h-14 px-8 bg-[#25D366] text-white rounded-md font-bold text-sm uppercase tracking-wider inline-flex items-center justify-center transition-all duration-200 hover:scale-105">
                <i class="fab fa-whatsapp mr-2"></i> WhatsApp
            </a>
        </div>
    </div>
</section>

@endsection
