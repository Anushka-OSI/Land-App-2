<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Faq;
use App\Models\Message;
use App\Models\News;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'news'            => News::count(),
            'news_published'   => News::where('is_published', true)->count(),
            'events'          => Event::count(),
            'events_published' => Event::where('is_published', true)->count(),
            'faqs'            => Faq::count(),
            'faqs_hidden'     => Faq::where('is_published', false)->count(),
            'messages_new'    => Message::where('status', 'new')->count(),
            'inquiries'       => Message::where('type', 'inquiry')->count(),
            'questions'       => Message::where('type', 'question')->count(),
        ];

        $recentMessages = Message::latest()->take(6)->get();
        $recentNews = News::orderByDesc('published_at')->orderByDesc('id')->take(4)->get();
        $recentEvents = Event::withCount('images')->orderByDesc('event_date')->orderByDesc('id')->take(4)->get();

        return view('admin.dashboard', compact('stats', 'recentMessages', 'recentNews', 'recentEvents'));
    }
}
