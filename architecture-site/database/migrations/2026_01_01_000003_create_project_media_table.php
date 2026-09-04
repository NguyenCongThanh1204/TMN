<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(){Schema::create('project_media',function(Blueprint $t){$t->id();$t->foreignId('project_id')->constrained()->cascadeOnDelete();$t->string('path');$t->string('type')->default('image');$t->string('title')->nullable();$t->string('alt_text')->nullable();$t->unsignedInteger('sort_order')->default(0);$t->timestamps();});} public function down(){Schema::dropIfExists('project_media');}};
