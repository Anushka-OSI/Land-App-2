<?php

namespace App\Models;

use App\Support\Languages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * A document attached to a News item / Notice (Admin → News & Notices).
 * Visitors can view it in the browser (PDF and images) or download it.
 */
class NewsDocument extends Model
{
    public const DISK = 'local';

    public const MAX_DOCUMENTS = 10;
    public const MAX_KB = 10240; // 10 MB

    /** Allowed file types and the Content-Type each is served with. */
    public const TYPES = [
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        'txt' => 'text/plain; charset=UTF-8',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
    ];

    /** These open in the browser; everything else is downloaded. */
    public const VIEWABLE = ['pdf', 'jpg', 'jpeg', 'png', 'txt'];

    protected $fillable = ['language', 'name', 'original_name', 'path', 'extension', 'size', 'sort_order'];

    protected $casts = ['size' => 'integer', 'sort_order' => 'integer'];

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }

    public function canView(): bool
    {
        return in_array($this->extension, self::VIEWABLE, true);
    }

    public function contentType(): string
    {
        return self::TYPES[$this->extension] ?? 'application/octet-stream';
    }

    /** File name used when downloading: the display name + extension. */
    public function downloadName(): string
    {
        $name = trim(preg_replace('/[\\\\\/:*?"<>|\x00-\x1F]+/u', ' ', $this->name)) ?: 'document';

        return $name . '.' . $this->extension;
    }

    /** "1.4 MB", "820 KB" */
    public function sizeLabel(): string
    {
        return $this->size >= 1024 * 1024
            ? number_format($this->size / 1024 / 1024, 1) . ' MB'
            : max(1, (int) round($this->size / 1024)) . ' KB';
    }

    /** "English" / "Sinhala" / "Tamil" / "All languages" (admin panel). */
    public function languageLabel(): string
    {
        return $this->language ? Languages::ALL[$this->language]['label'] : 'All languages';
    }

    /** Visitors: "PDF", "Word", "Excel" … */
    public function typeLabel(): string
    {
        return match ($this->extension) {
            'pdf' => 'PDF',
            'doc', 'docx', 'odt' => 'Word',
            'xls', 'xlsx', 'ods' => 'Excel',
            'ppt', 'pptx' => 'PowerPoint',
            'jpg', 'jpeg', 'png' => __('Image'),
            default => strtoupper($this->extension),
        };
    }

    public function url(bool $download = false): string
    {
        return route('news.documents.show', ['news' => $this->news_id, 'document' => $this->id] + ($download ? ['download' => 1] : []));
    }

    public function deleteFile(): void
    {
        Storage::disk(self::DISK)->delete($this->path);
    }
}
