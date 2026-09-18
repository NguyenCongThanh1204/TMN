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
        Schema::create('careers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_title');
            $table->string('department')->nullable();
            $table->string('location')->nullable();
            $table->string('salary_range')->nullable();
            $table->longText('description');
            $table->date('deadline')->nullable();
            $table->string('status')->default('open');
            $table->timestamps();
            $table->string('cover_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
