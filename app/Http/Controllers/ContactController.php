<?php

namespace App\Http\Controllers;

use App\Models\HeadOfficeDivision;
use App\Models\Message;
use App\Models\RegionalOffice;
use App\Support\HeadOfficeDetails;
use App\Support\OfficeLocations;
use Illuminate\Http\Request;

/**
 * Contact Us pages. Everything shown here is entered by the admin:
 * Admin → Head Office (office details + divisions & officers) and Admin → Regional Offices.
 */
class ContactController extends Controller
{
    /**
     * Inquiry page – form + contact info
     */
    public function inquiry()
    {
        // value = English name (what is saved with the message), label = name in the visitor's language
        $offices = [];
        if ($headOfficeName = HeadOfficeDetails::text('name', 'en')) {
            $offices[$headOfficeName] = HeadOfficeDetails::text('name');
        }

        foreach (HeadOfficeDivision::published()->get() as $division) {
            $offices[$division->division] = $division->textIn('division');
        }

        foreach (RegionalOffice::published()->get() as $office) {
            $offices[$office->name] = $office->textIn('name');
        }

        $headOffice = self::headOfficeDetails();

        return view('contact.inquiry', compact('offices', 'headOffice'));
    }

    /**
     * Submit inquiry form
     */
    public function submitInquiry(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'office' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
        ]);

        // Saved to Admin → Messages
        Message::create([
            'type'    => 'inquiry',
            'name'    => $validated['full_name'],
            'email'   => $validated['email'],
            'subject' => $validated['subject'],
            'office'  => $validated['office'],
            'body'    => $validated['message'],
        ]);

        return back()->with('success', __('Thank you! Your inquiry has been submitted successfully. We will respond within 3–5 working days.'));
    }

    /**
     * Head Office page – divisions, officers, phone/fax/ext/email
     */
    public function headOffice()
    {
        $divisions = HeadOfficeDivision::published()->get()->map(fn (HeadOfficeDivision $d) => [
            'division' => $d->textIn('division'),
            'position' => $d->textIn('position'),
            'officer' => $d->officer ?: '—',
            'phone' => $d->phone ?: '—',
            'fax' => $d->fax ?: '—',
            'extension' => $d->extension ?: '—',
            'email' => $d->email ?: '—',
        ])->all();

        $headOffice = self::headOfficeDetails();

        return view('contact.head-office', compact('divisions', 'headOffice'));
    }

    /** Head Office name, address, phone, fax, email and hours from Admin → Head Office → Office details. */
    private static function headOfficeDetails(): array
    {
        return [
            'name' => HeadOfficeDetails::text('name'),
            'address' => HeadOfficeDetails::text('address'),
            'hours' => HeadOfficeDetails::text('hours'),
            'phone' => HeadOfficeDetails::contact('phone'),
            'fax' => HeadOfficeDetails::contact('fax'),
            'email' => HeadOfficeDetails::contact('email'),
            'location' => HeadOfficeDetails::location(),
        ];
    }

    /**
     * Regional Office page – all districts, grouped by province
     */
    public function regionalOffice()
    {
        $districts = RegionalOffice::published()->get()->map(fn (RegionalOffice $o) => [
            'province' => __($o->province_label),
            'office' => $o->textIn('name'),
            'phone' => $o->phone ?: '—',
            'email' => $o->email ?: '—',
            'address' => $o->textIn('address') ?: '—',
            'anchor' => $o->anchor(),
            'location' => $o->hasLocation() ? [(float) $o->latitude, (float) $o->longitude] : null,
        ])->all();

        $provinceCount = collect($districts)->pluck('province')->unique()->count();

        return view('contact.regional-office', compact('districts', 'provinceCount'));
    }
}
