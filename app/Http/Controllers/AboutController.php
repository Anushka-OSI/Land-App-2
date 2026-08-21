<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $aims = $this->getAims();
        return view('about.index', compact('aims'));
    }

    public function overview()
    {
        $aims = $this->getAims();
        return view('about.overview', compact('aims'));
    }

    public function organizationChart()
    {
        $departments = [
            [
                'title' => 'Executive Leadership',
                'role' => 'Commissioner of Title Settlement',
                'description' => 'Overall leadership, policy direction, and governance of title settlement across Sri Lanka.'
            ],
            [
                'title' => 'Lands Division',
                'role' => 'Commissioner (Lands) & Deputy Commissioner',
                'description' => 'Oversees the Land Division, Record Room, and determination of state vs. private land ownership under Ordinance No. 20 of 1931.'
            ],
            [
                'title' => 'Bimsaviya & Title Registration',
                'role' => 'Deputy Commissioner (Investigations / Registration)',
                'description' => 'Directs Title Investigations Division, Legal Affairs, Progress Management, and 18 Provincial Title Offices.'
            ],
            [
                'title' => 'Administration & Finance',
                'role' => 'Deputy Commissioner (Administration) & Accountants',
                'description' => 'Manages General Administration, Accounts Division, and IT/Computer Systems Division.'
            ],
        ];

        return view('about.organization-chart', compact('departments'));
    }

    public function aims()
    {
        $aims = $this->getAims();
        return view('about.aims', compact('aims'));
    }

    private function getAims(): array
    {
        return [
            [
                'id' => 1,
                'act' => 'Land Settlement Ordinance No. 20 of 1931',
                'title' => 'Determination of Land Ownership',
                'description' => 'To decide on state and private land ownership under the Land Settlement Ordinance No. 20 of 1931, ensuring legal clarity for all parcels.',
                'icon' => 'scale'
            ],
            [
                'id' => 2,
                'act' => 'Registration of Title Act No. 21 of 1998',
                'title' => 'Public Awareness & Gazette Publication',
                'description' => 'Creating awareness among state officers and communities, property investigations, investigations of documents available in the Land Registry, calling applications for title claims, investigation into title, recommendation, approval, taking decisions on title, and publication of such decisions in the Government Gazette.',
                'icon' => 'document-check'
            ],
            [
                'id' => 3,
                'act' => 'Institutional Capacity',
                'title' => 'Efficient Title Investigation & Settlement',
                'description' => 'Investigations into title claims by strengthening institutional capacity, taking decisions on them and performance of land settlement activities efficiently and effectively.',
                'icon' => 'building'
            ],
            [
                'id' => 4,
                'act' => 'Regional Operations',
                'title' => 'Regional Office Optimization',
                'description' => 'Increasing the efficiency of registration of title by means of running title investigation offices at regional level which function properly.',
                'icon' => 'office'
            ],
            [
                'id' => 5,
                'act' => 'Public Trust & Engagement',
                'title' => 'Fostering Public Confidence',
                'description' => 'Taking action to seek public cooperation and to win public confidence in all instances of title investigations and decision taking.',
                'icon' => 'users'
            ],
            [
                'id' => 6,
                'act' => 'Digital Transformation',
                'title' => 'Land Ownership Information System',
                'description' => 'Development and maintenance of an efficient and reliable information system on land ownership.',
                'icon' => 'database'
            ],
            [
                'id' => 7,
                'act' => 'Good Governance',
                'title' => 'Administrative & Accounting Systems',
                'description' => 'Maintenance of efficient administrative and accounting systems to ensure institutional transparency and integrity.',
                'icon' => 'cog'
            ],
        ];
    }
}
