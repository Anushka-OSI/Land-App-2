<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Inquiry page – form + contact info
     */
    public function inquiry()
    {
        $offices = [
            'Head Office – Battaramulla',
            'Office of the Commissioner General',
            'Land Division',
            'Admin Division',
            'Accounts Division',
            'Investigation Division',
            'Publication Division',
            'Computer Division',
            'Planning Division',
            'Record Room',
            'Stores',
            'Translation Section',
            'Legal Section',
            'Regional Office – Colombo',
            'Regional Office – Gampaha',
            'Regional Office – Kalutara',
            'Regional Office – Kandy',
            'Regional Office – Matale',
            'Regional Office – Nuwara Eliya',
            'Regional Office – Galle',
            'Regional Office – Matara',
            'Regional Office – Hambantota',
            'Regional Office – Jaffna',
            'Regional Office – Kilinochchi',
            'Regional Office – Mannar',
            'Regional Office – Vavuniya',
            'Regional Office – Mullaitivu',
            'Regional Office – Batticaloa',
            'Regional Office – Ampara',
            'Regional Office – Trincomalee',
            'Regional Office – Kurunegala',
            'Regional Office – Puttalam',
            'Regional Office – Anuradhapura',
            'Regional Office – Polonnaruwa',
            'Regional Office – Badulla',
            'Regional Office – Monaragala',
            'Regional Office – Ratnapura',
            'Regional Office – Kegalle',
        ];

        return view('contact.inquiry', compact('offices'));
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

        // In production, save to DB or send email
        return back()->with('success', 'Thank you! Your inquiry has been submitted successfully. We will respond within 3–5 working days.');
    }

    /**
     * Head Office page – divisions, officers, phone/fax/ext/email
     */
    public function headOffice()
    {
        $divisions = [
            [
                'division' => 'Office of the Commissioner General',
                'position' => 'Commissioner General',
                'officer' => 'Mr. K. A. D. Ananda',
                'phone' => '011-2888935',
                'fax' => '011-2888937',
                'extension' => '100',
                'email' => 'cg@landtitle.gov.lk',
            ],
            [
                'division' => 'Land Division',
                'position' => 'Deputy Commissioner (Land)',
                'officer' => 'Mrs. S. M. Jayawardena',
                'phone' => '011-2888936',
                'fax' => '011-2888937',
                'extension' => '110',
                'email' => 'land@landtitle.gov.lk',
            ],
            [
                'division' => 'Admin Division',
                'position' => 'Deputy Commissioner (Admin)',
                'officer' => 'Mr. R. P. Fernando',
                'phone' => '011-2888938',
                'fax' => '011-2888937',
                'extension' => '120',
                'email' => 'admin@landtitle.gov.lk',
            ],
            [
                'division' => 'Accounts Division',
                'position' => 'Chief Accountant',
                'officer' => 'Mrs. N. K. Perera',
                'phone' => '011-2888939',
                'fax' => '011-2888937',
                'extension' => '130',
                'email' => 'accounts@landtitle.gov.lk',
            ],
            [
                'division' => 'Investigation Division',
                'position' => 'Deputy Commissioner (Investigation)',
                'officer' => 'Mr. W. A. Samarasinghe',
                'phone' => '011-2888940',
                'fax' => '011-2888937',
                'extension' => '140',
                'email' => 'investigation@landtitle.gov.lk',
            ],
            [
                'division' => 'Publication Division',
                'position' => 'Chief Publications Officer',
                'officer' => 'Mrs. D. M. Weerasekera',
                'phone' => '011-2888941',
                'fax' => '011-2888937',
                'extension' => '150',
                'email' => 'publications@landtitle.gov.lk',
            ],
            [
                'division' => 'Computer Division',
                'position' => 'Director (IT)',
                'officer' => 'Mr. T. H. Bandara',
                'phone' => '011-2888942',
                'fax' => '011-2888937',
                'extension' => '160',
                'email' => 'it@landtitle.gov.lk',
            ],
            [
                'division' => 'Planning Division',
                'position' => 'Director (Planning)',
                'officer' => 'Mr. A. G. Rathnayake',
                'phone' => '011-2888943',
                'fax' => '011-2888937',
                'extension' => '170',
                'email' => 'planning@landtitle.gov.lk',
            ],
            [
                'division' => 'Record Room',
                'position' => 'Chief Records Officer',
                'officer' => 'Mrs. H. P. Gunawardena',
                'phone' => '011-2888944',
                'fax' => '011-2888937',
                'extension' => '180',
                'email' => 'records@landtitle.gov.lk',
            ],
            [
                'division' => 'Stores',
                'position' => 'Chief Stores Officer',
                'officer' => 'Mr. P. B. Wickramasinghe',
                'phone' => '011-2888945',
                'fax' => '011-2888937',
                'extension' => '190',
                'email' => 'stores@landtitle.gov.lk',
            ],
            [
                'division' => 'Translation Section',
                'position' => 'Chief Translator',
                'officer' => 'Mr. M. I. M. Fazil',
                'phone' => '011-2888946',
                'fax' => '011-2888937',
                'extension' => '200',
                'email' => 'translation@landtitle.gov.lk',
            ],
            [
                'division' => 'Legal Section',
                'position' => 'Senior Legal Officer',
                'officer' => 'Mrs. L. K. Dissanayake',
                'phone' => '011-2888947',
                'fax' => '011-2888937',
                'extension' => '210',
                'email' => 'legal@landtitle.gov.lk',
            ],
        ];

        return view('contact.head-office', compact('divisions'));
    }

    /**
     * Regional Office page – all districts
     */
    public function regionalOffice()
    {
        $districts = [
            // Western Province
            [
                'province' => 'Western Province',
                'office' => 'Title Settlement Office – Colombo',
                'phone' => '011-2541234',
                'email' => 'colombo@landtitle.gov.lk',
                'address' => 'No. 45, Lotus Road, Colombo 01',
            ],
            [
                'province' => 'Western Province',
                'office' => 'Title Settlement Office – Gampaha',
                'phone' => '033-2222345',
                'email' => 'gampaha@landtitle.gov.lk',
                'address' => 'No. 12, Kandy Road, Gampaha',
            ],
            [
                'province' => 'Western Province',
                'office' => 'Title Settlement Office – Kalutara',
                'phone' => '034-2223456',
                'email' => 'kalutara@landtitle.gov.lk',
                'address' => 'No. 78, Galle Road, Kalutara South',
            ],
            // Central Province
            [
                'province' => 'Central Province',
                'office' => 'Title Settlement Office – Kandy',
                'phone' => '081-2234567',
                'email' => 'kandy@landtitle.gov.lk',
                'address' => 'No. 23, Peradeniya Road, Kandy',
            ],
            [
                'province' => 'Central Province',
                'office' => 'Title Settlement Office – Matale',
                'phone' => '066-2234567',
                'email' => 'matale@landtitle.gov.lk',
                'address' => 'No. 56, Trincomalee Street, Matale',
            ],
            [
                'province' => 'Central Province',
                'office' => 'Title Settlement Office – Nuwara Eliya',
                'phone' => '052-2234567',
                'email' => 'nuwaraeliya@landtitle.gov.lk',
                'address' => 'No. 10, Badulla Road, Nuwara Eliya',
            ],
            // Southern Province
            [
                'province' => 'Southern Province',
                'office' => 'Title Settlement Office – Galle',
                'phone' => '091-2234567',
                'email' => 'galle@landtitle.gov.lk',
                'address' => 'No. 34, Matara Road, Galle',
            ],
            [
                'province' => 'Southern Province',
                'office' => 'Title Settlement Office – Matara',
                'phone' => '041-2234567',
                'email' => 'matara@landtitle.gov.lk',
                'address' => 'No. 89, Akuressa Road, Matara',
            ],
            [
                'province' => 'Southern Province',
                'office' => 'Title Settlement Office – Hambantota',
                'phone' => '047-2234567',
                'email' => 'hambantota@landtitle.gov.lk',
                'address' => 'No. 15, Main Street, Hambantota',
            ],
            // Northern Province
            [
                'province' => 'Northern Province',
                'office' => 'Title Settlement Office – Jaffna',
                'phone' => '021-2234567',
                'email' => 'jaffna@landtitle.gov.lk',
                'address' => 'No. 67, Hospital Road, Jaffna',
            ],
            [
                'province' => 'Northern Province',
                'office' => 'Title Settlement Office – Kilinochchi',
                'phone' => '021-2283456',
                'email' => 'kilinochchi@landtitle.gov.lk',
                'address' => 'No. 5, A9 Road, Kilinochchi',
            ],
            [
                'province' => 'Northern Province',
                'office' => 'Title Settlement Office – Mannar',
                'phone' => '023-2234567',
                'email' => 'mannar@landtitle.gov.lk',
                'address' => 'No. 22, Main Street, Mannar',
            ],
            [
                'province' => 'Northern Province',
                'office' => 'Title Settlement Office – Vavuniya',
                'phone' => '024-2234567',
                'email' => 'vavuniya@landtitle.gov.lk',
                'address' => 'No. 31, Kandy Road, Vavuniya',
            ],
            [
                'province' => 'Northern Province',
                'office' => 'Title Settlement Office – Mullaitivu',
                'phone' => '021-2294567',
                'email' => 'mullaitivu@landtitle.gov.lk',
                'address' => 'No. 8, Oddusuddan Road, Mullaitivu',
            ],
            // Eastern Province
            [
                'province' => 'Eastern Province',
                'office' => 'Title Settlement Office – Batticaloa',
                'phone' => '065-2234567',
                'email' => 'batticaloa@landtitle.gov.lk',
                'address' => 'No. 42, Bar Road, Batticaloa',
            ],
            [
                'province' => 'Eastern Province',
                'office' => 'Title Settlement Office – Ampara',
                'phone' => '063-2234567',
                'email' => 'ampara@landtitle.gov.lk',
                'address' => 'No. 18, D.S. Senanayake Street, Ampara',
            ],
            [
                'province' => 'Eastern Province',
                'office' => 'Title Settlement Office – Trincomalee',
                'phone' => '026-2234567',
                'email' => 'trincomalee@landtitle.gov.lk',
                'address' => 'No. 55, Dockyard Road, Trincomalee',
            ],
            // North Western Province
            [
                'province' => 'North Western Province',
                'office' => 'Title Settlement Office – Kurunegala',
                'phone' => '037-2234567',
                'email' => 'kurunegala@landtitle.gov.lk',
                'address' => 'No. 29, Colombo Road, Kurunegala',
            ],
            [
                'province' => 'North Western Province',
                'office' => 'Title Settlement Office – Puttalam',
                'phone' => '032-2234567',
                'email' => 'puttalam@landtitle.gov.lk',
                'address' => 'No. 14, Colombo Road, Puttalam',
            ],
            // North Central Province
            [
                'province' => 'North Central Province',
                'office' => 'Title Settlement Office – Anuradhapura',
                'phone' => '025-2234567',
                'email' => 'anuradhapura@landtitle.gov.lk',
                'address' => 'No. 72, Main Street, Anuradhapura',
            ],
            [
                'province' => 'North Central Province',
                'office' => 'Title Settlement Office – Polonnaruwa',
                'phone' => '027-2234567',
                'email' => 'polonnaruwa@landtitle.gov.lk',
                'address' => 'No. 38, Batticaloa Road, Polonnaruwa',
            ],
            // Uva Province
            [
                'province' => 'Uva Province',
                'office' => 'Title Settlement Office – Badulla',
                'phone' => '055-2234567',
                'email' => 'badulla@landtitle.gov.lk',
                'address' => 'No. 19, Bandarawela Road, Badulla',
            ],
            [
                'province' => 'Uva Province',
                'office' => 'Title Settlement Office – Monaragala',
                'phone' => '055-2276543',
                'email' => 'monaragala@landtitle.gov.lk',
                'address' => 'No. 7, Wellawaya Road, Monaragala',
            ],
            // Sabaragamuwa Province
            [
                'province' => 'Sabaragamuwa Province',
                'office' => 'Title Settlement Office – Ratnapura',
                'phone' => '045-2234567',
                'email' => 'ratnapura@landtitle.gov.lk',
                'address' => 'No. 63, Main Street, Ratnapura',
            ],
            [
                'province' => 'Sabaragamuwa Province',
                'office' => 'Title Settlement Office – Kegalle',
                'phone' => '035-2234567',
                'email' => 'kegalle@landtitle.gov.lk',
                'address' => 'No. 48, Kandy Road, Kegalle',
            ],
        ];

        return view('contact.regional-office', compact('districts'));
    }
}
