<?php

use App\Models\Payment;
use App\Models\User;
use App\Models\User_shipping_address;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('total_cost')->comment('Tổng số tiền khi chưa áp dụng mã giảm');
            $table->integer('shipping_price')->comment('Số tiền vận chuyển');
            $table->integer('shipping_voucher')->default(0)->comment('Số tiền vận chuyện được giảm');
            $table->integer('voucher')->default(0)->comment('Số tiền được giảm từ voucher');
            $table->float('tax')->comment('Thuế');
            $table->integer('total_payment')->comment('Tổng tiền thanh toán cuối cùng');
            $table->string('full_name')->nullable()->comment('Nếu người dùng chọn địa chỉ thanh toán mặc định ở bảng user thì không thể lấy thông tin địa chỉ giao hàng qua id của bảng user_shipping_address');
            $table->string('phone_number')->nullable()->comment('Nếu người dùng chọn địa chỉ thanh toán mặc định ở bảng user thì không thể lấy thông tin địa chỉ giao hàng qua id của bảng user_shipping_address');
            $table->string('address')->nullable()->comment('Nếu người dùng chọn địa chỉ thanh toán mặc định ở bảng user thì không thể lấy thông tin địa chỉ giao hàng qua id của bảng user_shipping_address');
            $table->enum('payment_method', ['cod', 'vnpay', 'momo'])->default('cod')->comment('Thanh toán bằng hình thức nào');
            $table->foreignIdFor(User::class)->comment('Xác định người dùng nào đã đặt hàng')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
