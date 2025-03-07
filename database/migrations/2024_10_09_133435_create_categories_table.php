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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tên danh mục');
            $table->string('image')->nullable()->comment('Ảnh danh mục');
            $table->text('description')->nullable()->comment('Mô tả danh mục');
            $table->boolean('fixed')->default(1)->comment('Phân loại danh mục'); //1 danh mục thường, 0 là danh mục bán chạy
            $table->tinyInteger('is_active')->default(1)->comment('Trạng thái hoạt động danh mục, mặc định là 1(đã kích hoạt)');
            $table->foreignId('parent_category_id')->nullable()->comment('Xác định danh mục cha')->constrained('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
