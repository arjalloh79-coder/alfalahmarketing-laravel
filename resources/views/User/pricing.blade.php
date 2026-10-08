@extends('User.main')

@section('title', app()->getLocale() === 'fr' ? 'Tarifs' : 'Pricing')
@section('description', app()->getLocale() === 'fr' ? 'Découvrez nos plans tarifaires simples et transparents' : 'Simple and transparent pricing plans for your business')

@section('main-section')
<style>
    .pricing-page {
        padding-top: 120px;
        padding-bottom: 60px;
    }

    .pricing-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .pricing-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 16px;
        color: #1f2937;
    }

    .pricing-header p {
        font-size: 1.125rem;
        color: #6b7280;
    }

    .currency-controls {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-bottom: 60px;
        flex-wrap: wrap;
    }

    .currency-btn {
        padding: 10px 20px;
        border: 2px solid #d1d5db;
        background: white;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
    }

    .currency-btn.active {
        background: #f97316;
        color: white;
        border-color: #f97316;
    }

    .currency-btn:hover:not(.active) {
        border-color: #f97316;
    }

    .tiers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 32px;
        margin-bottom: 80px;
    }

    .tier-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 32px;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
    }

    .tier-card.featured {
        border-color: #f97316;
        transform: scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(249, 115, 22, 0.1);
    }

    .tier-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .tier-name {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 12px;
        color: #1f2937;
    }

    .tier-price {
        font-size: 2.25rem;
        font-weight: 800;
        color: #f97316;
        margin-bottom: 4px;
    }

    .tier-currency {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 24px;
    }

    .tier-description {
        color: #6b7280;
        font-size: 0.95rem;
        margin-bottom: 24px;
        line-height: 1.6;
    }

    .tier-features {
        list-style: none;
        margin-bottom: 32px;
        flex-grow: 1;
    }

    .tier-features li {
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #374151;
    }

    .tier-features li:before {
        content: '✓';
        color: #10b981;
        font-weight: bold;
        font-size: 1.25rem;
    }

    .tier-cta {
        width: 100%;
        padding: 14px 16px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s;
    }

    .tier-cta.primary {
        background: #f97316;
        color: white;
    }

    .tier-cta.primary:hover {
        background: #ea580c;
    }

    .tier-cta.secondary {
        border: 2px solid #f97316;
        color: #f97316;
        background: white;
    }

    .tier-cta.secondary:hover {
        background: #fff7ed;
    }

    .government-section {
        background: linear-gradient(135deg, #f3f4f6 0%, #f9fafb 100%);
        border-radius: 12px;
        padding: 48px 32px;
        text-align: center;
        margin-bottom: 80px;
        border: 1px solid #e5e7eb;
    }

    .government-section h3 {
        font-size: 1.875rem;
        margin-bottom: 16px;
        color: #1f2937;
    }

    .government-section p {
        color: #6b7280;
        font-size: 1rem;
        margin-bottom: 24px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .payment-section {
        background: white;
        border-radius: 12px;
        padding: 48px 32px;
        border: 1px solid #e5e7eb;
    }

    .payment-section h3 {
        font-size: 1.5rem;
        margin-bottom: 32px;
        text-align: center;
        color: #1f2937;
    }

    .payment-badges {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 16px;
    }

    .payment-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 20px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 500;
        color: #374151;
        transition: all 0.3s;
    }

    .payment-badge:hover {
        border-color: #f97316;
        background: #fff7ed;
    }

    .payment-emoji {
        font-size: 1.5rem;
    }

    @media (max-width: 768px) {
        .pricing-page {
            padding-top: 100px;
            padding-bottom: 40px;
        }

        .pricing-header h1 {
            font-size: 1.875rem;
        }

        .tiers-grid {
            gap: 24px;
        }

        .tier-card.featured {
            transform: scale(1);
        }

        .government-section,
        .payment-section {
            padding: 32px 24px;
        }

        .payment-badges {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .currency-symbol {
        font-weight: 600;
        color: #6b7280;
        font-size: 0.875rem;
        margin-right: 4px;
    }
</style>

<div class="pricing-page">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="pricing-header">
            <h1>{{ app()->getLocale() === 'fr' ? 'Tarifs Simples et Transparents' : 'Simple & Transparent Pricing' }}</h1>
            <p>{{ app()->getLocale() === 'fr' ? 'Choisissez le plan qui convient à votre entreprise' : 'Choose the plan that fits your business' }}</p>
        </div>

        <!-- Currency Toggle -->
        <div class="currency-controls">
            <button class="currency-btn {{ $currency === 'usd' ? 'active' : '' }}" data-currency="usd" onclick="changeCurrency('usd')">
                USD
            </button>
            <button class="currency-btn {{ $currency === 'gnf' ? 'active' : '' }}" data-currency="gnf" onclick="changeCurrency('gnf')">
                GNF
            </button>
            <button class="currency-btn {{ $currency === 'sle' ? 'active' : '' }}" data-currency="sle" onclick="changeCurrency('sle')">
                SLE
            </button>
        </div>

        <!-- Pricing Tiers -->
        <div class="tiers-grid">
            @foreach ($tiers as $tier)
                @php
                    $isFrench = app()->getLocale() === 'fr';
                    $tierName = $isFrench ? $tier['name_fr'] : $tier['name_en'];
                    $tierDescription = $isFrench ? $tier['description_fr'] : $tier['description_en'];
                    $tierFeatures = $isFrench ? $tier['features_fr'] : $tier['features_en'];
                    $price = $tier['prices'][$currency];
                    $isSecond = $loop->index === 1;
                @endphp
                <div class="tier-card {{ $isSecond ? 'featured' : '' }}">
                    <h2 class="tier-name">{{ $tierName }}</h2>
                    <div class="tier-price" data-price="{{ $price }}">
                        <span class="currency-symbol" data-symbol="{{ $currency === 'usd' ? '$' : ($currency === 'gnf' ? 'GNF ' : 'SLE ') }}">
                            {{ $currency === 'usd' ? '$' : ($currency === 'gnf' ? 'GNF ' : 'SLE ') }}
                        </span>{{ number_format($price, 0, '.', ',') }}
                    </div>
                    <div class="tier-currency">{{ app()->getLocale() === 'fr' ? 'par mois' : 'per month' }}</div>
                    <p class="tier-description">{{ $tierDescription }}</p>
                    <ul class="tier-features">
                        @foreach ($tierFeatures as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                    <button class="tier-cta {{ $isSecond ? 'primary' : 'secondary' }}" onclick="contactViaWhatsApp('{{ $tierName }}')">
                        {{ app()->getLocale() === 'fr' ? ($isSecond ? 'Choisir ce plan' : 'Démarrer') : ($isSecond ? 'Choose Plan' : 'Get Started') }}
                    </button>
                </div>
            @endforeach
        </div>

        <!-- Government & Institutions -->
        @php
            $isFrench = app()->getLocale() === 'fr';
            $govTitle = $government['title_' . ($isFrench ? 'fr' : 'en')] ?? 'Government & Institutions';
            $govDesc = $government['description_' . ($isFrench ? 'fr' : 'en')] ?? 'Custom pricing available';
            $govCta = $government['cta_' . ($isFrench ? 'fr' : 'en')] ?? 'Request Quote';
        @endphp
        <div class="government-section">
            <h3>{{ $govTitle }}</h3>
            <p>{{ $govDesc }}</p>
            <button class="tier-cta primary" onclick="contactViaWhatsApp('{{ $govTitle }}')">
                {{ $govCta }}
            </button>
        </div>

        <!-- Payment Methods -->
        <div class="payment-section">
            <h3>{{ app()->getLocale() === 'fr' ? 'Nous acceptons' : 'We Accept' }}</h3>
            <div class="payment-badges">
                @foreach ($paymentMethods as $method)
                    <div class="payment-badge">
                        <span class="payment-emoji">{{ $method['emoji'] }}</span>
                        <span>{{ $method['name'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    function changeCurrency(currency) {
        // Update button states
        document.querySelectorAll('.currency-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelector(`[data-currency="${currency}"]`).classList.add('active');

        // Send request to save currency in session
        fetch('{{ route('pricing.set-currency') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ currency: currency })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function contactViaWhatsApp(tierName) {
        const message = encodeURIComponent(
            `{{ app()->getLocale() === 'fr' ? 'Bonjour, je suis intéressé par le plan ' : 'Hi, I am interested in the ' }}${tierName}{{ app()->getLocale() === 'fr' ? '. Pouvez-vous me fournir plus de détails ?' : '. Can you provide more details?' }}`
        );
        const whatsappUrl = '{{ \App\Support\Contact::whatsappUrl() }}' + '?text=' + message;
        window.open(whatsappUrl, '_blank');
    }
</script>
@endsection
