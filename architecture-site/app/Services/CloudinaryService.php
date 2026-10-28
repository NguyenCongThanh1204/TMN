<?php

namespace App\Services;

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use Illuminate\Http\UploadedFile;
use RuntimeException;

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
        $this->configureCloudinary();

        $source = $file instanceof UploadedFile
            ? $file->getRealPath()
            : $file;

        $options = [
            'folder' => $this->withDiskPrefix(trim($folder, '/')),
            'resource_type' => 'image',
            'overwrite' => true,
        ];

        if ($publicId) {
            $options['public_id'] = $publicId;
        }

        $result = (new UploadApi)->upload(
            $source,
            $options
        );

        return [
            'public_id' => $this->withoutDiskPrefix($result['public_id'] ?? null),
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
        $this->configureCloudinary();

        (new UploadApi)->destroy(
            $this->withDiskPrefix(ltrim($publicId, '/')),
            [
                'resource_type' => 'image',
                'type' => 'upload',
                'invalidate' => true,
            ]
        );
    }

    /**
     * The Flysystem Cloudinary disk prepends this folder to every path it resolves,
     * so stored paths must stay relative to it.
     */
    private function diskPrefix(): string
    {
        return trim((string) config('flysystem-cloudinary.folder'), '/');
    }

    private function withDiskPrefix(string $path): string
    {
        $prefix = $this->diskPrefix();

        return $prefix === '' || str_starts_with($path, $prefix.'/') ? $path : $prefix.'/'.$path;
    }

    private function withoutDiskPrefix(?string $path): ?string
    {
        $prefix = $this->diskPrefix();

        return $path !== null && $prefix !== '' && str_starts_with($path, $prefix.'/')
            ? substr($path, strlen($prefix) + 1)
            : $path;
    }

    private function configureCloudinary(): void
    {
        $diskConfig = config('filesystems.disks.cloudinary');

        foreach (['cloud_name', 'api_key', 'api_secret'] as $key) {
            if (! is_string($diskConfig[$key] ?? null) || trim($diskConfig[$key]) === '') {
                throw new RuntimeException(
                    'Cloudinary configuration is incomplete: set CLOUDINARY_'.strtoupper($key).'.'
                );
            }
        }

        $cloud = Configuration::instance()->cloud;
        $cloud->cloudName = $diskConfig['cloud_name'];
        $cloud->apiKey = $diskConfig['api_key'];
        $cloud->apiSecret = $diskConfig['api_secret'];
    }
}
