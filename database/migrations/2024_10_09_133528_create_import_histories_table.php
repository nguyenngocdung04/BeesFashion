<?php

use App\Models\Import_history;
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
        Schema::create('import_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity')->comment('Số lượng nhập vào');
            $table->bigInteger('import_price')->comment('Giá nhập thực tế của sản phẩm mà bạn đã mua từ nhà cung cấp. Đây là giá gốc của sản phẩm.');
            $table->foreignIdFor(model: Product_variant::class)->comment('Xác định lịch sử nhập này thuộc biến thể nào')->constrained();
            $table->foreignIdFor(model: User::class)->nullable()->comment('Người nhập hàng')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_histories');
    }
};
