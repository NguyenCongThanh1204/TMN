<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaders', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('level_id')->default(1); // 1: HĐQT, 2: Ban Tổng Giám Đốc, 3: Trợ lý & GĐ Khối, 4: Khối Dự Án
            $table->string('name'); // Họ và tên lãnh đạo
            $table->string('title'); // Chức vụ (Ví dụ: Chủ tịch HĐQT, Phó Tổng Giám Đốc...)
            $table->string('image')->nullable(); // Hình ảnh đại diện
            $table->text('bio')->nullable(); // Tiểu sử / Mô tả chi tiết khi bấm popup
            $table->string('email')->nullable(); // Email liên hệ
            $table->unsignedInteger('position_order')->default(0); // Thứ tự sắp xếp
            $table->timestamps();

            // Đánh index để tối ưu tốc độ truy vấn
            $table->index(['level_id', 'position_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaders');
    }
};