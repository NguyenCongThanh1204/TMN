<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\MediaFolder;
use App\Services\MediaCatalog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Laravel\Pages\Page;
use MoonShine\UI\Components\FlexibleRender;

class MediaLibrary extends Page
{
    protected string $title = 'Media Library';

    protected function booted(): void
    {
        $this->alias('media-library');
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
    {
        return [
            FlexibleRender::make(
                fn (): string => view('app-moonshine::pages.media-library', $this->mediaViewData())->render()
            ),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function mediaViewData(): array
    {
        $folderId = request()->integer('folder') ?: null;
        $search = trim((string) request()->string('search'));
        $allFolders = MediaFolder::query()
            ->orderBy('name')
            ->get();
        $currentFolder = $folderId
            ? $allFolders->firstWhere('id', $folderId)
            : null;

        abort_if($folderId !== null && $currentFolder === null, 404);

        $foldersById = $allFolders->keyBy('id');
        $breadcrumbs = collect();
        $ancestor = $currentFolder;
        $catalog = app(MediaCatalog::class);
        $uploadTarget = $catalog->uploadTarget($currentFolder, $allFolders);

        while ($ancestor !== null) {
            $breadcrumbs->prepend($ancestor);
            $ancestor = $ancestor->parent_id !== null
                ? $foldersById->get($ancestor->parent_id)
                : null;
        }

        return [
            'currentFolder' => $currentFolder,
            'breadcrumbs' => $breadcrumbs,
            'folders' => $allFolders->groupBy(fn (MediaFolder $folder): string => (string) ($folder->parent_id ?? 0)),
            'subfolders' => $allFolders
                ->where('parent_id', $folderId)
                ->values(),
            'media' => $this->paginate(
                $catalog
                    ->items($currentFolder, $allFolders)
                    ->when($search !== '', fn (Collection $items): Collection => $items->filter(
                        fn (object $item): bool => Str::contains(
                            mb_strtolower($item->file_path.' '.$item->caption),
                            mb_strtolower($search)
                        )
                    )->values())
            ),
            'uploadTarget' => $uploadTarget,
            'search' => $search,
        ];
    }

    /**
     * @param  Collection<int, object>  $items
     */
    private function paginate(Collection $items): LengthAwarePaginator
    {
        $perPage = 24;
        $page = max(1, request()->integer('page', 1));

        return (new LengthAwarePaginator(
            $items->forPage($page, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        ))->withQueryString();
    }
}
