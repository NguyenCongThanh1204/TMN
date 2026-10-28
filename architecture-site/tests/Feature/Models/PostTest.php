<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PostTest extends TestCase
{
    public function test_saving_strips_leading_and_trailing_slashes_from_slug(): void
    {
        Schema::create('posts', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->timestamps();
        });

        $post = new Post(['title' => 'Bài mới', 'slug' => '/bai-moi/']);
        $post->save();

        $this->assertSame('bai-moi', $post->fresh()->slug);
    }
}
