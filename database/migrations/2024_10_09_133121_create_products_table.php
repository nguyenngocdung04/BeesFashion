<?php

use App\Models\Brand;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('SKU')->unique()->comment('Mã sản phẩm');
            $table->string('name')->comment('Tên sản phẩm');
            $table->integer('view')->default(0)->comment('Số lượt xem sản phẩm');
            $table->text('description')->comment('Mô tả sản phẩm');
            $table->integer('fake_sales')->nullable()->comment('Tạo đơn ảo cho sản phẩm)');
            $table->foreignIdFor(Brand::class)->nullable()->comment('Sản phẩm này thuộc thương hiệu nào')->constrained();
            $table->tinyInteger('is_active')->default(1)->comment('Trạng thái hoạt động, mặc định là 1(đã kích hoạt)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
