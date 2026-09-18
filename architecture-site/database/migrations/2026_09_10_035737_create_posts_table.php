<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->nullable()->index('posts_category_id_foreign');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('thumbnail')->nullable();
            $table->string('thumbnail_caption')->nullable();
            $table->string('thumbnail_alt')->nullable();
            $table->json('gallery')->nullable();
            $table->string('author_name')->nullable();
            $table->string('author_role')->nullable();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
            $table->unsignedBigInteger('views')->default(0);
            $table->boolean('is_featured')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
