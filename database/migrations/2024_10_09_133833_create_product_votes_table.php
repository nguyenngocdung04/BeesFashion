<?php

use App\Models\Order_detail;
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
        Schema::create('product_votes', function (Blueprint $table) {
            $table->id();
            $table->string('content')->nullable()->comment('Nội dung đánh giá');
            $table->float('star')->comment('Số sao');
            $table->boolean('edit')->default(false)
                ->comment('Trạng thái chỉnh sửa đánh giá, mặc định là chưa, khi nào người dùng sửa đánh giá thì chuyển thành true , nếu là true thì không cho sửa nữa');
            $table->foreignIdFor(Product_variant::class)->comment('Xác định biến thể sản phẩm nào đang được đánh giá')->constrained();
            $table->foreignIdFor(Order_detail::class)->comment('Xác định đơn hàng chi tiết nào đang được đánh giá')->constrained();
            $table->foreignIdFor(User::class)->comment('Xác định người dùng nào đang đánh giá')->constrained();
            $table->tinyInteger('is_active')->default(1)->comment('1: hiện đánh giá, 0: ẩn đánh giá');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_votes');
    }
};
