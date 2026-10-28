<?php

declare(strict_types=1);

namespace App\MoonShine\Fields;

use Closure;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use MoonShine\Crud\Exceptions\FileFieldException;
use MoonShine\UI\Fields\Image;

class CloudinaryImage extends Image
{
    protected function booted(): void
    {
        parent::booted();

        // MoonShine 4 applies files via FileModelApply, so route saving through our own logic.
        $this->onApply(fn (mixed $item): mixed => ($this->resolveOnApply())($item));

        $this->customName(static function (UploadedFile $file): string {
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $slug = Str::slug($filename);

            return Str::substr($slug !== '' ? $slug : 'cover-image', 0, 60);
        });
    }

    public function isAllowedExtension(string $extension): bool
    {
        if ($extension === '') {
            return true;
        }

        return parent::isAllowedExtension($extension);
    }

    public function getRequestValue(int|string|null $index = null): mixed
    {
        $value = parent::getRequestValue($index);

        if ($value === null || $value === false) {
            return false;
        }

        if ($value instanceof UploadedFile && ! $value->isValid()) {
            return false;
        }

        return $value;
    }

    /**
     * Upload file lên Cloudinary và trả về đường dẫn URL để lưu vào Turso DB
     */
    public function store(UploadedFile $file): string
    {
        $extension = strtolower($file->getClientOriginalExtension() ?: ($file->extension() ?? ''));

        if (! $this->isAllowedExtension($extension)) {
            throw FileFieldException::extensionNotAllowed($extension);
        }

        $dir = trim($this->getDir(), '/');
        $publicId = Str::lower(Str::random(20));

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk($this->getDisk());

        try {
            // Thực hiện upload lên Cloudinary
            $storedPath = $disk->putFileAs(
                $dir,
                $file,
                $publicId,
                $this->getOptions()
            );
        } catch (\Throwable $e) {
            Log::warning('Cloudinary upload warning: '.$e->getMessage());
            $storedPath = false;
        }

        // Nếu Flysystem trả về false do lỗi visibility sau khi ảnh đã lên Cloudinary,
        // tự ghép lại public_id để vẫn lấy được URL lưu vào DB
        if (! is_string($storedPath) || trim($storedPath) === '') {
            $storedPath = $dir !== '' ? $dir.'/'.$publicId : $publicId;
        }

        // Lưu đường dẫn tương đối (giống các bài cũ), không lưu URL đầy đủ kèm query
        return $this->relativeStoredPath($storedPath, $dir, $publicId);
    }

    private function relativeStoredPath(string $storedPath, string $dir, string $publicId): string
    {
        $path = trim(preg_replace('#/{2,}#', '/', $storedPath) ?? $storedPath, '/');
        $folder = trim((string) config('flysystem-cloudinary.folder'), '/');

        if ($folder !== '' && str_starts_with($path, $folder.'/')) {
            $path = substr($path, strlen($folder) + 1);
        }

        return $path !== '' ? $path : ($dir !== '' ? $dir.'/'.$publicId : $publicId);
    }

    /**
     * Đảm bảo giá trị URL sau khi upload (hoặc ảnh cũ khi edit) được gán chuẩn kiểu string vào Model
     */
    protected function resolveOnApply(): ?Closure
    {
        return function (mixed $item): mixed {
            $column = $this->getColumn();
            $requestValue = $this->getRequestValue();
            $remainingValues = $this->getRemainingValues();

            data_forget($item, $this->getHiddenRemainingValuesKey());

            if ($this->isMultiple()) {
                $paths = [];

                if ($requestValue !== false && is_iterable($requestValue)) {
                    foreach ($requestValue as $file) {
                        if ($file instanceof UploadedFile) {
                            $paths[] = $this->store($file);
                        }
                    }
                }

                $newValue = $remainingValues->merge($paths)->values()->unique()->toArray();
            } else {
                $newValue = $requestValue instanceof UploadedFile
                    ? $this->store($requestValue)
                    : $remainingValues->first();
            }

            $this->removeExcludedFiles($newValue);

            // Ép kiểu string (hoặc null nếu xóa ảnh) để tương thích hoàn toàn với Turso/libSQL
            $finalValue = $this->isMultiple()
                ? $newValue
                : ($newValue !== null && $newValue !== '' ? (string) $newValue : null);

            return data_set($item, $column, $finalValue);
        };
    }

    /**
     * Ngăn lỗi xóa file cũ trên Cloudinary làm dừng tiến trình lưu DB
     */
    public function deleteFile(string $fileName): bool
    {
        try {
            if (str_starts_with($fileName, 'http://') || str_starts_with($fileName, 'https://')) {
                return false;
            }

            return parent::deleteFile($fileName);
        } catch (\Throwable $e) {
            Log::warning('Cloudinary delete file skipped: '.$e->getMessage());

            return false;
        }
    }

    public function getPathWithDir(string $value): string
    {
        $value = trim($value);

        if ($value === '') {
            return '';
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        if (str_contains($value, '/')) {
            $folder = trim((string) config('flysystem-cloudinary.folder'), '/');

            if ($folder !== '' && str_starts_with($value, $folder.'/')) {
                $value = substr($value, strlen($folder) + 1);
            }

            $value = preg_replace('/\.(?:jpe?g|png|webp)$/i', '', $value) ?? $value;

            try {
                return $this->getPath($value);
            } catch (\Throwable $e) {
                Log::warning('Cloudinary getPath error: '.$e->getMessage());

                return $value;
            }
        }

        return parent::getPathWithDir($value);
    }

    public function getDir(): string
    {
        return 'posts/'.self::resolveImageSlug().'/thumbnail';
    }

    private static function resolveImageSlug(): string
    {
        $value = request()->input('slug') ?: request()->input('title');
        $slug = Str::slug((string) $value);

        return Str::substr($slug !== '' ? $slug : 'bai-viet', 0, 80);
    }
}
