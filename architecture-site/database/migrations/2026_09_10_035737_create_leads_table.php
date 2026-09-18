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
        Schema::create('leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->default('quote');
            $table->string('full_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('project_type')->nullable();
            $table->string('estimated_budget')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('position')->nullable();
            $table->longText('message')->nullable();
            $table->string('status')->default('new');
            $table->timestamps();

            $table->index(['type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
