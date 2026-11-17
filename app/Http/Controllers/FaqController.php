<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Message;
use App\Support\Languages;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * FAQ page – categorised questions + "Ask a question" form with related-FAQ suggestions.
     * FAQs are managed in the admin dashboard (Admin → FAQs).
     */
    public function index()
    {
        $categories = Faq::categoryLabels();
        $lang = Languages::current();

        $faqs = Faq::published()->get()->map(fn (Faq $faq) => [
            'id'       => $faq->slug,
            'category' => $faq->category,
            'question' => $faq->questionIn($lang),
            'answer'   => $faq->answerIn($lang),
            'keywords' => $faq->keywords ?? [],
        ])->values()->all();

        return view('faq', compact('categories', 'faqs'));
    }

    /**
     * Submit a question from the "Ask a question" form. Saved to Admin → Messages.
     */
    public function ask(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'question' => 'required|string|min:10|max:2000',
        ], [
            'question.min' => __('Please describe your question in a little more detail (at least 10 characters).'),
        ]);

        Message::create([
            'type'  => 'question',
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'body'  => $validated['question'],
        ]);

        return redirect(route('faq') . '#ask-question')
            ->with('success', __('Thank you! Your question has been submitted. Our officers will reply to your email within 3–5 working days.'))
            ->with('asked_question', $validated['question']);
    }
}
