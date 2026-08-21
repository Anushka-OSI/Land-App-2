<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Statistics Data
        $stats = [
            ['value' => 2800000, 'label' => 'Land Parcels Registered', 'icon' => 'map', 'suffix' => '+'],
            ['value' => 25, 'label' => 'Districts Covered', 'icon' => 'globe', 'suffix' => ''],
            ['value' => 26, 'label' => 'Years of Service', 'icon' => 'calendar', 'suffix' => '+'],
            ['value' => 48, 'label' => 'Regional Offices', 'icon' => 'building', 'suffix' => '+'],
        ];

        // Organizations Data
        $organizations = [
            ['name' => 'Ministry of Land and Land Development', 'logo' => null],
            ['name' => 'Survey Department', 'logo' => null],
            ['name' => 'Department of Land Title Settlement', 'logo' => null],
            ['name' => 'Government Press', 'logo' => null],
            ['name' => 'Land Commissioner General\'s Department', 'logo' => null],
            ['name' => 'Registrar General\'s Department', 'logo' => null],
        ];

        // Latest News (for the background slideshow)
        $latestNews = [
            [
                'id' => 1,
                'category' => 'News',
                'title' => 'Special Training Program on Title Registration in Sri Lanka',
                'excerpt' => 'A special training program was conducted for officers on modern title registration processes in the Anuradapura district.',
                'image' => 'https://images.unsplash.com/photo-1541888086968-3e4b7bed8a4a?w=1600&q=80',
                'date' => '2026-08-10',
            ],
            [
                'id' => 2,
                'category' => 'Notice',
                'title' => 'Land Settlement Operations in Galle District',
                'excerpt' => 'Public notice regarding land settlement operations commencing in the Galle district.',
                'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=1600&q=80',
                'date' => '2026-08-08',
            ],
            [
                'id' => 3,
                'category' => 'Event',
                'title' => 'Digital Land Registry Initiative Launch',
                'excerpt' => 'The Department of Land Title Settlement has officially launched its digital land registry platform.',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1600&q=80',
                'date' => '2026-08-05',
            ]
        ];

        return view('home', compact('stats', 'organizations', 'latestNews'));
    }
}
