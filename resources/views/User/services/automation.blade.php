@extends('User.main')

@section('title', 'AI Chatbots & Business Automation — Al-Falah')

@section('styles')
<style>
    .service-card {
        transition: all 0.3s ease;
    }
    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .content-card {
        transition: all 0.3s ease;
    }
    .content-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    .process-step {
        position: relative;
    }
    .process-step:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 24px;
        top: 60px;
        bottom: 0;
        width: 2px;
        background: #3b82f6;
        opacity: 0.3;
    }
    .portfolio-item {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
    }
    .portfolio-item img {
        transition: all 0.5s ease;
    }
    .portfolio-item:hover img {
        transform: scale(1.05);
    }
    .portfolio-overlay {
        position: absolute;
        bottom: -100%;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(59, 130, 246, 0.9));
        padding: 30px 20px 20px;
        transition: all 0.4s ease;
    }
    .portfolio-item:hover .portfolio-overlay {
        bottom: 0;
    }
    .pricing-card {
        transition: all 0.3s ease;
    }
    .pricing-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.15);
    }
    .pricing-card.featured {
        border: 2px solid #3b82f6;
        position: relative;
    }
    .pricing-card.featured::before {
        content: 'Most Popular';
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        background: #3b82f6;
        color: white;
        padding: 4px 20px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        letter-spacing: 0.5px;
    }
    .faq-item {
        border-bottom: 1px solid #e5e7eb;
        padding: 20px 0;
    }
    .faq-item:last-child {
        border-bottom: none;
    }
    .faq-question {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .faq-question:hover {
        color: #3b82f6;
    }
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }
    .faq-answer.open {
        max-height: 200px;
    }
    .stat-item {
        transition: all 0.3s ease;
    }
    .stat-item:hover {
        transform: scale(1.05);
    }
    .benefit-item {
        transition: all 0.3s ease;
    }
    .benefit-item:hover {
        transform: scale(1.02);
        background: #eff6ff;
    }
</style>
@endsection

@section('main-section')

<!-- HERO SECTION -->
<section class="relative bg-primary overflow-hidden pt-32 pb-20 lg:pt-40 lg:pb-32">
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-block px-4 py-2 bg-white/20 rounded-md mb-6">
                    <span class="text-white font-semibold text-sm uppercase tracking-wider">AI & Automation</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight tracking-tighter">
                    Automate the <span class="text-accent">Busywork</span>. Grow Faster.
                </h1>
                <p class="text-lg text-white/90 mb-8 leading-relaxed">
                    AI chatbots, a bilingual WhatsApp sales assistant, and CRM workflows that respond to leads
                    instantly and follow up automatically — so nothing falls through the cracks.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#consultation-form" class="h-14 px-8 bg-accent text-white rounded-md font-bold text-sm uppercase tracking-wider inline-flex items-center justify-center transition-all duration-200 hover:scale-105">
                        Book a Free Call
                    </a>
                    <a href="#services" class="h-14 px-8 border-2 border-white text-white rounded-md font-bold text-sm uppercase tracking-wider inline-flex items-center justify-center transition-all duration-200 hover:bg-white hover:text-primary">
                        See What We Automate
                    </a>
                </div>
            </div>
            <div class="hidden lg:block">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                    <div class="space-y-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-accent rounded-lg flex items-center justify-center">
                                <i class="fas fa-robot text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-white font-bold">AI Chatbots</p>
                                <p class="text-white/70 text-sm">Website & WhatsApp</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-accent rounded-lg flex items-center justify-center">
                                <i class="fab fa-whatsapp text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-white font-bold">WhatsApp Sales Assistant</p>
                                <p class="text-white/70 text-sm">Qualifies leads, FR/EN</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-accent rounded-lg flex items-center justify-center">
                                <i class="fas fa-sync-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-white font-bold">CRM Automation</p>
                                <p class="text-white/70 text-sm">HubSpot-powered</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-accent rounded-lg flex items-center justify-center">
                                <i class="fas fa-project-diagram text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-white font-bold">Workflow Automation</p>
                                <p class="text-white/70 text-sm">Zapier & Make</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATS SECTION -->
<section class="py-16 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center stat-item">
                <div class="text-2xl font-bold text-primary">Instant</div>
                <p class="text-gray-600 text-sm mt-1">Lead Replies</p>
            </div>
            <div class="text-center stat-item">
                <div class="text-2xl font-bold text-primary">Bilingual</div>
                <p class="text-gray-600 text-sm mt-1">FR & EN Bots</p>
            </div>
            <div class="text-center stat-item">
                <div class="text-2xl font-bold text-primary">WhatsApp</div>
                <p class="text-gray-600 text-sm mt-1">Native</p>
            </div>
            <div class="text-center stat-item">
                <div class="text-2xl font-bold text-primary">Fewer</div>
                <p class="text-gray-600 text-sm mt-1">Missed Leads</p>
            </div>
        </div>
    </div>
