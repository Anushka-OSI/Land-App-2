<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Initial FAQ content (previously hardcoded in FaqController). Safe to run again: existing slugs are updated.
     */
    public function run(): void
    {
        $faqs = [
            // ── General ─────────────────────────────────────
            [
                'slug' => 'what-does-department-do',
                'category' => 'general',
                'question' => 'What does the Department of Land Title Settlement do?',
                'answer' => 'The Department carries out land settlement and title registration across Sri Lanka. Through this process it determines the ownership of state-owned and private lands and confirms the title of every land parcel, helping to build an improved land management system for the country.',
                'keywords' => ['department', 'role', 'function', 'purpose', 'about', 'responsibility'],
            ],
            [
                'slug' => 'what-is-bimsaviya',
                'category' => 'general',
                'question' => 'What is the Bimsaviya programme?',
                'answer' => 'Bimsaviya is the national programme for registering land titles under the Registration of Title Act No. 21 of 1998. Instead of registering deeds, it registers the ownership (title) of each land parcel, so that every owner receives a clear, state-recognised Certificate of Title.',
                'keywords' => ['bimsaviya', 'bim saviya', 'programme', 'program', 'act', '1998', 'registration of title'],
            ],
            [
                'slug' => 'deed-vs-title',
                'category' => 'general',
                'question' => 'What is the difference between deed registration and title registration?',
                'answer' => 'Under deed registration, only the documents (deeds) are recorded, and ownership must be proved by tracing the chain of deeds. Under title registration, the ownership itself is investigated, decided and recorded in a title register, and a Certificate of Title is issued. This gives owners greater certainty and reduces land disputes.',
                'keywords' => ['deed', 'difference', 'title registration', 'deed registration', 'ownership', 'register'],
            ],

            // ── Title Registration ──────────────────────────
            [
                'slug' => 'certificate-of-title',
                'category' => 'title',
                'question' => 'What is a Certificate of Title?',
                'answer' => 'A Certificate of Title is the official document issued after title registration. It shows the registered owner(s), the land parcel (lot) and its extent according to the cadastral map, and any registered interests such as mortgages. It is the main proof of ownership for a registered parcel.',
                'keywords' => ['certificate', 'title', 'document', 'proof', 'ownership', 'issued'],
            ],
            [
                'slug' => 'first-second-class',
                'category' => 'title',
                'question' => 'What is the difference between a First Class and a Second Class title?',
                'answer' => 'A First Class title is granted when ownership is clearly established. A Second Class title is granted when ownership is based mainly on long-term possession and documentary evidence is not sufficient. A Second Class title can later be converted to a First Class title in accordance with the provisions of the Registration of Title Act.',
                'keywords' => ['first class', 'second class', '1st class', '2nd class', 'class', 'type of title', 'possession'],
            ],
            [
                'slug' => 'documents-needed',
                'category' => 'title',
                'question' => 'What documents should I keep ready for title registration?',
                'answer' => 'Keep copies of your deeds and survey plans, inheritance or succession documents (if applicable), assessment tax or other receipts that show possession, and your National Identity Card (NIC). Officers may ask for these during the investigation of ownership.',
                'keywords' => ['documents', 'papers', 'required', 'need', 'deed', 'plan', 'nic', 'proof', 'evidence', 'prepare'],
            ],
            [
                'slug' => 'existing-deeds',
                'category' => 'title',
                'question' => 'Are my existing deeds still valid after title registration?',
                'answer' => 'Once a parcel is registered under the Registration of Title Act, the title register becomes the official record of ownership and future transactions are carried out under title registration. You should still keep your old deeds safely for your records.',
                'keywords' => ['deed', 'old deed', 'valid', 'existing', 'after registration', 'transaction', 'sell', 'transfer'],
            ],
            [
                'slug' => 'area-covered',
                'category' => 'title',
                'question' => 'How do I know whether title registration is being carried out in my area?',
                'answer' => 'Areas selected for title registration are declared by notice published in the Government Gazette. Public notices are also issued locally before work begins. You can check the News & Events section of this website or contact your regional office.',
                'keywords' => ['area', 'my area', 'village', 'district', 'covered', 'gazette', 'notice', 'when', 'started'],
            ],

            // ── Settlement & Survey ─────────────────────────
            [
                'slug' => 'survey-process',
                'category' => 'settlement',
                'question' => 'What happens when my land is surveyed?',
                'answer' => 'The Survey Department surveys each parcel and prepares a cadastral map. Land owners or occupiers should be present on the day of the survey to show the boundaries of their land. Each parcel is given a lot number on the map.',
                'keywords' => ['survey', 'surveyor', 'boundary', 'boundaries', 'measure', 'cadastral', 'map'],
            ],
            [
                'slug' => 'cadastral-map',
                'category' => 'settlement',
                'question' => 'What are the Map No, Block No, Sheet No and Lot No?',
                'answer' => 'These numbers identify your parcel on the cadastral map. The Map No identifies the cadastral map, the Block No and Sheet No identify the part of that map, and the Lot No identifies your parcel. You need all four to search for your land on the Find Land page.',
                'keywords' => ['map no', 'block no', 'sheet no', 'lot no', 'map number', 'lot number', 'cadastral', 'parcel'],
            ],
            [
                'slug' => 'how-long',
                'category' => 'settlement',
                'question' => 'How long does the land settlement and title registration process take?',
                'answer' => 'The time depends on the area, the number of parcels and whether there are any claims or disputes. The process includes surveying, investigation of ownership, publication of determinations in the Gazette and the issue of certificates. You can check the current stage of your parcel on the Find Land page.',
                'keywords' => ['how long', 'time', 'duration', 'delay', 'when', 'process', 'stages', 'steps'],
            ],

            // ── Finding Land Records ────────────────────────
            [
                'slug' => 'check-status',
                'category' => 'records',
                'question' => 'How can I check the status of my land?',
                'answer' => 'Go to the Find Land page and enter the Map No, Block No, Sheet No and Lot No of your parcel. You can also search by NIC number from the search bar on the home page. The result shows details such as the current stage, owner name and land size.',
                'keywords' => ['status', 'check', 'find', 'search', 'online', 'track', 'progress'],
            ],
            [
                'slug' => 'find-lot-number',
                'category' => 'records',
                'question' => 'I don\'t know my Map, Block, Sheet or Lot number. Where can I find them?',
                'answer' => 'These numbers are given on the cadastral map and on the notices issued during the survey. If you don\'t have them, contact the regional office for your district with your NIC and details of the land, and the officers will help you identify your parcel.',
                'keywords' => ['dont know', 'lot number', 'map number', 'find number', 'where', 'lost', 'missing'],
            ],
            [
                'slug' => 'current-stage',
                'category' => 'records',
                'question' => 'What does the "Current Stage" in my search result mean?',
                'answer' => 'Current Stage shows how far your parcel has progressed in the settlement and title registration process – for example, whether the details have been published, gazetted or a certificate has been issued. If your parcel seems to be stuck at one stage, contact your regional office.',
                'keywords' => ['current stage', 'stage', 'status', 'online publish', 'gazetted', 'meaning', 'result'],
            ],
            [
                'slug' => 'no-record-found',
                'category' => 'records',
                'question' => 'Why does the search say "No Records Found" for my land?',
                'answer' => 'Please check that all numbers were entered correctly. Your parcel may also not be in an area where title registration has started yet, or its details may not yet be available online. Contact your regional office for help.',
                'keywords' => ['no records', 'not found', 'search not working', 'error', 'cannot find', 'missing record'],
            ],

            // ── Objections & Special Cases ──────────────────
            [
                'slug' => 'objection',
                'category' => 'disputes',
                'question' => 'What can I do if I disagree with the decision about my land?',
                'answer' => 'Determinations of ownership are published in the Government Gazette. If you disagree, you can submit an objection or appeal within the period stated in the Gazette notice. Contact your regional office as early as possible for guidance on the procedure.',
                'keywords' => ['disagree', 'objection', 'appeal', 'dispute', 'wrong', 'complaint', 'decision', 'determination', 'claim'],
            ],
            [
                'slug' => 'owner-deceased',
                'category' => 'disputes',
                'question' => 'The land owner has passed away. How do the heirs register the title?',
                'answer' => 'The heirs should inform the investigating officers or the regional office and provide the death certificate and documents that show the succession (such as a will or proof of relationship). The title will be determined according to the applicable law of inheritance.',
                'keywords' => ['died', 'death', 'deceased', 'passed away', 'heir', 'heirs', 'inheritance', 'will', 'succession'],
            ],
            [
                'slug' => 'name-error',
                'category' => 'disputes',
                'question' => 'There is a mistake in my name or land details. How do I correct it?',
                'answer' => 'Contact your regional office with your NIC and documents that show the correct details. Officers will check the record and advise you on how the correction can be made.',
                'keywords' => ['mistake', 'error', 'wrong name', 'correct', 'correction', 'incorrect', 'spelling', 'change'],
            ],

            // ── Contact & Support ───────────────────────────
            [
                'slug' => 'contact-office',
                'category' => 'contact',
                'question' => 'How can I contact the Department?',
                'answer' => 'You can contact the Head Office in Battaramulla or any of the regional offices. Contact details are available under Contact Us → Head Office and Regional Offices. You can also send an inquiry online from the Contact Us → Inquiry page.',
                'keywords' => ['contact', 'phone', 'email', 'address', 'office', 'head office', 'regional office', 'call', 'visit'],
            ],
            [
                'slug' => 'which-office',
                'category' => 'contact',
                'question' => 'Which office should I visit for my land?',
                'answer' => 'Visit the regional office that covers the district where your land is located. The list of regional offices and their contact details is available on the Regional Offices page.',
                'keywords' => ['which office', 'regional office', 'district', 'visit', 'nearest', 'location'],
            ],
        ];

        foreach ($faqs as $i => $faq) {
            // Sinhala / Tamil versions come from the website translation files (lang/si.json, lang/ta.json)
            foreach (['si', 'ta'] as $lang) {
                foreach (['question', 'answer'] as $field) {
                    $translated = __($faq[$field], [], $lang);
                    $faq["{$field}_{$lang}"] = $translated !== $faq[$field] ? $translated : null;
                }
            }

            Faq::updateOrCreate(
                ['slug' => $faq['slug']],
                $faq + ['sort_order' => ($i + 1) * 10, 'is_published' => true]
            );
        }
    }
}
