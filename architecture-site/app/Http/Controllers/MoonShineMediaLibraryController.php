<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\MediaFolder;
use App\Models\PostMedia;
use App\Models\ProjectMedia;
use App\Services\CloudinaryService;
use App\Services\MediaCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MoonShineMediaLibraryController extends Controller
{
    public function storeFolder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'parent_id' => ['nullable', 'integer', 'exists:media_folders,id'],
            'name' => ['required', 'string', 'max:120'],
        ]);

        $parentId = $validated['parent_id'] ?? null;

        MediaFolder::create([
            'parent_id' => $parentId,
            'name' => $validated['name'],
            'slug' => $this->uniqueFolderSlug($validated['name'], $parentId),
        ]);

        return $this->redirectToFolder($parentId)->with('status', 'Đã tạo thư mục.');
    }

    public function updateFolder(Request $request, MediaFolder $folder): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
        ]);

        $folder->update([
            'name' => $validated['name'],
            'slug' => $this->uniqueFolderSlug($validated['name'], $folder->parent_id, $folder),
        ]);

        return $this->redirectToFolder($folder->id)->with('status', 'Đã đổi tên thư mục.');
    }

    public function destroyFolder(MediaFolder $folder): RedirectResponse
    {
        if ($folder->children()->exists() || $folder->media()->exists()) {
            return $this->redirectToFolder($folder->id)
                ->with('error', 'Chỉ có thể xóa thư mục đang trống.');
        }

        $parentId = $folder->parent_id;
        $folder->delete();

        return $this->redirectToFolder($parentId)->with('status', 'Đã xóa thư mục.');
    }

    /**
     * Upload one or more images to Cloudinary and persist PostMedia records.
     * Accepts a single `file` OR multiple files via `files[]`.
     */
    public function upload(Request $request, CloudinaryService $cloudinary, MediaCatalog $catalog): RedirectResponse
    {
        $validated = $request->validate([
            'folder_id' => ['nullable', 'integer', 'exists:media_folders,id'],
            'file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:20480'],
            'files' => ['nullable', 'array', 'max:20'],
            'files.*' => ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:20480'],
            'caption' => ['nullable', 'string', 'max:255'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'keywords' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        // Collect files from either 'file' (single) or 'files[]' (multi)
        $uploads = [];
        if ($request->hasFile('files')) {
            $uploads = $request->file('files');
        } elseif ($request->hasFile('file')) {
            $uploads = [$request->file('file')];
        }

        if (empty($uploads)) {
            return $this->redirectToFolder($validated['folder_id'] ?? null)
                ->with('error', 'Vui lòng chọn ít nhất một ảnh để tải lên.');
        }

        $allFolders = MediaFolder::query()->get();
        $folder = isset($validated['folder_id'])
            ? $allFolders->firstWhere('id', (int) $validated['folder_id'])
            : null;
        $target = $catalog->uploadTarget($folder, $allFolders);

        if (! $target['uploadable']) {
            return $this->redirectToFolder($folder?->id)
                ->with('error', $target['message'] ?? 'Không thể tải ảnh lên thư mục này.');
        }

        $errors = [];
        $uploaded = 0;

        foreach ($uploads as $file) {
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $publicId = ($filename !== '' ? $filename : 'image').'-'.Str::lower(Str::random(8));

            $result = $cloudinary->upload($file, $target['directory'], $publicId);

            if (blank($result['public_id'] ?? null)) {
                $errors[] = $file->getClientOriginalName();

                continue;
            }

            if ($target['project_id'] !== null) {
                ProjectMedia::create([
                    'project_id' => $target['project_id'],
                    'file_path' => $result['public_id'],
                    'caption' => $validated['caption'] ?? null,
                ]);
            } else {
                PostMedia::create([
                    'post_id' => $target['post_id'],
                    'folder_id' => $folder?->id,
                    'file_path' => $result['public_id'],
                    'caption' => $validated['caption'] ?? null,
                    'alt_text' => $validated['alt_text'] ?? null,
                    'keywords' => $validated['keywords'] ?? null,
                    'description' => $validated['description'] ?? null,
                ]);
            }

            $uploaded++;
        }

        $status = $uploaded > 0
            ? "Đã tải lên {$uploaded} ảnh vào thư viện."
            : null;
        $error = ! empty($errors)
            ? 'Không thể tải lên: '.implode(', ', $errors)
            : null;

        $redirect = $this->redirectToFolder($folder?->id);

        if ($status) {
            $redirect = $redirect->with('status', $status);
        }
        if ($error) {
            $redirect = $redirect->with('error', $error);
        }

        return $redirect;
    }

    public function destroyMedia(PostMedia $media): RedirectResponse
    {
        $folderId = $media->folder_id;
        $media->delete();

        return $this->redirectToFolder($folderId)->with('status', 'Đã xóa bản ghi ảnh khỏi thư viện.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Private helpers
    // ─────────────────────────────────────────────────────────────────────────

    private function uniqueFolderSlug(string $name, int|string|null $parentId, ?MediaFolder $ignore = null): string
    {
        $baseSlug = Str::slug($name) ?: 'folder';
        $slug = $baseSlug;
        $counter = 1;

        while (
            MediaFolder::query()
                ->where('parent_id', $parentId)
                ->where('slug', $slug)
                ->when($ignore, fn ($query) => $query->whereKeyNot($ignore->getKey()))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function redirectToFolder(int|string|null $folderId): RedirectResponse
    {
        return redirect()->route('moonshine.page', array_filter([
            'pageUri' => 'media-library',
            'folder' => $folderId,
        ]));
    }
}
