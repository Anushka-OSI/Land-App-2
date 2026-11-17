<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class EventImage extends Model
{
    protected $fillable = ['event_id', 'language', 'path', 'sort_order'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Public URL. Files live on the "public" disk (storage/app/public/events/...),
     * served through the public/storage link. asset() uses the current host, so this works
     * even when APP_URL doesn't match the address the site is opened on.
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

    public function deleteFile(): void
    {
        Storage::disk('public')->delete($this->path);
    }
}
