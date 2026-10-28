<?php

declare(strict_types=1);

namespace App\MoonShine\Fields;

use App\Models\Project;
use App\Models\ProjectMedia;
use App\Services\CloudinaryService;
use App\Services\PageCache;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use MoonShine\UI\Fields\Text;

/**
 * Edits project_media rows (detail images) from the project form: remove, add from the
 * Media Library, or upload new files. Rows are written after the project itself is saved.
 */
final class ProjectGallery extends Text
{
    public const MAX_UPLOADS = 20;

    protected string $view = 'app-moonshine::fields.project-gallery';

    protected function booted(): void
    {
        parent::booted();

        $processed = false;

        $this->onApply(static fn (mixed $item): mixed => $item)
            ->onAfterApply(function (mixed $item) use (&$processed): mixed {
                if ($processed || ! $item instanceof Project || ! $item->exists) {
                    return $item;
                }

                $processed = true;
                $this->syncGallery($item);
                PageCache::flushAfterCommit();

                return $item;
            });
    }

    /**
     * @return array<int, array{id: int, path: string, url: string, caption: ?string}>
     */
    protected function viewData(): array
    {
        $project = $this->getData()?->getOriginal();
        $items = $project instanceof Project && $project->exists
            ? $project->media()->get(['id', 'file_path', 'caption'])
            : collect();

        return [
            ...parent::viewData(),
            'galleryItems' => $items->map(fn (ProjectMedia $media): array => [
                'id' => $media->id,
                'path' => $media->file_path,
                'url' => (string) cloudinary_image_url($media->file_path, 300),
                'caption' => $media->caption,
            ])->all(),
        ];
    }

    private function syncGallery(Project $project): void
    {
        $request = request();

        $removeIds = collect($this->decodeList($request->input('gallery_remove')))
            ->filter(fn (mixed $id): bool => is_numeric($id))
            ->map(fn (mixed $id): int => (int) $id)
            ->all();

        if ($removeIds !== []) {
            $project->media()->whereIn('id', $removeIds)->delete();
        }

        $existing = $project->media()->pluck('file_path')->all();
        $nextOrder = (int) $project->media()->max('sort_order');
        $paths = collect($this->decodeList($request->input('gallery_add')))
            ->filter(fn (mixed $path): bool => is_string($path) && $this->isSafePath($path))
            ->map(fn (string $path): string => trim($path))
            ->unique()
            ->diff($existing)
            ->take(100);

        foreach ($paths as $path) {
            $project->media()->create(['file_path' => $path, 'sort_order' => ++$nextOrder]);
        }

        $files = $request->file('gallery_files');
        $files = is_array($files) ? $files : [];

        foreach (array_slice($files, 0, self::MAX_UPLOADS) as $file) {
            if (! $file instanceof UploadedFile || ! $file->isValid() || ! $this->isImage($file)) {
                continue;
            }

            $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $publicId = ($name !== '' ? Str::substr($name, 0, 60) : 'image').'-'.Str::lower(Str::random(8));
            $result = app(CloudinaryService::class)->upload($file, "projects/{$project->slug}/media", $publicId);

            if (filled($result['public_id'] ?? null)) {
                $project->media()->create(['file_path' => $result['public_id'], 'sort_order' => ++$nextOrder]);
            }
        }
    }

    /**
     * @return array<int, mixed>
     */
    private function decodeList(mixed $raw): array
    {
        $decoded = is_string($raw) ? json_decode($raw, true) : null;

        return is_array($decoded) ? $decoded : [];
    }

    private function isSafePath(string $path): bool
    {
        $path = trim($path);

        return $path !== ''
            && strlen($path) <= 500
            && ! str_contains($path, '..')
            && ! preg_match('#^[a-z][a-z0-9+.-]*:#i', $path);
    }

    private function isImage(UploadedFile $file): bool
    {
        return in_array(strtolower($file->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)
            && str_starts_with((string) $file->getMimeType(), 'image/');
    }
}
