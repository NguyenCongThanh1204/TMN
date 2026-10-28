<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Career;
use App\Models\Leader;
use App\Models\MediaFolder;
use App\Models\Partner;
use App\Models\Post;
use App\Models\PostMedia;
use App\Models\Project;
use App\Models\ProjectMedia;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Builds the Media Library listing directly from the tables that own the images
 * (posts, post_media, projects, project_media, leaders, partners, careers)
 * instead of copying them into post_media.
 */
class MediaCatalog
{
    public const ROOT_POSTS = 'bai-viet';

    public const ROOT_PROJECTS = 'du-an';

    public const ROOT_LEADERS = 'lanh-dao';

    public const ROOT_PARTNERS = 'doi-tac';

    public const ROOT_CAREERS = 'tuyen-dung';

    /**
     * Images shown for a folder (or for every source when no folder is selected).
     *
     * @param  Collection<int, MediaFolder>  $allFolders
     * @return Collection<int, object>
     */
    public function items(?MediaFolder $folder, Collection $allFolders): Collection
    {
        $scope = $this->scope($folder, $allFolders);
        $items = collect();

        if ($scope['root'] === null || $scope['root'] === self::ROOT_POSTS) {
            $items = $items->concat($this->postItems($scope['slug']));
        }

        if ($scope['root'] === null || $scope['root'] === self::ROOT_PROJECTS) {
            $items = $items->concat($this->projectItems($scope['slug']));
        }

        if ($scope['root'] === null || ($scope['root'] === self::ROOT_LEADERS && $scope['slug'] === null)) {
            $items = $items->concat(
                Leader::query()->get(['id', 'name', 'image'])->map(
                    fn (Leader $leader): ?object => $this->item($leader->image, 'Lãnh đạo', $leader->name)
                )
            );
        }

        if ($scope['root'] === null || ($scope['root'] === self::ROOT_PARTNERS && $scope['slug'] === null)) {
            $items = $items->concat(
                Partner::query()->get(['id', 'name', 'logo'])->map(
                    fn (Partner $partner): ?object => $this->item($partner->logo, 'Đối tác', $partner->name)
                )
            );
        }

        if ($scope['root'] === null || ($scope['root'] === self::ROOT_CAREERS && $scope['slug'] === null)) {
            $items = $items->concat(
                Career::query()->get(['id', 'job_title', 'cover_image'])->map(
                    fn (Career $career): ?object => $this->item($career->cover_image, 'Tuyển dụng', $career->job_title)
                )
            );
        }

        $uploads = PostMedia::query()
            ->when($folder !== null, fn ($query) => $query->where('folder_id', $folder->id))
            ->whereNull('post_id')
            ->latest('id')
            ->get(['id', 'file_path', 'caption', 'alt_text'])
            ->map(fn (PostMedia $media): ?object => $this->item($media->file_path, 'Tải lên thư viện', $media->caption, $media->id));

        return $items->concat($uploads)
            ->filter()
            ->unique('file_path')
            ->values();
    }

    /**
     * Where uploads for a folder must be stored so they match the paths the site already uses.
     *
     * @param  Collection<int, MediaFolder>  $allFolders
     * @return array{directory: string, post_id: ?int, project_id: ?int, uploadable: bool, message: ?string}
     */
    public function uploadTarget(?MediaFolder $folder, Collection $allFolders): array
    {
        $scope = $this->scope($folder, $allFolders);
        $target = [
            'directory' => $this->genericDirectory($folder, $allFolders),
            'post_id' => null,
            'project_id' => null,
            'uploadable' => $folder === null || $scope['root'] === '',
            'message' => null,
        ];

        if ($scope['root'] === self::ROOT_POSTS) {
            $target['uploadable'] = false;
            $target['message'] = 'Hãy chọn thư mục của một bài viết cụ thể để ảnh được lưu đúng dữ liệu.';

            if ($scope['slug'] !== null) {
                $post = Post::query()->where('slug', $scope['slug'])->first(['id', 'slug']);

                if ($post !== null) {
                    $slug = Str::slug(trim($post->slug, '/')) ?: 'post-'.$post->id;
                    $target['directory'] = "posts/{$slug}/media";
                    $target['post_id'] = $post->id;
                    $target['uploadable'] = true;
                    $target['message'] = null;
                }
            }
        } elseif ($scope['root'] === self::ROOT_PROJECTS) {
            $target['uploadable'] = false;
            $target['message'] = 'Hãy chọn thư mục của một dự án cụ thể để ảnh được lưu đúng dữ liệu.';

            if ($scope['slug'] !== null) {
                $project = Project::query()->where('slug', $scope['slug'])->first(['id', 'slug']);

                if ($project !== null) {
                    $slug = Str::slug(trim($project->slug, '/')) ?: 'project-'.$project->id;
                    $target['directory'] = "projects/{$slug}/media";
                    $target['project_id'] = $project->id;
                    $target['uploadable'] = true;
                    $target['message'] = null;
                }
            }
        } elseif ($scope['root'] === self::ROOT_LEADERS) {
            $target['directory'] = 'leaders';
            $target['uploadable'] = false;
            $target['message'] = 'Ảnh lãnh đạo được lấy từ hồ sơ lãnh đạo. Hãy cập nhật ảnh trong form lãnh đạo.';
        } elseif ($scope['root'] === self::ROOT_PARTNERS) {
            $target['directory'] = 'partners';
            $target['uploadable'] = false;
            $target['message'] = 'Logo đối tác được lấy từ hồ sơ đối tác. Hãy cập nhật logo trong form đối tác.';
        } elseif ($scope['root'] === self::ROOT_CAREERS) {
            $target['directory'] = 'careers/covers';
            $target['uploadable'] = false;
            $target['message'] = 'Ảnh tuyển dụng được lấy từ hồ sơ tuyển dụng. Hãy cập nhật ảnh trong form tuyển dụng.';
        }

        return $target;
    }

