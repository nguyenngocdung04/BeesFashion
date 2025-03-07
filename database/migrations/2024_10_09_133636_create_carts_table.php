<?php

use App\Models\Product_variant;
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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity')->comment('Số lượng sản phẩm trong giỏ hàng');
            $table->foreignIdFor(Product_variant::class)->comment('Xác định biến thể được thêm vào giỏ hàng')->constrained();
            $table->foreignIdFor(User::class)->comment('Xác định người dùng nào đã thêm sản phẩm vào giỏ hàng')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
