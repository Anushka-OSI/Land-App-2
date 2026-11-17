<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    public const CATEGORIES = [
        'general'    => 'General',
        'title'      => 'Title Registration (Bimsaviya)',
        'settlement' => 'Land Settlement & Survey',
        'records'    => 'Finding Land Records',
        'disputes'   => 'Objections & Special Cases',
        'contact'    => 'Contact & Support',
    ];

    protected $fillable = [
        'slug',
        'category',
        'question',
        'answer',
        'question_si',
        'answer_si',
        'question_ta',
        'answer_ta',
        'keywords',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'keywords' => 'array',
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort_order')->orderBy('id');
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }

    /** Categories with labels in the visitor's language. */
    public static function categoryLabels(): array
    {
        return array_map(fn ($label) => __($label), self::CATEGORIES);
    }

    /** Question in $lang (si / ta / en); English when there is no translation. */
    public function questionIn(string $lang): string
    {
        return $lang === 'en' ? $this->question : ($this->getAttribute("question_{$lang}") ?: $this->question);
    }

    /** Answer in $lang (si / ta / en); English when there is no translation. */
    public function answerIn(string $lang): string
    {
        return $lang === 'en' ? $this->answer : ($this->getAttribute("answer_{$lang}") ?: $this->answer);
    }
}
