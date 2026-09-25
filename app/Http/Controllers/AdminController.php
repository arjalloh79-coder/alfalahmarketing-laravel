<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserSignupMail;


class Admincontroller extends Controller
{
    public function index()
    {
        return view('admin.index');
    } 
    
    public function createUser()
    {
        return view('admin.users.create');
    }

public function storeUser(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'role' => 'required'
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role
    ]);

    // Send welcome email
    Mail::to($user->email)->send(new UserSignupMail($user));

    return redirect()
        ->route('admin.users')
        ->with('success', 'User created successfully and welcome email sent.');
    }
    
     public function users()
    {
        // Fetch users with pagination (10 per page)
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    } // Ensure this matches your Contact Model name


public function contacts()
{
    // Fetch latest enquiries with pagination (10 per page)
    $contacts = Contact::latest()->paginate(10);
    
    return view('admin.contacts.index', compact('contacts'));
}

public function destroyContact($id)
{
    $contact = Contact::findOrFail($id);
    $contact->delete();

    return redirect()->back()->with('success', 'Enquiry deleted successfully.');
}

    
}
