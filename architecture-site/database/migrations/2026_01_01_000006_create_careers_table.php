<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(){Schema::create('careers',function(Blueprint $t){$t->id();$t->string('job_title');$t->string('department')->nullable();$t->string('location')->nullable();$t->string('salary_range')->nullable();$t->longText('description');$t->date('deadline')->nullable();$t->string('status')->default('open');$t->timestamps();});} public function down(){Schema::dropIfExists('careers');}};
