<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $faqs = Faq::query()
            ->when($request->filled('q'), fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('question', 'like', '%' . $request->q . '%')
                    ->orWhere('answer', 'like', '%' . $request->q . '%');
            }))
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
            ->orderBy('category')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(25)
            ->withQueryString();

        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        $nextOrder = (int) Faq::max('sort_order') + 10;

        return view('admin.faqs.form', ['faq' => new Faq([
            'category' => array_key_first(Faq::CATEGORIES),
            'sort_order' => $nextOrder,
            'is_published' => true,
        ])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['question']);

        Faq::create($data);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.form', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $faq->update($this->validated($request));

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'category'   => ['required', Rule::in(array_keys(Faq::CATEGORIES))],
            'question'   => 'required|string|max:255',
            'answer'     => 'required|string|max:5000',
            'question_si' => 'nullable|string|max:255',
            'answer_si'   => 'nullable|string|max:5000',
            'question_ta' => 'nullable|string|max:255',
            'answer_ta'   => 'nullable|string|max:5000',
            'keywords'   => 'nullable|string|max:1000',
            'sort_order' => 'required|integer|min:0|max:100000',
        ]);

        // "deed, title deed, ownership" -> ['deed', 'title deed', 'ownership']
        $data['keywords'] = collect(explode(',', $data['keywords'] ?? ''))
            ->map(fn ($k) => trim(Str::lower($k)))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }

    private function uniqueSlug(string $question): string
    {
        $base = Str::limit(Str::slug($question), 60, '') ?: 'faq';
        $slug = $base;
        $i = 2;

        while (Faq::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
