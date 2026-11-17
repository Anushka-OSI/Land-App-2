<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ValidatesTranslations;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Support\Languages;
use Illuminate\Http\Request;

/** Admin → News & Notices (each item in English / Sinhala / Tamil) */
class NewsController extends Controller
{
    use ValidatesTranslations;

    public function index(Request $request)
    {
        $news = News::query()
            ->when($request->filled('q'), fn ($q) => $q->searchTitle($request->q))
            ->when(in_array($request->language, Languages::codes(), true), fn ($q) => $q->inLanguage($request->language))
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.form', ['item' => new News([
            'published_at' => now(),
            'is_published' => true,
        ])]);
    }

    public function store(Request $request)
    {
        News::create($this->validated($request));

        return redirect()->route('admin.news.index')->with('success', 'News item created.');
    }

    public function edit(News $news)
    {
        return view('admin.news.form', ['item' => $news]);
    }

    public function update(Request $request, News $news)
    {
        $news->update($this->validated($request));

        return redirect()->route('admin.news.index')->with('success', 'News item updated.');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News item deleted.');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate(
            $this->translationRules() + ['published_at' => 'required|date'],
            [],
            $this->translationAttributes() + ['published_at' => 'date']
        );

        return $this->translatedData($validated) + [
            'published_at' => $validated['published_at'],
            'is_published' => $request->boolean('is_published'),
        ];
    }
}
