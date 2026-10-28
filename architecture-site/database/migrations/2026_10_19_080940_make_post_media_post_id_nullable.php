<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! in_array(DB::getDriverName(), ['sqlite', 'turso'], true)) {
            Schema::table('post_media', function (Blueprint $table): void {
                $table->foreignId('post_id')->nullable()->change();
            });

            return;
        }

        $this->rebuildPostMediaTable(nullablePostId: true);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::table('post_media')->whereNull('post_id')->exists()) {
            throw new RuntimeException('Cannot make post_media.post_id required while orphaned media exists.');
        }

        if (! in_array(DB::getDriverName(), ['sqlite', 'turso'], true)) {
            Schema::table('post_media', function (Blueprint $table): void {
                $table->foreignId('post_id')->nullable(false)->change();
            });

            return;
        }

        $this->rebuildPostMediaTable(nullablePostId: false);
    }

    private function rebuildPostMediaTable(bool $nullablePostId): void
    {
        $temporaryTable = 'post_media_migration';

        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists($temporaryTable);

        Schema::create($temporaryTable, function (Blueprint $table) use ($nullablePostId): void {
            $table->id();
            $table->foreignId('post_id')
                ->nullable($nullablePostId)
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedBigInteger('folder_id')->nullable();
            $table->string('file_path');
            $table->string('caption')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('folder_id');
        });

        DB::statement(
            'INSERT INTO "post_media_migration" ("id", "post_id", "folder_id", "file_path", "caption", "sort_order", "created_at", "updated_at") '
            .'SELECT "id", "post_id", "folder_id", "file_path", "caption", "sort_order", "created_at", "updated_at" FROM "post_media"'
        );

        Schema::drop('post_media');
        Schema::rename($temporaryTable, 'post_media');
        Schema::enableForeignKeyConstraints();
    }
};
