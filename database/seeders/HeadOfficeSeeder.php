<?php

namespace Database\Seeders;

use App\Models\HeadOfficeDivision;
use App\Support\HeadOfficeDetails;
use Illuminate\Database\Seeder;

/**
 * Starting content for Contact Us → Head Office: the Battaramulla address, its map location and a few divisions.
 * Everything can be changed in Admin → Head Office. Safe to run again: details the admin has
 * already entered are never overwritten, and divisions that already exist (same English name) are skipped.
 *
 *   php artisan db:seed --class=HeadOfficeSeeder
 */
class HeadOfficeSeeder extends Seeder
{
    public function run(): void
    {
        $this->details();
        $this->divisions();
    }

    private function details(): void
    {
        // Address as published in the Government Gazette notices of the department
        $defaults = [
            'name_en' => 'Department of Land Title Settlement – Head Office',
            'name_si' => 'ඉඩම් හිමිකම් නිරවුල් කිරීමේ දෙපාර්තමේන්තුව – ප්‍රධාන කාර්යාලය',
            'name_ta' => 'காணி உரித்து நிர்ணயத் திணைக்களம் – தலைமை அலுவலகம்',
            'address_en' => 'No. 1200/6, "Mihikatha Medura", Rajamalwatta Road, Battaramulla',
            'address_si' => 'අංක 1200/6, "මිහිකත මැදුර", රජමල්වත්ත පාර, බත්තරමුල්ල',
            'address_ta' => 'இல. 1200/6, "மிஹிகத மெதுர", ராஜமல்வத்தை வீதி, பத்தரமுல்லை',
            // Rajamalwatta Road, Battaramulla – fine-tune the pin in Admin → Head Office → Office details
            'latitude' => '6.9019226',
            'longitude' => '79.9180262',
        ];

        $current = HeadOfficeDetails::all();
        $merged = $current;
        foreach ($defaults as $field => $value) {
            if (blank($current[$field] ?? null)) {
                $merged[$field] = $value;
            }
        }

        if ($merged !== $current) {
            HeadOfficeDetails::save($merged);
        }
    }

    private function divisions(): void
    {
        $divisions = [
            [
                'division' => 'Administration Division',
                'division_si' => 'පරිපාලන අංශය',
                'division_ta' => 'நிர்வாகப் பிரிவு',
                'position' => 'Deputy Commissioner (Administration)',
                'position_si' => 'නියෝජ්‍ය කොමසාරිස් (පරිපාලන)',
                'position_ta' => 'பிரதி ஆணையாளர் (நிர்வாகம்)',
            ],
            [
                'division' => 'Title Registration Division',
                'division_si' => 'හිමිකම් ලියාපදිංචි කිරීමේ අංශය',
                'division_ta' => 'உரித்துப் பதிவுப் பிரிவு',
                'position' => 'Deputy Commissioner (Title Registration)',
                'position_si' => 'නියෝජ්‍ය කොමසාරිස් (හිමිකම් ලියාපදිංචි කිරීම)',
                'position_ta' => 'பிரதி ஆணையாளர் (உரித்துப் பதிவு)',
            ],
            [
                'division' => 'Accounts Division',
                'division_si' => 'ගිණුම් අංශය',
                'division_ta' => 'கணக்குப் பிரிவு',
                'position' => 'Chief Accountant',
                'position_si' => 'ප්‍රධාන ගණකාධිකාරී',
                'position_ta' => 'பிரதம கணக்காளர்',
            ],
        ];

        $order = (int) HeadOfficeDivision::max('sort_order');

        foreach ($divisions as $division) {
            if (HeadOfficeDivision::where('division', $division['division'])->exists()) {
                continue;
            }

            HeadOfficeDivision::create($division + [
                'sort_order' => $order += 10,
                'is_published' => true,
            ]);
        }
    }
}
