<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('cloudinary_image_url')) {
    function cloudinary_image_url(?string $path, int $width = 800): ?string
    {
        if (blank($path)) {
            return null;
        }

        $url = str_starts_with($path, 'http://') || str_starts_with($path, 'https://')
            ? $path
            : Storage::disk('cloudinary')->url(ltrim($path, '/'));

        if (! str_contains((string) parse_url($url, PHP_URL_HOST), 'res.cloudinary.com')) {
            return $url;
        }

        return preg_replace(
            '#/upload/#',
            "/upload/w_{$width}/f_auto/q_auto/",
            $url,
            1
        ) ?: $url;
    }
}
