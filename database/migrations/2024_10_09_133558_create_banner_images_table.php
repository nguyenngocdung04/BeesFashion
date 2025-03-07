<?php

use App\Models\Banner;
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
        Schema::create('banner_images', function (Blueprint $table) {//Mỗi banner có nhiều ảnh, nên bảng này lưu trữ những ảnh đó
            $table->id();
            $table->string('file_name')->comment('Tên file');
            $table->foreignIdFor(Banner::class)->comment('Xác định những ảnh này thuộc banner nào')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_images');
    }
};
