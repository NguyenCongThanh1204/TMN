<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PostMedia extends Model
{
    protected $fillable = ['title', 'file_path'];

    // Tạo thuộc tính ảo 'url' để lấy link nhanh
    public function getUrlAttribute()
    {
        return Storage::disk('cloudinary')->url($this->file_path);
    }
}