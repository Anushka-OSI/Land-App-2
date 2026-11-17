<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public const TYPES = [
        'inquiry'  => 'Contact Inquiry',
        'question' => 'FAQ Question',
    ];

    public const STATUSES = [
        'new'     => 'New',
        'read'    => 'Read',
        'replied' => 'Replied',
    ];

    protected $fillable = [
        'type',
        'name',
        'email',
        'subject',
        'office',
        'body',
        'status',
        'admin_note',
    ];

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }
}
