@extends('User.main')

@section('title', 'Success Stories & Portfolio - Al-Falah Digital Marketing')

@section('main-section')

<!-- HERO SECTION -->
<section class="relative bg-primary pt-24 pb-16 md:pt-32 md:pb-20 lg:pt-36 lg:pb-24 overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 md:w-96 md:h-96 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-md rounded-full mb-4 border border-white/10">
            <span class="text-white font-medium text-xs uppercase tracking-widest">Proof of Excellence</span>
        </div>
        <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-4 tracking-tight leading-tight">
            Real Clients. <span class="text-accent">Real Results.</span>
        </h1>
        <p class="text-sm md:text-base lg:text-lg text-white/80 max-w-2xl mx-auto leading-relaxed">
            From local businesses in the USA to fast-growing startups in Africa, we build digital systems that turn clicks into customers.
        </p>
    </div>
</section>

<!-- PROJECT FILTER -->
<div class="bg-white border-b sticky top-[60px] md:top-[72px] z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex space-x-6 md:space-x-8 overflow-x-auto py-4 md:py-6 no-scrollbar justify-start md:justify-center">
            <button onclick="filterProjects('all', this)" class="filter-btn text-primary font-bold border-b-2 border-primary pb-1 whitespace-nowrap transition-all text-sm uppercase tracking-wider">All Work</button>
            <button onclick="filterProjects('Web Design', this)" class="filter-btn text-gray-500 hover:text-primary font-semibold whitespace-nowrap transition-all text-sm uppercase tracking-wider">Web Design</button>
            <button onclick="filterProjects('SEO & Ads', this)" class="filter-btn text-gray-500 hover:text-primary font-semibold whitespace-nowrap transition-all text-sm uppercase tracking-wider">SEO & Ads</button>
            <button onclick="filterProjects('AI Automation', this)" class="filter-btn text-gray-500 hover:text-primary font-semibold whitespace-nowrap transition-all text-sm uppercase tracking-wider">AI Automation</button>
            <button onclick="filterProjects('E-commerce', this)" class="filter-btn text-gray-500 hover:text-primary font-semibold whitespace-nowrap transition-all text-sm uppercase tracking-wider">E-commerce</button>
        </div>
    </div>
</div>

<!-- PORTFOLIO GRID -->
<section class="py-12 md:py-16 bg-slate-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- 3 Column Layout on Large Screens to keep image sizes small and elegant -->
        <div id="portfolioGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            
            @forelse($projects as $project)
                <!-- Project Card Items -->
                <div class="project-card group cursor-pointer bg-white rounded-2xl border border-slate-100 p-3 transition-all duration-300 hover:border-slate-200" data-category="{{ $project->category }}" onclick="window.open('{{ $project->project_url ?? '#' }}', '_blank')">
                    
                    <!-- Aspect ratio fixed to 4/3 for crisp and compact image container -->
                    <div class="relative overflow-hidden rounded-xl bg-slate-100 aspect-[4/3]">
                        <img src="{{ asset('storage/public/' . $project->image) }}" alt="{{ $project->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        
                        <!-- Results Badge Metrics Element -->
                        <div class="absolute top-4 left-4 z-10">
                            <div class="bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-lg border border-slate-100">
                                <p class="text-primary font-bold text-sm tracking-tight">{{ $project->badge_text }}</p>
                            </div>
                        </div>
                        
                        <!-- Hover Overlay Screen -->
                        <div class="absolute inset-0 bg-dark/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center p-6">
                            <div class="text-center text-white transform translate-y-3 group-hover:translate-y-0 transition-transform duration-300">
                                <p class="text-xs uppercase tracking-widest font-semibold text-primary mb-1">{{ $project->category }}</p>
                                <h3 class="text-lg font-bold mb-4 line-clamp-2 px-2">{{ $project->title }}</h3>
                                <span class="inline-flex h-10 w-10 items-center justify-center bg-primary text-white rounded-full text-sm">
                                    <i class="fas {{ $project->project_url ? 'fa-external-link-alt' : 'fa-arrow-right' }}"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card Footer Details Inside Border Box -->
                    <div class="mt-4 flex justify-between items-start px-1 pb-1">
                        <div class="min-w-0 flex-1 pr-3">
                            <h4 class="text-base font-bold text-dark truncate">{{ $project->title }}</h4>
                            <p class="text-gray-400 text-xs mt-0.5 truncate">Market: {{ $project->target_market }}</p>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-primary bg-primary/5 px-2.5 py-1 rounded-md shrink-0 border border-primary/10">{{ $project->year }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-16 text-gray-400">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-200">
                        <i class="fas fa-folder-open text-xl text-slate-400"></i>
                    </div>
                    <p class="font-medium text-sm">No projects found in this collection.</p>
                </div>
            @endforelse

        </div>
    </div>
</section>

<!-- TESTIMONIAL MINI SECTION -->
<section class="py-16 bg-white border-t border-slate-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <i class="fas fa-quote-left text-primary/10 text-5xl mb-6"></i>
        <h2 class="text-xl md:text-2xl font-medium text-dark mb-6 leading-relaxed max-w-3xl mx-auto italic">
            "Al-Falah Marketing transformed our business. We went from struggling to find local clients in New York to having a booked calendar every single week."
        </h2>
        <div class="flex flex-col items-center">
            <div class="w-12 h-12 rounded-full bg-slate-200 mb-3 overflow-hidden border-2 border-white shadow-sm">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop" alt="Client" class="w-full h-full object-cover">
            </div>
            <h5 class="text-dark font-bold text-sm">Johnathan Reed</h5>
            <p class="text-gray-400 text-xs mt-0.5">CEO, Elite Realty Group</p>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
    // Live UI Dynamic Filter Engine
    function filterProjects(category, buttonElement) {
        // अपडेट फ़िल्टर नेविगेशन टैब एक्टिव स्टेट
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('text-primary', 'font-bold', 'border-b-2', 'border-primary', 'pb-1');
            btn.classList.add('text-gray-500', 'font-semibold');
        });
        
        buttonElement.classList.remove('text-gray-500', 'font-semibold');
        buttonElement.classList.add('text-primary', 'font-bold', 'border-b-2', 'border-primary', 'pb-1');

        // रेंडरिंग फ़िल्टर प्रोसेस कार्ड्स
        const cards = document.querySelectorAll('.project-card');
        cards.forEach(card => {
            if(category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endsection