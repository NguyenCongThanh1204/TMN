<?php

namespace Tests\Feature\Http\Controllers;

use App\Services\CloudinaryService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MoonShineMediaLibraryControllerTest extends TestCase
{
    public function test_store_folder_accepts_a_string_parent_id_from_the_form(): void
    {
        Schema::dropIfExists('media_folders');
        Schema::create('media_folders', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
        $parentId = DB::table('media_folders')->insertGetId([
            'parent_id' => null,
            'name' => 'Parent',
            'slug' => 'parent',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->withoutMiddleware()
            ->post(route('moonshine.media-library.folders.store'), [
                'parent_id' => (string) $parentId,
                'name' => 'Child',
            ])
            ->assertRedirect()
            ->assertSessionHas('status', 'Đã tạo thư mục.');

        $this->assertDatabaseHas('media_folders', [
            'parent_id' => $parentId,
            'name' => 'Child',
            'slug' => 'child',
        ]);
    }

    public function test_upload_rejects_category_root_without_sending_image_to_cloudinary(): void
    {
        Schema::dropIfExists('media_folders');
        Schema::create('media_folders', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
        $folderId = DB::table('media_folders')->insertGetId([
            'parent_id' => null,
            'name' => 'Bài viết',
            'slug' => 'bai-viet',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $cloudinary = $this->mock(CloudinaryService::class);
        $cloudinary->shouldNotReceive('upload');

        $this->withoutMiddleware()
            ->post(route('moonshine.media-library.upload'), [
                'folder_id' => $folderId,
                'files' => [UploadedFile::fake()->image('cover.jpg')],
            ])
            ->assertRedirect()
            ->assertSessionHas('error', 'Hãy chọn thư mục của một bài viết cụ thể để ảnh được lưu đúng dữ liệu.');
    }
}
