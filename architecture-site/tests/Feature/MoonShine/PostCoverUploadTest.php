<?php

namespace Tests\Feature\MoonShine;

use App\Models\Post;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use MoonShine\Laravel\Models\MoonshineUser;
use Tests\TestCase;

class PostCoverUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_uploaded_cover_is_saved_as_relative_path(): void
    {
        $this->storePost(['thumbnail' => UploadedFile::fake()->image('cover.jpg')]);

        $post = Post::query()->firstOrFail();
        $files = Storage::disk('cloudinary')->allFiles();

        $this->assertCount(1, $files);
        $this->assertSame(str_replace('\\', '/', $files[0]), $post->thumbnail);
        $this->assertStringStartsWith('posts/bai-moi/thumbnail/', $post->thumbnail);
        $this->assertStringNotContainsString('//', $post->thumbnail);
    }

    public function test_library_choice_sets_thumbnail(): void
    {
        $this->storePost(['thumbnail_library' => 'posts/bai-moi/media/anh-01']);

        $this->assertSame('posts/bai-moi/media/anh-01', Post::query()->firstOrFail()->thumbnail);
    }

    /**
     * @param  array<string, mixed>  $extra
     */
    private function storePost(array $extra): void
    {
        $this->withoutMiddleware([
            PreventRequestForgery::class,
            ValidateCsrfToken::class,
            VerifyCsrfToken::class,
        ]);
        Storage::fake('cloudinary');

        DB::table('post_categories')->insert(['id' => 1, 'name' => 'Tin', 'slug' => 'tin', 'created_at' => now(), 'updated_at' => now()]);
        $user = MoonshineUser::query()->create([
            'moonshine_user_role_id' => 1,
            'email' => 'a@b.c',
            'name' => 'A',
            'password' => bcrypt('secret123'),
        ]);

        $this->actingAs($user, 'moonshine')
            ->withHeaders(['Accept' => 'application/json'])
            ->post(route('moonshine.crud.store', ['resourceUri' => 'post-resource']), [
                'title' => 'Bai moi',
                'slug' => 'bai-moi',
                'category_id' => 1,
                'content' => '<p>noi dung</p>',
            ] + $extra)
            ->assertSuccessful();
    }
}
