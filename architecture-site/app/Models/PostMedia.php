<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostMedia extends Model
{
    protected $table = 'post_media';

    protected $fillable = [
        'post_id',
        'folder_id',
        'file_path',
        'caption',
        'alt_text',
        'keywords',
        'description',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(MediaFolder::class);
    }

    /**
     * Full HTTPS URL for this media item.
     */
    public function getUrlAttribute(): string
    {
        return (string) cloudinary_image_url($this->file_path, 1200);
    }

    /**
     * URL suitable for thumbnails in admin UI.
     */
    public function getThumbnailUrlAttribute(): string
    {
        return (string) cloudinary_image_url($this->file_path, 400);
    }

    /**
     * Returns an array of lowercase trimmed keywords parsed from the keywords column.
     * Used by the recommendation engine.
     *
     * @return list<string>
     */
    public function parsedKeywords(): array
    {
        if (blank($this->keywords)) {
            return [];
        }

        return array_values(array_filter(
            array_map('trim', explode(',', mb_strtolower((string) $this->keywords)))
        ));
    }

    /**
     * Searchable text blob combining all text metadata for scoring.
     */
    public function searchableText(): string
    {
        return mb_strtolower(implode(' ', array_filter([
            $this->file_path,
            $this->caption,
            $this->alt_text,
            $this->keywords,
            $this->description,
            $this->folder?->name,
        ])));
    }
}
