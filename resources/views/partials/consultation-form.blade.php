<!-- Consultation Form Partial -->
<form action="{{ route('consultation.store') }}" method="POST" class="space-y-5">
    @csrf
    @include('components.spam-protection')
    <div>
        <label for="consult-name" class="block text-sm font-bold text-dark mb-1 uppercase">{{ trans('messages.form_first_name') }}</label>
        <input id="consult-name" type="text" name="name" required class="w-full h-12 border-b-2 border-gray-200 focus:border-primary outline-none transition-colors" placeholder="{{ trans('contact.form_placeholder_name') }}">
    </div>

    <div>
        <label for="consult-email" class="block text-sm font-bold text-dark mb-1 uppercase">{{ trans('contact.form_label_email') }}</label>
        <input id="consult-email" type="email" name="email" required class="w-full h-12 border-b-2 border-gray-200 focus:border-primary outline-none transition-colors" placeholder="{{ trans('contact.form_placeholder_email') }}">
    </div>

    <div>
        <label for="consult-date" class="block text-sm font-bold text-dark mb-1 uppercase">{{ trans('messages.form_meeting_date') }}</label>
        <input id="consult-date" type="date" name="meeting_date" required min="{{ date('Y-m-d') }}" class="w-full h-12 border-b-2 border-gray-200 focus:border-primary outline-none transition-colors" data-no-friday>
        <small class="text-gray-500 text-xs mt-1 block">Closed Fridays</small>
    </div>

    <div>
        <label for="consult-time" class="block text-sm font-bold text-dark mb-1 uppercase">{{ trans('messages.form_preferred_time') }}</label>
        <select id="consult-time" name="preferred_time" required class="w-full h-12 border-b-2 border-gray-200 focus:border-primary outline-none transition-colors">
            <option value="">{{ trans('messages.btn_close') }}</option>
            <option value="morning">{{ trans('messages.time_morning') }}</option>
            <option value="afternoon">{{ trans('messages.time_afternoon') }}</option>
        </select>
    </div>

    <div>
        <label for="consult-subject" class="block text-sm font-bold text-dark mb-1 uppercase">{{ trans('messages.form_subject') }}</label>
        <textarea id="consult-subject" name="subject" rows="3" required class="w-full border-b-2 border-gray-200 focus:border-primary outline-none transition-colors resize-none" placeholder="{{ trans('contact.form_placeholder_message') }}"></textarea>
    </div>

    <button type="submit" class="w-full h-14 bg-primary text-white rounded-md font-bold uppercase tracking-widest hover:bg-blue-700 transition-all transform hover:scale-[1.02]">
        {{ trans('messages.btn_book_consultation') }}
    </button>
</form>

<script>
// Block Fridays in date picker (client-side validation)
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.querySelector('[data-no-friday]');
    if (dateInput) {
        dateInput.addEventListener('change', function() {
            const selected = new Date(this.value);
            if (selected.getDay() === 5) { // 5 = Friday
                alert('Our office is closed on Fridays. Please select another day.');
                this.value = '';
            }
        });
    }
});
</script>
