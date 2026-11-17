<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Sample News & Notices. Safe to run again: existing titles are updated.
     */
    public function run(): void
    {
        $news = [
            [
                'title_en' => 'Special Training Program on Title Registration in Sri Lanka – Anuradapura District',
                'excerpt_en' => 'A special training program was conducted for officers on modern title registration processes in the Anuradapura district.',
                'published_at' => '2026-08-10',
            ],
            [
                'title_en' => 'Public Notice – Notice of Public Investigation under Section 13',
                'excerpt_en' => 'Notice of Public Investigation under Section 13 of the Registration of Title Act No. 21 of 1998.',
                'published_at' => '2026-08-08',
            ],
            [
                'title_en' => 'Department Launches Digital Land Registry Initiative',
                'excerpt_en' => 'The Department of Land Title Settlement has officially launched its digital land registry platform.',
                'published_at' => '2026-08-05',
            ],
            [
                'title_en' => 'Public Notice – Land Settlement Operations in Galle District',
                'excerpt_en' => 'Public notice regarding land settlement operations commencing in the Galle district.',
                'published_at' => '2026-08-03',
            ],
        ];

        foreach ($news as $item) {
            News::updateOrCreate(['title_en' => $item['title_en']], $item + ['is_published' => true]);
        }
    }
}
