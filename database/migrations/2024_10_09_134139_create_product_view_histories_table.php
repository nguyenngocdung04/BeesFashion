<?php

use App\Models\Product;
use App\Models\User;
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
        Schema::create('product_view_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('click')->comment('Số lượt click vào xem sản phẩm của người dùng');
            $table->foreignIdFor(User::class)->comment('Xác định người dùng nào click')->constrained();
            $table->foreignIdFor(Product::class)->comment('Xác định sản phẩm nào được người dùng click')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_view_histories');
    }
};
