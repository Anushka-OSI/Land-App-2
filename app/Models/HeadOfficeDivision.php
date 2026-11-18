<?php

namespace App\Models;

use App\Models\Concerns\HasSimpleTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/** A division / section of the Head Office (Contact Us → Head Office). Managed in Admin → Head Office. */
class HeadOfficeDivision extends Model
{
    use HasSimpleTranslations;

    protected $fillable = [
        'division', 'division_si', 'division_ta',
        'position', 'position_si', 'position_ta',
        'officer', 'phone', 'fax', 'extension', 'email',
        'sort_order', 'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->ordered();
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
