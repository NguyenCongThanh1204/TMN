<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\MediaFolder;
use App\Models\Post;
use App\Models\Project;
use App\Services\MediaCatalog;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

#[Signature('media:sync-library {--dry-run : Show what would be created without writing}')]
#[Description('Create Media Library folders for posts, projects, leaders, partners and careers. Images are read from their own tables; nothing is copied into post_media.')]
class SyncMediaLibrary extends Command
{
    private bool $dryRun = false;

    private int $createdFolders = 0;

    public function handle(): int
    {
        $this->dryRun = (bool) $this->option('dry-run');

        $postsRoot = $this->folder('Bài viết', MediaCatalog::ROOT_POSTS, null, ['news', 'posts', 'post']);
        Post::query()->orderBy('id')->get(['id', 'title', 'slug'])
            ->each(fn (Post $post) => $this->folder($post->title, $post->slug, $postsRoot));

        $projectsRoot = $this->folder('Dự án', MediaCatalog::ROOT_PROJECTS, null, ['projects', 'project']);
        Project::query()->orderBy('id')->get(['id', 'title', 'slug'])
            ->each(fn (Project $project) => $this->folder($project->title, $project->slug, $projectsRoot));

        $this->folder('Lãnh đạo', MediaCatalog::ROOT_LEADERS, null, ['leaders', 'leadership']);
        $this->folder('Đối tác', MediaCatalog::ROOT_PARTNERS, null, ['partners']);
        $this->folder('Tuyển dụng', MediaCatalog::ROOT_CAREERS, null, ['careers']);

        $this->info(sprintf('%s: %d thư mục mới.', $this->dryRun ? 'Dry-run' : 'Hoàn tất', $this->createdFolders));

        return self::SUCCESS;
    }

    /**
     * @param  list<string>  $aliases
     */
    private function folder(string $name, string $slug, ?MediaFolder $parent, array $aliases = []): MediaFolder
    {
        $query = MediaFolder::query()
            ->where('parent_id', $parent?->id);
        $existing = (clone $query)
            ->where('slug', $slug)
            ->first();

        if ($existing === null && $parent === null && $aliases !== []) {
            $existing = $query->whereIn('slug', $aliases)->first();
        }

        $folderName = Str::limit($name, 250, '');

        if ($existing !== null) {
            if (! $this->dryRun && ($existing->name !== $folderName || $existing->slug !== $slug)) {
                $existing->update([
                    'name' => $folderName,
                    'slug' => $slug,
                ]);
            }

            return $existing;
        }

        $this->createdFolders++;

        if ($this->dryRun) {
            return new MediaFolder(['name' => $folderName, 'slug' => $slug, 'parent_id' => $parent?->id]);
        }

        return MediaFolder::create([
            'parent_id' => $parent?->id,
            'name' => $folderName,
            'slug' => $slug,
        ]);
    }
}
