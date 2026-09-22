<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TinyEditorUploadController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'file' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,gif,webp',
                'max:10240',
            ],
        ]);

        $file = $request->file('file');

        /*
         * TinyEditor gửi slug hiện tại của bài viết.
         */
        $slug = $request->input('slug');

        if ($slug) {
            $slug = Str::slug($slug);
        }

        /*
         * Khi đang tạo bài viết mới mà slug chưa có,
         * sử dụng thư mục tạm.
         */
        if (!$slug) {
            $slug = 'bai-viet-moi';
        }

        $directory = "posts/{$slug}/content";

        $path = $file->store(
            $directory,
            'cloudinary'
        );

        return response()->json([
            'location' => Storage::disk('cloudinary')->url($path),
        ]);
    }
}