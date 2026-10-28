<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\MediaFolder;
use App\Services\MediaCatalog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Lightweight JSON listing used by the in-page media picker modal.
 *
 * GET /manager/media-library/browse
 * Auth: moonshine
 */
class MediaBrowseController extends Controller
{
    private const PER_PAGE = 24;

    public function __invoke(Request $request, MediaCatalog $catalog): JsonResponse
    {
        $validated = $request->validate([
            'folder' => ['nullable', 'integer'],
            'hint' => ['nullable', 'string', 'max:255'],
            'search' => ['nullable', 'string', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $allFolders = MediaFolder::query()->orderBy('name')->get(['id', 'parent_id', 'name', 'slug']);
        $hint = trim((string) ($validated['hint'] ?? ''));
        $folderId = $validated['folder'] ?? null;

        if ($folderId === null && $hint !== '') {
            $folderId = $allFolders->first(
                fn (MediaFolder $folder): bool => $folder->parent_id !== null && $folder->slug === $hint
            )?->id;
        }

        $folder = $folderId !== null ? $allFolders->firstWhere('id', (int) $folderId) : null;
        $search = mb_strtolower(trim((string) ($validated['search'] ?? '')));
        $page = (int) ($validated['page'] ?? 1);

        $items = $catalog->items($folder, $allFolders);

        if ($search !== '') {
            $items = $items->filter(
                fn (object $item): bool => Str::contains(mb_strtolower($item->file_path.' '.$item->caption), $search)
            )->values();
        }

        return response()->json([
            'folder_id' => $folder?->id,
            'folders' => $allFolders->map(fn (MediaFolder $item): array => [
                'id' => $item->id,
                'parent_id' => $item->parent_id,
                'name' => $item->name,
            ])->values(),
            'items' => $items->forPage($page, self::PER_PAGE)->map(fn (object $item): array => [
                'file_path' => $item->file_path,
                'url' => $item->url,
                'thumbnail_url' => $item->thumbnail_url,
                'caption' => $item->caption,
            ])->values(),
            'page' => $page,
            'has_more' => $items->count() > $page * self::PER_PAGE,
            'total' => $items->count(),
        ]);
    }
}
