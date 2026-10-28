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
        Schema::table('post_media', function (Blueprint $table): void {
            $table->unsignedBigInteger('folder_id')
                ->nullable()
                ->after('post_id');
            $table->index('folder_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_media', function (Blueprint $table): void {
            $table->dropIndex(['folder_id']);
            $table->dropColumn('folder_id');
        });
    }
};
