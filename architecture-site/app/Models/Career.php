<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Career extends Model 
{
    protected $fillable = [
        'job_title',
        'department',
        'location',
        'salary_range',
        'description',
        'deadline',
        'status',
        'cover_image', // Cột vừa thêm từ Laragon
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    protected $appends = [
        'cover_url',
    ];

    public function scopeOpen($q)
    {
        return $q->where('status', 'open')
                 ->where(fn($x) => $x->whereNull('deadline')->orWhereDate('deadline', '>=', today()));
    }

    /**
     * Accessor lấy link ảnh bìa chuẩn: $career->cover_url
     */
    public function getCoverUrlAttribute(): ?string
    {
        if (empty($this->cover_image)) {
            return null;
        }

        if (str_starts_with($this->cover_image, 'http://') || str_starts_with($this->cover_image, 'https://')) {
            return $this->cover_image;
        }

        return Storage::disk('public')->url(ltrim($this->cover_image, '/'));
    }
}