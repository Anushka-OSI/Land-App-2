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
                'title' => __('Declaration of Area in Government Gazette'),
                'section' => __('Section 12'),
                'description' => __('The Minister publishes a notification in the Government Gazette declaring a specific Grama Niladhari division as a Title Registration Area.'),
                'icon' => 'speaker'
            ],
            [
                'step' => 2,
                'title' => __('Cadastral Survey by Survey Department'),
                'section' => __('Section 11'),
                'description' => __('The Survey Department conducts precise digital boundary surveying of all land parcels in the declared area and prepares the official Cadastral Map with unique parcel IDs.'),
                'icon' => 'map'
            ],
            [
                'step' => 3,
                'title' => __('Calling for Applications for Title Claims'),
                'section' => __('Section 13'),
                'description' => __('A Gazette Notice is issued calling all owners and interest-holders to submit applications and documentary proof of their land ownership claims within a specified period.'),
                'icon' => 'document'
            ],
            [
                'step' => 4,
                'title' => __('On-Site Title Investigation & Evidence Verification'),
                'section' => __('Section 13'),
                'description' => __('Title Investigation Officers examine deeds, land registry records, ancestral pedigrees, and conduct field inquiries to cross-examine boundaries and resolve any conflicting claims.'),
                'icon' => 'search'
            ],
            [
                'step' => 5,
                'title' => __('Determination of Title by Commissioner'),
                'section' => __('Section 14'),
                'description' => __('The Title Settlement Officer / Commissioner makes a formal legal determination declaring the lawful owner and specifies 1st Class (Absolute) or 2nd Class Title.'),
                'icon' => 'scale'
            ],
            [
                'step' => 6,
                'title' => __('Publication of Determination in Gazette'),
                'section' => __('Section 14'),
                'description' => __('The official determination schedule is published in the Government Gazette, creating legal notice and public finality.'),
                'icon' => 'newspaper'
            ],
            [
                'step' => 7,
                'title' => __('Issuance of Government-Guaranteed Title Certificate'),
                'section' => __('Act No. 21'),
                'description' => __('The Registrar General enters the parcel into the Title Register and delivers the official Title Certificate to the registered landowner.'),
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
                'title' => __('Preliminary Field Investigation & Topographical Survey'),
                'section' => __('Survey Prep'),
                'description' => __('Identification of target settlement blocks, examining existing village boundaries, state reserves, and preparation of preliminary boundary plans.'),
                'icon' => 'compass'
            ],
            [
                'step' => 2,
                'title' => __('Publication of Settlement Notice'),
                'section' => __('Section 5'),
                'description' => __('Statutory Notice published in the Government Gazette and posted locally in three languages calling on all claimants of state/private lands to declare their claims.'),
                'icon' => 'bullhorn'
            ],
            [
                'step' => 3,
                'title' => __('Receiving Written Claims and Oral Inquiries'),
                'section' => __('Section 6'),
                'description' => __('Settlement Officers hold formal public hearings in the village, receiving documentary evidence, title deeds, receipts, and testimony from local residents and heirs.'),
                'icon' => 'clipboard'
            ],
            [
                'step' => 4,
                'title' => __('Determination of State Ownership vs. Private Lands'),
                'section' => __('Section 7'),
                'description' => __('Adjudication of state rights under the Land Settlement Ordinance No. 20 of 1931, segregating state reserves from bona fide private holdings.'),
                'icon' => 'gavel'
            ],
            [
                'step' => 5,
                'title' => __('Entering Settlement Agreements'),
                'section' => __('Section 8'),
                'description' => __('Formal settlement agreements signed between claimants and the Settlement Officer confirming agreed boundaries and ownership terms.'),
                'icon' => 'pencil'
            ],
            [
                'step' => 6,
                'title' => __('Gazette Publication of Final Settlement Order'),
                'section' => __('Section 9'),
                'description' => __('The final Settlement Order is approved by the Minister and published in the Government Gazette, establishing statutory title and state finality.'),
                'icon' => 'document-text'
            ],
            [
                'step' => 7,
                'title' => __('Delivery of Statutory Land Settlement Grants'),
                'section' => __('Final Grant'),
                'description' => __('Statutory Grants or Settlement Certificates are issued and handed over to private owners with undisputed legal status.'),
                'icon' => 'check-circle'
            ],
        ];

        return view('services.land-registration', compact('procedure'));
    }
}
