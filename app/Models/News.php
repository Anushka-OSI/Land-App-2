<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/** A News item or Notice in English / Sinhala / Tamil (Admin → News & Notices). */
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

    /** Only items visible on the public website, newest first. */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderByDesc('published_at')->orderByDesc('id');
    }
}
