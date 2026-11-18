<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** A News item or Notice in English / Sinhala / Tamil, with optional documents (Admin → News & Notices). */
class News extends Model
{
    use HasTranslations;

    protected $table = 'news';

    protected $casts = [
        'published_at' => 'date',
        'is_published' => 'boolean',
    ];

    public function getFillable()
    {
        return array_merge(static::translatableColumns(), ['published_at', 'is_published']);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(NewsDocument::class)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Documents for a visitor reading in $lang: that language and "all languages" first,
     * then the versions in the other languages. Uses the loaded "documents" relation.
     */
    public function documentsFor(string $lang)
    {
        return $this->documents
            ->sortBy(fn (NewsDocument $d) => [$d->language === null || $d->language === $lang ? 0 : 1, $d->sort_order, $d->id])
            ->values();
    }

    /** Only items visible on the public website, newest first. */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderByDesc('published_at')->orderByDesc('id');
    }

    protected static function booted(): void
    {
        // Remove the document files too (rows are removed by the foreign key)
        static::deleting(function (News $news) {
            $news->documents->each->deleteFile();
        });
    }
}
