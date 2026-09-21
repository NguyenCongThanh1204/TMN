<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'thumbnail_caption',
        'thumbnail_alt',
        'gallery',
        'author_name',
        'author_role',
        'is_featured',
        'views',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views'        => 'integer',
        'is_featured'  => 'boolean',
        'gallery'      => 'array',
    ];

    protected $appends = [
        'thumbnail_url',
        'gallery_items',
    ];

    /**
     * Accessor lấy URL ảnh đại diện chính
     */
    protected function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->thumbnail)) {
                    return null;
                }

                if (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://')) {
                    return $this->thumbnail;
                }

                return Storage::disk('cloudinary')->url($this->thumbnail);
            }
        );
    }

    /**
     * Accessor xử lý danh sách ảnh Gallery
     */
    protected function galleryItems(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->gallery) || !is_array($this->gallery)) {
                    return [];
                }

                return array_map(function ($item) {
                    if (is_string($item)) {
                        $url = (str_starts_with($item, 'http://') || str_starts_with($item, 'https://'))
                            ? $item 
                            : Storage::disk('cloudinary')->url($item);

                        return [
                            'image'   => $url,
                            'caption' => null,
                            'alt'     => null,
                        ];
                    }

                    $img = $item['image'] ?? ($item['url'] ?? '');
                    if ($img && !str_starts_with($img, 'http://') && !str_starts_with($img, 'https://')) {
                        $img = Storage::disk('cloudinary')->url($img);
                    }

                    return [
                        'image'   => $img,
                        'caption' => $item['caption'] ?? null,
                        'alt'     => $item['alt'] ?? null,
                    ];
                }, $this->gallery);
            }
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    public function media(): HasMany
    {
        return $this->hasMany(PostMedia::class, 'post_id');
    }

    /**
     * Scope lọc bài viết xuất bản dựa trên ngày giờ (đã bỏ status)
     */
    public function scopePublished($query)
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}