<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/** An Event in English / Sinhala / Tamil with up to 10 photos (Admin → Events). */
class Event extends Model
{
    use HasTranslations;

    public const MAX_IMAGES = 10;
    public const MAX_IMAGE_KB = 10240; // 10 MB

    public function getFillable()
    {
        return array_merge(static::translatableColumns(), ['event_date', 'is_published']);
    }

    protected $casts = [
        'event_date' => 'date',
        'is_published' => 'boolean',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(EventImage::class)->orderBy('sort_order')->orderBy('id');
    }

    /** First image of any language – used as the thumbnail in the admin list. */
    public function coverImage(): HasOne
    {
        return $this->hasOne(EventImage::class)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Photos added in one language tab. Each language has its own photos (a language may have none).
     * Uses the loaded "images" relation, so eager-load it with ->with('images').
     */
    public function imagesFor(string $lang)
    {
        return $this->images->where('language', $lang)->values();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderByDesc('event_date')->orderByDesc('id');
    }

    /** PHP's post_max_size in bytes (largest total upload in one save); 0 = unlimited. */
    public static function serverUploadLimit(): int
    {
        $value = trim((string) ini_get('post_max_size'));
        $number = (int) $value;

        return match (strtoupper(substr($value, -1))) {
            'G' => $number * 1024 ** 3,
            'M' => $number * 1024 ** 2,
            'K' => $number * 1024,
            default => $number,
        };
    }

    protected static function booted(): void
    {
        // Remove the image files too (rows are removed by the foreign key)
        static::deleting(function (Event $event) {
            $event->images->each->deleteFile();
        });
    }
}
