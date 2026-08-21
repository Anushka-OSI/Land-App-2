<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        return view('services.index');
    }

    public function titleRegistration()
    {
        $procedure = [
            [
                'step' => 1,
                'title' => 'Declaration of Area in Government Gazette',
                'section' => 'Section 12',
                'description' => 'The Minister publishes a notification in the Government Gazette declaring a specific Grama Niladhari division as a Title Registration Area.',
                'icon' => 'speaker'
            ],
            [
                'step' => 2,
                'title' => 'Cadastral Survey by Survey Department',
                'section' => 'Section 11',
                'description' => 'The Survey Department conducts precise digital boundary surveying of all land parcels in the declared area and prepares the official Cadastral Map with unique parcel IDs.',
                'icon' => 'map'
            ],
            [
                'step' => 3,
                'title' => 'Calling for Applications for Title Claims',
                'section' => 'Section 13',
                'description' => 'A Gazette Notice is issued calling all owners and interest-holders to submit applications and documentary proof of their land ownership claims within a specified period.',
                'icon' => 'document'
            ],
            [
                'step' => 4,
                'title' => 'On-Site Title Investigation & Evidence Verification',
                'section' => 'Section 13',
                'description' => 'Title Investigation Officers examine deeds, land registry records, ancestral pedigrees, and conduct field inquiries to cross-examine boundaries and resolve any conflicting claims.',
                'icon' => 'search'
            ],
            [
                'step' => 5,
                'title' => 'Determination of Title by Commissioner',
                'section' => 'Section 14',
                'description' => 'The Title Settlement Officer / Commissioner makes a formal legal determination declaring the lawful owner and specifies 1st Class (Absolute) or 2nd Class Title.',
                'icon' => 'scale'
            ],
            [
                'step' => 6,
                'title' => 'Publication of Determination in Gazette',
                'section' => 'Section 14',
                'description' => 'The official determination schedule is published in the Government Gazette, creating legal notice and public finality.',
                'icon' => 'newspaper'
            ],
            [
                'step' => 7,
                'title' => 'Issuance of Government-Guaranteed Title Certificate',
                'section' => 'Act No. 21',
                'description' => 'The Registrar General enters the parcel into the Title Register and delivers the official Title Certificate to the registered landowner.',
                'icon' => 'badge-check'
            ],
        ];

        return view('services.title-registration', compact('procedure'));
    }

    public function landRegistration()
    {
        $procedure = [
            [
                'step' => 1,
                'title' => 'Preliminary Field Investigation & Topographical Survey',
                'section' => 'Survey Prep',
                'description' => 'Identification of target settlement blocks, examining existing village boundaries, state reserves, and preparation of preliminary boundary plans.',
                'icon' => 'compass'
            ],
            [
                'step' => 2,
                'title' => 'Publication of Settlement Notice',
                'section' => 'Section 5',
                'description' => 'Statutory Notice published in the Government Gazette and posted locally in three languages calling on all claimants of state/private lands to declare their claims.',
                'icon' => 'bullhorn'
            ],
            [
                'step' => 3,
                'title' => 'Receiving Written Claims and Oral Inquiries',
                'section' => 'Section 6',
                'description' => 'Settlement Officers hold formal public hearings in the village, receiving documentary evidence, title deeds, receipts, and testimony from local residents and heirs.',
                'icon' => 'clipboard'
            ],
            [
                'step' => 4,
                'title' => 'Determination of State Ownership vs. Private Lands',
                'section' => 'Section 7',
                'description' => 'Adjudication of state rights under the Land Settlement Ordinance No. 20 of 1931, segregating state reserves from bona fide private holdings.',
                'icon' => 'gavel'
            ],
            [
                'step' => 5,
                'title' => 'Entering Settlement Agreements',
                'section' => 'Section 8',
                'description' => 'Formal settlement agreements signed between claimants and the Settlement Officer confirming agreed boundaries and ownership terms.',
                'icon' => 'pencil'
            ],
            [
                'step' => 6,
                'title' => 'Gazette Publication of Final Settlement Order',
                'section' => 'Section 9',
                'description' => 'The final Settlement Order is approved by the Minister and published in the Government Gazette, establishing statutory title and state finality.',
                'icon' => 'document-text'
            ],
            [
                'step' => 7,
                'title' => 'Delivery of Statutory Land Settlement Grants',
                'section' => 'Final Grant',
                'description' => 'Statutory Grants or Settlement Certificates are issued and handed over to private owners with undisputed legal status.',
                'icon' => 'check-circle'
            ],
        ];

        return view('services.land-registration', compact('procedure'));
    }
}
