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
            $table->string('alt_text')->nullable()->after('caption');
            $table->string('keywords')->nullable()->after('alt_text');
            $table->text('description')->nullable()->after('keywords');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_media', function (Blueprint $table): void {
            $table->dropColumn(['alt_text', 'keywords', 'description']);
        });
    }
};
