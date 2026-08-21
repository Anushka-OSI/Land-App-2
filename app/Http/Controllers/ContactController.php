<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function inquiry()
    {
        $offices = [
            'Head Office – Battaramulla',
            'Colombo District Office',
            'Gampaha District Office',
            'Kalutara District Office',
            'Kandy District Office',
            'Matale District Office',
            'Nuwara Eliya District Office',
            'Galle District Office',
            'Matara District Office',
            'Hambantota District Office',
            'Kurunegala District Office',
            'Puttalam District Office',
            'Anuradhapura District Office',
            'Polonnaruwa District Office',
            'Badulla District Office',
            'Monaragala District Office',
            'Ratnapura District Office',
            'Kegalle District Office',
            'Trincomalee District Office',
            'Batticaloa District Office',
            'Ampara District Office',
            'Jaffna District Office',
            'Kilinochchi District Office',
            'Mullaitivu District Office',
            'Vavuniya District Office',
        ];

        return view('contact.inquiry', compact('offices'));
    }

    public function submitInquiry(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'office' => 'required|string',
            'message' => 'required|string|max:5000',
        ]);

        // TODO: Store in database or send email
        // For now, flash a success message
        return redirect()->route('contact.inquiry')->with('success', 'Your inquiry has been submitted successfully! We will get back to you within 3–5 working days.');
    }
}