</section>

<!-- WHY AUTOMATE -->
<section class="py-20 lg:py-32 bg-muted">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-4 py-2 bg-white rounded-md mb-6">
                <span class="text-primary font-semibold text-sm uppercase tracking-wider">Why Automate</span>
            </div>
            <h2 class="text-4xl font-bold text-dark mb-4 tracking-tighter">Never Miss a <span class="text-primary">Lead</span> Again</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Most leads go cold because nobody replied fast enough. Automation fixes that without adding headcount.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="benefit-item bg-white p-8 rounded-2xl shadow-sm">
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-bolt text-3xl"></i>
                </div>
                <h4 class="text-xl font-bold text-dark mb-3">Reply Instantly</h4>
                <p class="text-gray-600">A chatbot greets and qualifies every visitor the moment they message you, even outside business hours.</p>
            </div>
            <div class="benefit-item bg-white p-8 rounded-2xl shadow-sm">
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-language text-3xl"></i>
                </div>
                <h4 class="text-xl font-bold text-dark mb-3">Speak Their Language</h4>
                <p class="text-gray-600">Bilingual FR/EN flows mean every customer in Guinea, Sierra Leone or the USA gets a natural conversation.</p>
            </div>
            <div class="benefit-item bg-white p-8 rounded-2xl shadow-sm">
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-tasks text-3xl"></i>
                </div>
                <h4 class="text-xl font-bold text-dark mb-3">Nothing Falls Through</h4>
                <p class="text-gray-600">Every conversation lands in your CRM automatically, tagged and ready for follow-up.</p>
            </div>
        </div>
    </div>
</section>

<!-- AUTOMATION SERVICES -->
<section class="py-20 lg:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-4 py-2 bg-muted rounded-md mb-6">
                <span class="text-primary font-semibold text-sm uppercase tracking-wider">What We Automate</span>
            </div>
            <h2 class="text-4xl font-bold text-dark mb-4 tracking-tighter">Automation That <span class="text-primary">Actually Sells</span></h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Five ways we take repetitive work off your plate so you can focus on running the business.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- AI Chatbots -->
            <div class="service-card bg-muted p-8 rounded-2xl border-b-8 border-primary">
                <div class="w-16 h-16 bg-primary rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-robot text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-dark mb-3">AI Chatbots</h3>
                <p class="text-gray-600 mb-4">A chatbot on your website and WhatsApp that answers common questions and captures leads around the clock.</p>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> Website Chat Widget</li>
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> WhatsApp Integration</li>
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> FAQ Handling</li>
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> Lead Capture</li>
                </ul>
            </div>

            <!-- WhatsApp Sales Assistant -->
            <div class="service-card bg-muted p-8 rounded-2xl border-b-8 border-primary">
                <div class="w-16 h-16 bg-primary rounded-xl flex items-center justify-center mb-6">
                    <i class="fab fa-whatsapp text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-dark mb-3">WhatsApp Sales Assistant</h3>
                <p class="text-gray-600 mb-4">Greets, qualifies and books calls with prospects on WhatsApp — bilingual, so nothing gets lost in translation.</p>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> Lead Qualification</li>
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> Call Booking</li>
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> French & English</li>
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> Handoff to a Human</li>
                </ul>
            </div>

            <!-- CRM Automation -->
            <div class="service-card bg-muted p-8 rounded-2xl border-b-8 border-primary">
                <div class="w-16 h-16 bg-primary rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-sync-alt text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-dark mb-3">CRM Automation</h3>
                <p class="text-gray-600 mb-4">Every conversation and form submission is logged in HubSpot automatically, tagged, and routed to the right person.</p>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> HubSpot Setup</li>
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> Lead Tagging</li>
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> Pipeline Tracking</li>
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> Team Notifications</li>
                </ul>
            </div>

            <!-- Workflow Automation -->
            <div class="service-card bg-muted p-8 rounded-2xl border-b-8 border-primary">
                <div class="w-16 h-16 bg-primary rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-project-diagram text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-dark mb-3">Workflow Automation</h3>
                <p class="text-gray-600 mb-4">We connect your everyday tools with Zapier or Make so information moves between them without manual copy-pasting.</p>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> Zapier & Make Setup</li>
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> Tool Integrations</li>
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> Data Syncing</li>
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> Custom Triggers</li>
                </ul>
            </div>

            <!-- Automated Follow-ups -->
            <div class="service-card bg-muted p-8 rounded-2xl border-b-8 border-primary">
                <div class="w-16 h-16 bg-primary rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-paper-plane text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-dark mb-3">Automated Follow-ups</h3>
                <p class="text-gray-600 mb-4">Timed reminders and check-ins go out on their own, so leads who don't reply right away don't get forgotten.</p>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> WhatsApp Reminders</li>
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> Email Sequences</li>
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> Booking Confirmations</li>
                    <li><i class="fas fa-check-circle text-primary mr-2"></i> Re-engagement</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- PROCESS SECTION -->
