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
                'title' => __('Executive Leadership'),
                'role' => __('Commissioner of Title Settlement'),
                'description' => __('Overall leadership, policy direction, and governance of title settlement across Sri Lanka.')
            ],
            [
                'title' => __('Lands Division'),
                'role' => __('Commissioner (Lands) & Deputy Commissioner'),
                'description' => __('Oversees the Land Division, Record Room, and determination of state vs. private land ownership under Ordinance No. 20 of 1931.')
            ],
            [
                'title' => __('Bimsaviya & Title Registration'),
                'role' => __('Deputy Commissioner (Investigations / Registration)'),
                'description' => __('Directs Title Investigations Division, Legal Affairs, Progress Management, and 18 Provincial Title Offices.')
            ],
            [
                'title' => __('Administration & Finance'),
                'role' => __('Deputy Commissioner (Administration) & Accountants'),
                'description' => __('Manages General Administration, Accounts Division, and IT/Computer Systems Division.')
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
                'act' => __('Land Settlement Ordinance No. 20 of 1931'),
                'title' => __('Determination of Land Ownership'),
                'description' => __('To decide on state and private land ownership under the Land Settlement Ordinance No. 20 of 1931, ensuring legal clarity for all parcels.'),
                'icon' => 'scale'
            ],
            [
                'id' => 2,
                'act' => __('Registration of Title Act No. 21 of 1998'),
                'title' => __('Public Awareness & Gazette Publication'),
                'description' => __('Creating awareness among state officers and communities, property investigations, investigations of documents available in the Land Registry, calling applications for title claims, investigation into title, recommendation, approval, taking decisions on title, and publication of such decisions in the Government Gazette.'),
                'icon' => 'document-check'
            ],
            [
                'id' => 3,
                'act' => __('Institutional Capacity'),
                'title' => __('Efficient Title Investigation & Settlement'),
                'description' => __('Investigations into title claims by strengthening institutional capacity, taking decisions on them and performance of land settlement activities efficiently and effectively.'),
                'icon' => 'building'
            ],
            [
                'id' => 4,
                'act' => __('Regional Operations'),
                'title' => __('Regional Office Optimization'),
                'description' => __('Increasing the efficiency of registration of title by means of running title investigation offices at regional level which function properly.'),
                'icon' => 'office'
            ],
            [
                'id' => 5,
                'act' => __('Public Trust & Engagement'),
                'title' => __('Fostering Public Confidence'),
                'description' => __('Taking action to seek public cooperation and to win public confidence in all instances of title investigations and decision taking.'),
                'icon' => 'users'
            ],
            [
                'id' => 6,
                'act' => __('Digital Transformation'),
                'title' => __('Land Ownership Information System'),
                'description' => __('Development and maintenance of an efficient and reliable information system on land ownership.'),
                'icon' => 'database'
            ],
            [
                'id' => 7,
                'act' => __('Good Governance'),
                'title' => __('Administrative & Accounting Systems'),
                'description' => __('Maintenance of efficient administrative and accounting systems to ensure institutional transparency and integrity.'),
                'icon' => 'cog'
            ],
        ];
    }
}
