<?php

use App\Models\Product;
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
        Schema::create('product_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->comment('Tên file');
            $table->string('file_type')->comment('Loại tệp là gì(image/video)');
            $table->foreignIdFor(Product::class)->comment('Xác định file này thuộc về sản phẩm nào')->constrained();
            $table->boolean('is_default')->comment('Tệp mặc định để đại diện sản phẩm')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_files');
    }
};
