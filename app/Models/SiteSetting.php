<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Key / value settings edited in the admin panel. */
class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /** Values for these keys: ['key' => 'value' | null]. */
    public static function many(array $keys): array
    {
        $stored = static::whereIn('key', $keys)->pluck('value', 'key')->all();

        return array_merge(array_fill_keys($keys, null), $stored);
    }

    /** Save several values at once. Empty values are stored as null. */
    public static function putMany(array $values): void
    {
        foreach ($values as $key => $value) {
            $value = is_string($value) ? trim($value) : $value;
            static::updateOrCreate(['key' => $key], ['value' => filled($value) ? $value : null]);
        }
    }
}