<section class="py-20 lg:py-32 bg-muted">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-4 py-2 bg-white rounded-md mb-6">
                <span class="text-primary font-semibold text-sm uppercase tracking-wider">Our Process</span>
            </div>
            <h2 class="text-4xl font-bold text-dark mb-4 tracking-tighter">How We <span class="text-primary">Set It Up</span></h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                A straightforward rollout, so you know what's happening at every step.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="process-step text-center">
                <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">1</div>
                <h4 class="text-xl font-bold text-dark mb-2">Discover</h4>
                <p class="text-gray-600 text-sm">We map your current lead flow and find where responses are slow or leads get missed.</p>
            </div>
            <div class="process-step text-center">
                <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">2</div>
                <h4 class="text-xl font-bold text-dark mb-2">Build</h4>
                <p class="text-gray-600 text-sm">We build the chatbot, WhatsApp flows, and CRM automations in French and English.</p>
            </div>
            <div class="process-step text-center">
                <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">3</div>
                <h4 class="text-xl font-bold text-dark mb-2">Connect</h4>
                <p class="text-gray-600 text-sm">We connect everything to HubSpot and your other tools, and test it end to end.</p>
            </div>
            <div class="process-step text-center">
                <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">4</div>
                <h4 class="text-xl font-bold text-dark mb-2">Optimize</h4>
                <p class="text-gray-600 text-sm">We monitor real conversations and refine the flows so they keep improving.</p>
            </div>
        </div>
    </div>
</section>



<!-- FAQ SECTION -->
<section class="py-20 lg:py-32 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-4 py-2 bg-muted rounded-md mb-6">
                <span class="text-primary font-semibold text-sm uppercase tracking-wider">FAQ</span>
            </div>
            <h2 class="text-4xl font-bold text-dark mb-4 tracking-tighter">Frequently Asked <span class="text-primary">Questions</span></h2>
        </div>

        <div class="space-y-2">
            <div class="faq-item">
                <div class="faq-question flex justify-between items-center" onclick="toggleFAQ(this)">
                    <h4 class="text-lg font-bold text-dark">What exactly is a WhatsApp Sales Assistant?</h4>
                    <i class="fas fa-chevron-down text-primary transition-transform"></i>
                </div>
                <div class="faq-answer text-gray-600 mt-2">
                    <p>It's a chatbot that lives on your WhatsApp Business number. It greets new messages, asks a few qualifying questions, answers common FAQs, and books a call with your team — in French or English depending on the customer.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question flex justify-between items-center" onclick="toggleFAQ(this)">
                    <h4 class="text-lg font-bold text-dark">Will this replace my team?</h4>
                    <i class="fas fa-chevron-down text-primary transition-transform"></i>
                </div>
                <div class="faq-answer text-gray-600 mt-2">
                    <p>No. It handles the repetitive first contact and hands off to a real person for anything that needs a human touch, so your team spends time on conversations that actually need them.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question flex justify-between items-center" onclick="toggleFAQ(this)">
                    <h4 class="text-lg font-bold text-dark">Does it work with the CRM I already use?</h4>
                    <i class="fas fa-chevron-down text-primary transition-transform"></i>
                </div>
                <div class="faq-answer text-gray-600 mt-2">
                    <p>We build on HubSpot by default and connect it to your existing tools via Zapier or Make. If you use something else, tell us during the free call and we'll assess the fit.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question flex justify-between items-center" onclick="toggleFAQ(this)">
                    <h4 class="text-lg font-bold text-dark">How long does setup take?</h4>
                    <i class="fas fa-chevron-down text-primary transition-transform"></i>
                </div>
                <div class="faq-answer text-gray-600 mt-2">
                    <p>It depends on scope — a basic chatbot and lead-routing setup is faster than a full multi-tool workflow. We'll give you a concrete timeline after the discovery call.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question flex justify-between items-center" onclick="toggleFAQ(this)">
                    <h4 class="text-lg font-bold text-dark">Is it really bilingual?</h4>
                    <i class="fas fa-chevron-down text-primary transition-transform"></i>
                </div>
                <div class="faq-answer text-gray-600 mt-2">
                    <p>Yes — the flows are built and tested in both French and English from the start, since our clients serve customers in Guinea, Sierra Leone and the USA.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="py-20 lg:py-32 bg-primary relative overflow-hidden">
    <div class="absolute bottom-0 right-0 w-80 h-80 bg-white/5 rounded-full translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute top-0 left-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 -translate-x-1/2"></div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6 tracking-tighter">
            Ready to Automate the Busywork?
        </h2>
        <p class="text-xl text-white/80 mb-10 leading-relaxed">
            Book a free call and we'll show you exactly what a chatbot and CRM automation would look like for your business.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#consultation-form" class="h-16 px-10 bg-accent text-white rounded-md font-bold text-sm uppercase tracking-wider inline-flex items-center justify-center transition-all duration-200 hover:scale-105">
                Book a Free Call
            </a>
            <a href="{{ \App\Support\Contact::whatsappUrl(app()->getLocale() === 'fr' ? 'Bonjour, je suis intéressé(e) par l\'automatisation et les chatbots IA.' : "Hi, I'm interested in AI chatbots and automation.") }}" class="h-16 px-10 border-4 border-white text-white rounded-md font-bold text-sm uppercase tracking-wider inline-flex items-center justify-center transition-all duration-200 hover:bg-white hover:text-primary">
                Message on WhatsApp
            </a>
        </div>
    </div>
