<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'client_name',
        'location',
        'area_sqm',
        'year',
        'structural_type',
        'timeline',
        'cover_image',
        'body_content',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'year'        => 'integer',
    ];

    protected $appends = [
        'cover_url',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    /**
     * Lấy đường dẫn URL công khai của ảnh đại diện dự án
     * Sử dụng ngoài View/Blade: $project->cover_url
     */
    public function getCoverUrlAttribute(): ?string
    {
        if (! $this->cover_image) {
            return null;
        }

        // Nếu là URL bên ngoài (Unsplash, link ngoài) thì giữ nguyên
        if (Str::startsWith($this->cover_image, ['http://', 'https://'])) {
            return $this->cover_image;
        }

        return Storage::disk('cloudinary')->url($this->cover_image);
    }

    /**
     * Scope lấy dự án tiêu biểu được chọn hiện trang chủ
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope lấy dự án đã xuất bản
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    public function media()
    {
        return $this->hasMany(ProjectMedia::class)->orderBy('sort_order', 'asc');
    }
}