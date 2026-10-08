@extends('User.main')

@section('title', app()->getLocale() === 'fr' ? 'Audit Gratuit' : 'Free SEO Audit')
@section('description', app()->getLocale() === 'fr' ? 'Obtenez un audit gratuit de votre site web' : 'Get a free SEO audit of your website')

@section('main-section')
<style>
    .audit-hero {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        color: white;
        padding: 60px 20px;
        text-align: center;
        margin-top: 80px;
        margin-bottom: 60px;
    }

    .audit-hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .audit-hero p {
        font-size: 1.125rem;
        margin-bottom: 24px;
        opacity: 0.95;
    }

    .audit-form-section {
        max-width: 600px;
        margin: 0 auto;
        padding: 0 20px 80px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #1f2937;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-family: inherit;
        font-size: 1rem;
        transition: border-color 0.2s;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #f97316;
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .submit-btn {
        background: #f97316;
        color: white;
        padding: 14px 32px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: background 0.2s;
    }

    .submit-btn:hover {
        background: #ea580c;
    }

    .whatsapp-section {
        text-align: center;
        margin-top: 40px;
        padding: 24px;
        background: #f0fdf4;
        border-radius: 8px;
        border-left: 4px solid #10b981;
    }

    .whatsapp-section p {
        color: #059669;
        margin-bottom: 12px;
    }

    .whatsapp-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #25d366;
        color: white;
        padding: 12px 24px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: background 0.2s;
    }

    .whatsapp-btn:hover {
        background: #1da851;
    }
</style>

<div class="audit-hero">
    <h1>{{ app()->getLocale() === 'fr' ? 'Audit Gratuit de Votre Site Web' : 'Free Website Audit' }}</h1>
    <p>{{ app()->getLocale() === 'fr' ? 'Découvrez comment améliorer votre présence numérique' : 'Discover how to improve your digital presence' }}</p>
</div>

<div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="audit-form-section">
        <form method="POST" action="{{ route('free-audit.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">{{ app()->getLocale() === 'fr' ? 'Votre Nom' : 'Your Name' }}*</label>
                <input type="text" id="name" name="name" required value="{{ old('name') }}">
                @error('name')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="email">{{ app()->getLocale() === 'fr' ? 'Email' : 'Email Address' }}*</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}">
                @error('email')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="website">{{ app()->getLocale() === 'fr' ? 'URL de Votre Site' : 'Your Website URL' }}*</label>
                <input type="url" id="website" name="website" required placeholder="https://example.com" value="{{ old('website') }}">
                @error('website')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="phone">{{ app()->getLocale() === 'fr' ? 'Téléphone' : 'Phone Number' }}</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}">
                @error('phone')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="message">{{ app()->getLocale() === 'fr' ? 'Messages Supplémentaires' : 'Additional Notes' }}</label>
                <textarea id="message" name="message">{{ old('message') }}</textarea>
                @error('message')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
            </div>

            <button type="submit" class="submit-btn">
                {{ app()->getLocale() === 'fr' ? 'Demander mon Audit Gratuit' : 'Request My Free Audit' }}
            </button>
        </form>

        <div class="whatsapp-section">
            <p>{{ app()->getLocale() === 'fr' ? '💬 Préférez discuter directement ?' : '💬 Prefer to chat directly?' }}</p>
            <a href="{{ \App\Support\Contact::whatsappUrl(app()->getLocale() === 'fr' ? 'Bonjour, j\'aimerais un audit gratuit de mon site web.' : 'Hi, I would like a free audit of my website.') }}" class="whatsapp-btn" target="_blank">
                <i class="fab fa-whatsapp"></i>
                {{ app()->getLocale() === 'fr' ? 'Nous Contacter via WhatsApp' : 'Contact Us on WhatsApp' }}
            </a>
        </div>
    </div>
</div>
@endsection
