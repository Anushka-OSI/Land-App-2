<?php

namespace App\Http\Controllers;

use App\Models\RegionalOffice;
use App\Support\HeadOfficeDetails;
use App\Support\OfficeLocations;


class HomeController extends Controller
{
    public function index()
    {
        // Statistics Data
        $stats = [
            ['value' => 2800000, 'label' => __('Land Parcels Registered'), 'icon' => 'map', 'suffix' => '+'],
            ['value' => 25, 'label' => __('Districts Covered'), 'icon' => 'globe', 'suffix' => ''],
            ['value' => 26, 'label' => __('Years of Service'), 'icon' => 'calendar', 'suffix' => '+'],
        ];

        // Organizations Data
        $organizations = [
            ['name' => __('Ministry of Land and Land Development'), 'logo' => null],
            ['name' => __('Survey Department'), 'logo' => null],
            ['name' => __('Department of Land Title Settlement'), 'logo' => null],
            ['name' => __('Government Press'), 'logo' => null],
            ['name' => __('Land Commissioner General\'s Department'), 'logo' => null],
            ['name' => __('Registrar General\'s Department'), 'logo' => null],
        ];

        // Homepage slideshow – the latest 5 published news, notices and events (automatic)
        $latestNews = NewsController::homepageItems(NewsController::contentLanguage(request()), 5);

        // Office map – every office the admin has placed on the map, plus the office counts
        $officeMap = [
            'offices' => OfficeLocations::all(),
            'headCount' => HeadOfficeDetails::text('name', 'en') ? 1 : 0,
            'regionalCount' => RegionalOffice::published()->count(),
        ];

        return view('home', compact('stats', 'organizations', 'latestNews', 'officeMap'));
    }
}
