<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Support\SpamProtection;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function index() {
        return view ('User.contact');
    }

    public function contacts()
{
    // Fetch latest enquiries with pagination (10 per page)
    $contacts = Contact::latest()->paginate(10);
    return view('admin.contacts.index', compact('contacts'));
}

    public function store(Request $request)
    {
        // 0. Check for spam (honeypot + time-trap + optional Turnstile)
        if (! SpamProtection::validate($request)) {
            // Silently reject spam without revealing detection method
            return back()->with('success', 'Thank you! Your message has been sent.');
        }

        // 1. Validate the input
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|email|max:100',
            'phone'      => 'nullable|string|max:20',
            'service_interest' => 'required|string',
            'message'    => 'required|string',
        ]);

        // 2. Create the record in the database
        Contact::create($validated);

        // 3. Fire tracking events (Lead event for GA4 + Meta Pixel)
        $trackingEvent = \App\Support\Tracking::fireEvent('generate_lead', [
            'value' => 1,
            'currency' => 'USD',
        ]);

        // 4. Redirect back with a success message
        return back()
            ->with('success', 'Thank you! Your message has been sent.')
            ->with('tracking_event', $trackingEvent);
    }
}
