<?php

namespace Tests\Feature\Services;

use App\Models\MediaFolder;
use App\Services\MediaCatalog;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MediaCatalogTest extends TestCase
{
    public function test_category_folders_read_images_from_their_owning_tables(): void
    {
        $this->createMediaCatalogSchema();
        DB::table('posts')->insert([
            'id' => 1,
            'title' => 'Article',
            'slug' => 'article',
            'thumbnail' => 'posts/article/thumbnail',
            'gallery' => json_encode(['posts/article/gallery']),
        ]);
        DB::table('post_media')->insert([
            'post_id' => 1,
            'file_path' => 'posts/article/detail',
        ]);
        DB::table('projects')->insert([
            'id' => 1,
            'title' => 'Project',
            'slug' => 'project',
            'cover_image' => 'projects/project/cover',
        ]);
        DB::table('project_media')->insert([
            'project_id' => 1,
            'file_path' => 'projects/project/detail',
            'sort_order' => 0,
        ]);
        DB::table('leaders')->insert(['name' => 'Leader', 'image' => 'leaders/portrait']);
        DB::table('partners')->insert(['name' => 'Partner', 'logo' => 'partners/logo']);
        DB::table('careers')->insert(['job_title' => 'Role', 'cover_image' => 'careers/cover']);

        $expectedPaths = [
            MediaCatalog::ROOT_POSTS => [
                'posts/article/thumbnail',
                'posts/article/gallery',
                'posts/article/detail',
            ],
            MediaCatalog::ROOT_PROJECTS => [
                'projects/project/cover',
                'projects/project/detail',
            ],
            MediaCatalog::ROOT_LEADERS => ['leaders/portrait'],
            MediaCatalog::ROOT_PARTNERS => ['partners/logo'],
            MediaCatalog::ROOT_CAREERS => ['careers/cover'],
        ];

        foreach ($expectedPaths as $rootSlug => $paths) {
            DB::table('media_folders')->insert([
                'name' => $rootSlug,
                'slug' => $rootSlug,
            ]);
        }

        $folders = MediaFolder::query()->get();
        $catalog = app(MediaCatalog::class);

        foreach ($expectedPaths as $rootSlug => $paths) {
            $root = $folders->firstWhere('slug', $rootSlug);

            $this->assertSame(
                $paths,
                $catalog->items($root, $folders)->pluck('file_path')->all(),
                "Images in {$rootSlug} must come from its owning table."
            );
        }
    }

    public function test_record_folders_filter_images_and_normalize_upload_directories(): void
    {
        $this->createMediaCatalogSchema();
        DB::table('posts')->insert([
            ['id' => 1, 'title' => 'Article', 'slug' => '/article-slug/', 'thumbnail' => 'posts/article/thumbnail'],
            ['id' => 2, 'title' => 'Other article', 'slug' => 'other-article', 'thumbnail' => 'posts/other/thumbnail'],
        ]);
        DB::table('post_media')->insert([
            ['post_id' => 1, 'file_path' => 'posts/article/detail'],
            ['post_id' => 2, 'file_path' => 'posts/other/detail'],
        ]);
        DB::table('projects')->insert([
            ['id' => 1, 'title' => 'Project', 'slug' => '/project-slug/', 'cover_image' => 'projects/project/cover'],
            ['id' => 2, 'title' => 'Other project', 'slug' => 'other-project', 'cover_image' => 'projects/other/cover'],
        ]);
        DB::table('project_media')->insert([
            ['project_id' => 1, 'file_path' => 'projects/project/detail', 'sort_order' => 0],
            ['project_id' => 2, 'file_path' => 'projects/other/detail', 'sort_order' => 0],
        ]);
        DB::table('media_folders')->insert([
            ['id' => 1, 'name' => 'Bài viết', 'slug' => MediaCatalog::ROOT_POSTS, 'parent_id' => null],
            ['id' => 2, 'name' => 'Article', 'slug' => '/article-slug/', 'parent_id' => 1],
            ['id' => 3, 'name' => 'Dự án', 'slug' => MediaCatalog::ROOT_PROJECTS, 'parent_id' => null],
            ['id' => 4, 'name' => 'Project', 'slug' => '/project-slug/', 'parent_id' => 3],
        ]);

        $folders = MediaFolder::query()->get();
        $catalog = app(MediaCatalog::class);
        $postFolder = $folders->firstWhere('id', 2);
        $projectFolder = $folders->firstWhere('id', 4);

        $this->assertSame(
            ['posts/article/thumbnail', 'posts/article/detail'],
            $catalog->items($postFolder, $folders)->pluck('file_path')->all()
        );
        $this->assertSame(
            ['projects/project/cover', 'projects/project/detail'],
            $catalog->items($projectFolder, $folders)->pluck('file_path')->all()
        );
        $this->assertSame('posts/article-slug/media', $catalog->uploadTarget($postFolder, $folders)['directory']);
        $this->assertSame('projects/project-slug/media', $catalog->uploadTarget($projectFolder, $folders)['directory']);
    }

    public function test_sync_command_creates_roots_for_all_image_categories(): void
    {
        $this->createMediaCatalogSchema();
        DB::table('media_folders')->insert([
            'name' => 'Tin tức',
            'slug' => 'news',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Artisan::call('media:sync-library');

        $this->assertSame(
            [
                MediaCatalog::ROOT_POSTS,
                MediaCatalog::ROOT_PARTNERS,
                MediaCatalog::ROOT_PROJECTS,
                MediaCatalog::ROOT_LEADERS,
                MediaCatalog::ROOT_CAREERS,
            ],
            MediaFolder::query()->orderBy('slug')->pluck('slug')->all()
        );
    }

    private function createMediaCatalogSchema(): void
    {
        Schema::create('media_folders', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
        Schema::create('posts', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('thumbnail')->nullable();
            $table->string('thumbnail_caption')->nullable();
            $table->json('gallery')->nullable();
        });
        Schema::create('post_media', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('post_id')->nullable();
            $table->unsignedBigInteger('folder_id')->nullable();
            $table->string('file_path');
            $table->string('caption')->nullable();
            $table->string('alt_text')->nullable();
        });
        Schema::create('projects', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('cover_image')->nullable();
        });
        Schema::create('project_media', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('file_path');
            $table->string('caption')->nullable();
            $table->integer('sort_order')->default(0);
        });
        Schema::create('leaders', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
        });
        Schema::create('partners', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
        });
        Schema::create('careers', function (Blueprint $table): void {
            $table->id();
            $table->string('job_title');
            $table->string('cover_image')->nullable();
        });
    }
}
