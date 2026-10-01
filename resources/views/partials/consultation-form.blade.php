<!-- Consultation Form Partial -->
<form action="{{ route('consultation.store') }}" method="POST" class="space-y-5">
    @csrf
    @include('components.spam-protection')
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
        <textarea name="subject" rows="3" required class="w-full border-b-2 border-gray-200 focus:border-primary outline-none transition-colors resize-none" placeholder="What would you like to discuss?"></textarea>
    </div>

    <button type="submit" class="w-full h-14 bg-primary text-white rounded-md font-bold uppercase tracking-widest hover:bg-blue-700 transition-all transform hover:scale-[1.02]">
        Confirm Booking
    </button>
</form>
