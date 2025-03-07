<?php

use App\Models\Order;
use App\Models\Product_variant;
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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->string('value_variants')->comment('Giá trị biến thể ví dụ (Xanh-XL)');
            $table->integer('original_price')->comment('Giá gốc');
            $table->integer('amount_reduced')->nullable()->comment('Giá đã được giảm');
            $table->integer('quantity')->comment('Số lượng sản phẩm');
            $table->foreignIdFor(Order::class)->comment('Xác định thuộc đơn hàng nào')->constrained();
            $table->foreignIdFor(Product_variant::class)->comment('Xác định biến thể nào')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
