<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\News;
use App\Models\NewsDocument;
use App\Support\Languages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Public "News & Events" pages.
 * Content is managed in the admin panel (Admin → News & Notices, Admin → Events).
 * Each item can be written in English, Sinhala and Tamil and is shown in the visitor's site language
 * (falling back to another language when it has not been translated).
 */
class NewsController extends Controller
{
    public function index(Request $request)
    {
        $lang = self::contentLanguage($request);

        $news = News::published()->withCount('documents')->get();
        $events = Event::published()->with('images')->get();

        return view('news.index', compact('news', 'events', 'lang'));
    }

    public function show(Request $request, News $news)
    {
        abort_unless($news->is_published, 404);

        $lang = self::contentLanguage($request);
        $news->load('documents');
        $related = News::published()->whereKeyNot($news->id)->take(3)->get();

        return view('news.show', ['item' => $news, 'related' => $related, 'lang' => $lang]);
    }

    /**
     * A document attached to a News item: opens in the browser (PDF, images, text),
     * or downloads with ?download=1 (and always for Word, Excel …).
     * Documents of unpublished items can only be opened by an admin.
     */
    public function document(Request $request, News $news, NewsDocument $document): StreamedResponse
    {
        abort_unless((int) $document->news_id === (int) $news->id, 404);
        abort_unless($news->is_published || $request->user()?->is_admin, 404);

        $disk = Storage::disk(NewsDocument::DISK);
        abort_unless($disk->exists($document->path), 404);

        $inline = $document->canView() && ! $request->boolean('download');

        return $disk->response($document->path, $document->downloadName(), [
            'Content-Type' => $document->contentType(),
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => $news->is_published ? 'public, max-age=3600' : 'private, no-store',
        ], $inline ? 'inline' : 'attachment');
    }

    public function showEvent(Request $request, Event $event)
    {
        abort_unless($event->is_published, 404);

        $lang = self::contentLanguage($request);
        $event->load('images');
        $related = Event::published()->whereKeyNot($event->id)->take(3)->get();

        return view('news.event', ['item' => $event, 'related' => $related, 'lang' => $lang]);
    }

    /**
     * Language to read News & Events in: the site language chosen by the visitor
     * (see App\Http\Middleware\SetLocale). On an article page, ?read=xx shows that one
     * article in another language without changing the language of the whole website.
     */
    public static function contentLanguage(Request $request): string
    {
        $read = $request->query('read');

        return Languages::isValid($read) ? $read : Languages::current();
    }

    /**
     * The latest published News & Notices and Events (newest first) for the homepage.
     * Picked automatically – older items appear only on the News & Events pages.
     * Shape used by partials/latest-news-slideshow.
     */
    public static function homepageItems(string $lang = 'en', int $limit = 5)
    {
        $news = News::published()->take($limit)->get()
            ->map(fn (News $n) => [
                'type' => __('News & Notices'),
                'title' => $n->t('title', $lang),
                'excerpt' => $n->t('excerpt', $lang),
                'date' => $n->published_at,
                'language' => $n->displayLanguage($lang),
                'url' => route('news.show', $n),
            ]);

        $events = Event::published()->take($limit)->get()
            ->map(fn (Event $e) => [
                'type' => __('Event'),
                'title' => $e->t('title', $lang),
                'excerpt' => $e->t('excerpt', $lang),
                'date' => $e->event_date,
                'language' => $e->displayLanguage($lang),
                'url' => route('events.show', $e),
            ]);

        return $news->concat($events)->sortByDesc('date')->take($limit)->values();
    }
}