    /**
     * @param  Collection<int, MediaFolder>  $allFolders
     * @return array{root: ?string, slug: ?string}
     */
    private function scope(?MediaFolder $folder, Collection $allFolders): array
    {
        if ($folder === null) {
            return ['root' => null, 'slug' => null];
        }

        $byId = $allFolders->keyBy('id');
        $node = $folder;
        $sourceFolder = null;

        while ($node->parent_id !== null && $byId->has($node->parent_id)) {
            $parent = $byId->get($node->parent_id);

            if ($parent->parent_id === null) {
                $sourceFolder = $node;
            }

            $node = $parent;
        }

        $root = $this->canonicalRoot($node->slug);

        if ($root === null) {
            return ['root' => '', 'slug' => null];
        }

        return ['root' => $root, 'slug' => $sourceFolder?->slug];
    }

    private function canonicalRoot(string $slug): ?string
    {
        return match ($slug) {
            self::ROOT_POSTS, 'news', 'posts', 'post' => self::ROOT_POSTS,
            self::ROOT_PROJECTS, 'projects', 'project' => self::ROOT_PROJECTS,
            self::ROOT_LEADERS, 'leaders', 'leadership' => self::ROOT_LEADERS,
            self::ROOT_PARTNERS, 'partners' => self::ROOT_PARTNERS,
            self::ROOT_CAREERS, 'careers' => self::ROOT_CAREERS,
            default => null,
        };
    }

    /**
     * @return Collection<int, object|null>
     */
    private function postItems(?string $slug): Collection
    {
        $posts = Post::query()
            ->when($slug !== null, fn ($query) => $query->where('slug', $slug))
            ->get(['id', 'title', 'thumbnail', 'thumbnail_caption', 'gallery']);

        $items = collect();

        foreach ($posts as $post) {
            $items->push($this->item($post->getRawOriginal('thumbnail'), 'Ảnh đại diện bài viết', $post->thumbnail_caption ?: $post->title));

            foreach ((array) ($post->gallery ?? []) as $entry) {
                $path = is_array($entry) ? ($entry['image'] ?? $entry['url'] ?? null) : $entry;
                $items->push($this->item($path, 'Thư viện bài viết', $post->title));
            }
        }

        $gallery = PostMedia::query()
            ->whereIn('post_id', $posts->pluck('id'))
            ->latest('id')
            ->get(['id', 'post_id', 'file_path', 'caption']);

        $titles = $posts->pluck('title', 'id');

        return $items->concat($gallery->map(
            fn (PostMedia $media): ?object => $this->item($media->file_path, 'Thư viện bài viết', $media->caption ?: $titles[$media->post_id] ?? null, $media->id)
        ));
    }

    /**
     * @return Collection<int, object|null>
     */
    private function projectItems(?string $slug): Collection
    {
        $projects = Project::query()
            ->when($slug !== null, fn ($query) => $query->where('slug', $slug))
            ->get(['id', 'title', 'cover_image']);

        $items = $projects->map(
            fn (Project $project): ?object => $this->item($project->cover_image, 'Ảnh bìa dự án', $project->title)
        );

        $titles = $projects->pluck('title', 'id');

        return $items->concat(
            ProjectMedia::query()
                ->whereIn('project_id', $projects->pluck('id'))
                ->orderBy('sort_order')
                ->get(['id', 'project_id', 'file_path', 'caption'])
                ->map(fn (ProjectMedia $media): ?object => $this->item($media->file_path, 'Thư viện dự án', $media->caption ?: $titles[$media->project_id] ?? null))
        );
    }

    private function item(mixed $path, string $source, ?string $caption, ?int $uploadId = null): ?object
    {
        if (! is_string($path) || trim($path) === '') {
            return null;
        }

        return (object) [
            'file_path' => $path,
            'caption' => $caption,
            'source' => $source,
            'upload_id' => $uploadId,
            'url' => (string) cloudinary_image_url($path, 1200),
            'thumbnail_url' => (string) cloudinary_image_url($path, 500),
        ];
    }

    /**
     * @param  Collection<int, MediaFolder>  $allFolders
     */
    private function genericDirectory(?MediaFolder $folder, Collection $allFolders): string
    {
        $byId = $allFolders->keyBy('id');
        $segments = [];

        while ($folder !== null) {
            array_unshift($segments, $folder->slug);
            $folder = $folder->parent_id !== null ? $byId->get($folder->parent_id) : null;
        }

        return $segments === [] ? 'media' : 'media/'.implode('/', $segments);
    }
}
