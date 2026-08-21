<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = [
            [
                'id' => 1,
                'category' => 'News',
                'title' => 'Special Training Program on Title Registration in Sri Lanka – Anuradapura District',
                'excerpt' => 'A special training program was conducted for officers on modern title registration processes in the Anuradapura district.',
                'date' => '2026-08-10',
                'badge' => 'news',
            ],
            [
                'id' => 2,
                'category' => 'Notice',
                'title' => 'Public Notice – Notice of Public Investigation under Section 13',
                'excerpt' => 'Notice of Public Investigation under Section 13 of the Registration of Title Act No. 21 of 1998.',
                'date' => '2026-08-08',
                'badge' => 'notice',
            ],
            [
                'id' => 3,
                'category' => 'Event',
                'title' => 'Title Investigation Officers Training Programs – 2026 (Weligama, Matara)',
                'excerpt' => 'Upcoming training programs for Title Investigation Officers across the southern province.',
                'date' => '2026-08-15',
                'badge' => 'event',
            ],
            [
                'id' => 4,
                'category' => 'News',
                'title' => 'Department Launches Digital Land Registry Initiative',
                'excerpt' => 'The Department of Land Title Settlement has officially launched its digital land registry platform.',
                'date' => '2026-08-05',
                'badge' => 'news',
            ],
            [
                'id' => 5,
                'category' => 'Notice',
                'title' => 'Public Notice – Land Settlement Operations in Galle District',
                'excerpt' => 'Public notice regarding land settlement operations commencing in the Galle district.',
                'date' => '2026-08-03',
                'badge' => 'notice',
            ],
            [
                'id' => 6,
                'category' => 'Event',
                'title' => 'Annual Review Meeting – District Offices 2026',
                'excerpt' => 'Annual review meeting for all district office heads scheduled for September 2026.',
                'date' => '2026-09-05',
                'badge' => 'event',
            ],
        ];

        return view('news.index', compact('news'));
    }
}
