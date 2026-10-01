@extends('User.main')

@section('title', trans('contact.contact_title') . ' | Al-Falah Marketing')
@section('description', trans('contact.contact_subtitle'))

@push('jsonld')
{!! \App\Support\Seo::jsonLd(\App\Support\Seo::organization()) !!}
@endpush

@section('main-section')


<!-- CONTACT SECTION -->
<section id="contact" class="py-20 lg:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Success Message Alert -->
        @if(session('success'))
            <div class="mb-8 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <div>
                <div class="inline-block px-4 py-2 bg-muted rounded-md mb-6">
                    <span class="text-primary font-semibold text-sm uppercase tracking-wider">{{ trans('messages.nav_contact') }}</span>
                </div>

                <h1 class="text-4xl lg:text-5xl font-bold text-dark mb-6 tracking-tighter">
                    {{ trans('contact.contact_title') }}
                </h1>

                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    {{ trans('contact.contact_subtitle') }}
                </p>
                
                <div class="mb-8">
                    @include('partials.contact-info')
                </div>
                
                <div class="flex space-x-4">
                    <a href="https://www.facebook.com/profile.php?id=61573274222922" aria-label="Al-Falah Marketing on Facebook" class="w-12 h-12 bg-muted rounded-lg flex items-center justify-center text-dark hover:bg-primary hover:text-white transition-all duration-200 hover:scale-110">
                        <i class="fab fa-facebook-f" aria-hidden="true"></i>
                    </a>
                    <a href="https://twitter.com" aria-label="Al-Falah Marketing on Twitter" class="w-12 h-12 bg-muted rounded-lg flex items-center justify-center text-dark hover:bg-primary hover:text-white transition-all duration-200 hover:scale-110">
                        <i class="fab fa-twitter" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/al-falah-marketing-inc/" aria-label="Al-Falah Marketing on LinkedIn" class="w-12 h-12 bg-muted rounded-lg flex items-center justify-center text-dark hover:bg-primary hover:text-white transition-all duration-200 hover:scale-110">
                        <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.instagram.com/alfalahmarketinginc/" aria-label="Al-Falah Marketing on Instagram" class="w-12 h-12 bg-muted rounded-lg flex items-center justify-center text-dark hover:bg-primary hover:text-white transition-all duration-200 hover:scale-110">
                        <i class="fab fa-instagram" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            
            <div class="bg-muted rounded-lg p-8">
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    @include('components.spam-protection')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="contact-first-name" class="block text-sm font-bold text-dark mb-2 uppercase tracking-wider">{{ trans('contact.form_label_name') }}</label>
                            <input id="contact-first-name" type="text" name="first_name" required value="{{ old('first_name') }}" class="w-full h-14 bg-white rounded-md px-4 text-dark focus:outline-none focus:ring-2 focus:ring-primary transition-all" placeholder="{{ trans('contact.form_placeholder_name') }}">
                        </div>
                        <div>
                            <label for="contact-last-name" class="block text-sm font-bold text-dark mb-2 uppercase tracking-wider">{{ trans('messages.form_last_name') }}</label>
                            <input id="contact-last-name" type="text" name="last_name" required value="{{ old('last_name') }}" class="w-full h-14 bg-white rounded-md px-4 text-dark focus:outline-none focus:ring-2 focus:ring-primary transition-all" placeholder="{{ trans('contact.form_placeholder_name') }}">
                        </div>
                    </div>

                    <div>
                        <label for="contact-email" class="block text-sm font-bold text-dark mb-2 uppercase tracking-wider">{{ trans('contact.form_label_email') }}</label>
                        <input id="contact-email" type="email" name="email" required value="{{ old('email') }}" class="w-full h-14 bg-white rounded-md px-4 text-dark focus:outline-none focus:ring-2 focus:ring-primary transition-all" placeholder="{{ trans('contact.form_placeholder_email') }}">
                    </div>

                    <div>
                        <label for="contact-phone" class="block text-sm font-bold text-dark mb-2 uppercase tracking-wider">{{ trans('contact.form_label_phone') }}</label>
                        <input id="contact-phone" type="tel" name="phone" value="{{ old('phone') }}" class="w-full h-14 bg-white rounded-md px-4 text-dark focus:outline-none focus:ring-2 focus:ring-primary transition-all" placeholder="{{ trans('contact.form_placeholder_phone') }}">
                    </div>

                    <div>
                        <label for="contact-service" class="block text-sm font-bold text-dark mb-2 uppercase tracking-wider">{{ trans('contact.form_label_service') }}</label>
                        <select id="contact-service" name="service_interest" class="w-full h-14 bg-white rounded-md px-4 text-dark focus:outline-none focus:ring-2 focus:ring-primary transition-all">
                            @foreach(trans('contact.service_options') as $key => $label)
                                <option value="{{ $label }}" {{ old('service_interest') == $label ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="contact-message" class="block text-sm font-bold text-dark mb-2 uppercase tracking-wider">{{ trans('contact.form_label_message') }}</label>
                        <textarea id="contact-message" name="message" rows="4" required class="w-full bg-white rounded-md px-4 py-3 text-dark focus:outline-none focus:ring-2 focus:ring-primary transition-all resize-none" placeholder="{{ trans('contact.form_placeholder_message') }}">{{ old('message') }}</textarea>
                    </div>
                    
                    <button type="submit" class="w-full h-16 bg-primary text-white rounded-md font-bold text-sm uppercase tracking-wider transition-all duration-200 hover:scale-105 hover:bg-blue-600">
                        {{ trans('messages.btn_send') }}
                        <i class="fas fa-paper-plane ml-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>


@endsection