</section>

<!-- FREE CONSULTATION SECTION -->
<section id="consultation-form" class="py-20 lg:py-32 bg-primary relative overflow-hidden">
    <div class="absolute top-0 left-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 -translate-x-1/2"></div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-5">
                <div class="md:col-span-2 bg-accent p-8 text-white">
                    <h3 class="text-3xl font-bold mb-6">Book a Free Automation Strategy Call</h3>
                    <p class="mb-8 text-white/80">Let's map your current lead flow and show you where a chatbot or CRM automation would help most.</p>
                    <ul class="space-y-4">
                        <li class="flex items-center"><i class="fas fa-check-circle mr-3"></i> 30-Min Strategy Session</li>
                        <li class="flex items-center"><i class="fas fa-check-circle mr-3"></i> Lead-Flow Review</li>
                        <li class="flex items-center"><i class="fas fa-check-circle mr-3"></i> Custom Automation Plan</li>
                    </ul>
                </div>

                <div class="md:col-span-3 p-8 lg:p-12">
                    @if(session('consultation_success'))
                        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                            {{ session('consultation_success') }}
                        </div>
                    @endif

                    <form action="{{ route('consultation.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-dark mb-1 uppercase">Full Name</label>
                            <input type="text" name="name" required class="w-full h-12 border-b-2 border-gray-200 focus:border-primary outline-none transition-colors" placeholder="Enter your name">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-dark mb-1 uppercase">Email Address</label>
                            <input type="email" name="email" required class="w-full h-12 border-b-2 border-gray-200 focus:border-primary outline-none transition-colors" placeholder="email@example.com">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-dark mb-1 uppercase">Preferred Meeting Date</label>
                            <input type="date" name="meeting_date" required min="{{ date('Y-m-d') }}" class="w-full h-12 border-b-2 border-gray-200 focus:border-primary outline-none transition-colors">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-dark mb-1 uppercase">Subject / Discussion Topic</label>
                            <textarea name="subject" rows="3" required class="w-full border-b-2 border-gray-200 focus:border-primary outline-none transition-colors resize-none" placeholder="Tell us what you'd like to automate..."></textarea>
                        </div>

                        <button type="submit" class="w-full h-14 bg-primary text-white rounded-md font-bold uppercase tracking-widest hover:bg-blue-700 transition-all transform hover:scale-[1.02]">
                            Book Free Automation Strategy Call
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    function toggleFAQ(element) {
        const answer = element.nextElementSibling;
        const icon = element.querySelector('i');
        
        answer.classList.toggle('open');
        icon.style.transform = answer.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0)';
        
        // Close other FAQs
        const allFAQs = document.querySelectorAll('.faq-answer');
        allFAQs.forEach(faq => {
            if (faq !== answer && faq.classList.contains('open')) {
                faq.classList.remove('open');
                const otherIcon = faq.previousElementSibling.querySelector('i');
                if (otherIcon) {
                    otherIcon.style.transform = 'rotate(0)';
                }
            }
        });
    }
</script>
@endsection