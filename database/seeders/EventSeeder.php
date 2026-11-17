<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Sample Events (photos are added in the admin panel). Safe to run again.
     */
    public function run(): void
    {
        $events = [
            [
                'title_en' => 'Title Investigation Officers Training Programs – 2026 (Weligama, Matara)',
                'excerpt_en' => 'Upcoming training programs for Title Investigation Officers across the southern province.',
                'event_date' => '2026-08-15',
            ],
            [
                'title_en' => 'Annual Review Meeting – District Offices 2026',
                'excerpt_en' => 'Annual review meeting for all district office heads scheduled for September 2026.',
                'event_date' => '2026-09-05',
            ],
        ];

        foreach ($events as $item) {
            Event::updateOrCreate(['title_en' => $item['title_en']], $item + [
                'is_published' => true,
            ]);
        }
    }
}
