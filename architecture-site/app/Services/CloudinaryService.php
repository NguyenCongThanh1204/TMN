<?php

namespace App\Services;

use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\UploadedFile;

class CloudinaryService
{
    /**
     * Upload ảnh lên Cloudinary.
     */
    public function upload(
        UploadedFile|string $file,
        string $folder,
        ?string $publicId = null
    ): array {
        $source = $file instanceof UploadedFile
            ? $file->getRealPath()
            : $file;

        $options = [
            'folder' => trim($folder, '/'),
            'resource_type' => 'image',
            'overwrite' => true,
        ];

        if ($publicId) {
            $options['public_id'] = $publicId;
        }

        $result = (new UploadApi())->upload(
            $source,
            $options
        );

        return [
            'public_id' => $result['public_id'] ?? null,
            'secure_url' => $result['secure_url'] ?? null,
            'url' => $result['url'] ?? null,
            'width' => $result['width'] ?? null,
            'height' => $result['height'] ?? null,
            'format' => $result['format'] ?? null,
            'bytes' => $result['bytes'] ?? null,
        ];
    }

    /**
     * Xóa ảnh khỏi Cloudinary.
     */
    public function delete(string $publicId): void
    {
        (new UploadApi())->destroy(
            $publicId,
            [
                'resource_type' => 'image',
                'type' => 'upload',
                'invalidate' => true,
            ]
        );
    }
}