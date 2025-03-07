<?php

use App\Models\Order;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            //vnpay && momo
            $table->foreignIdFor(Order::class)->comment('Xác định đơn hàng nào!')->constrained();
            $table->foreignIdFor(User::class)->comment('Xác định người dùng nào!')->constrained();
            $table->decimal('amount', 15, 2)->comment('Số tiền thanh toán (VND)');
            $table->enum('payment_method', ['vnpay', 'momo'])->comment('Phương thức thanh toán');
            $table->string('note')->comment('Nội dung thanh toán!')->nullable();

            $table->string('response_code', 10)->comment('Mã phản hồi!')->nullable();
            $table->string('bank_code', 20)->comment('Mã ngân hàng')->nullable();
            $table->string('transaction_code', 50)->comment('Mã giao dịch')->nullable();
            $table->string('pay_type')->comment('Loại thanh toán (vd: qr_code, app)')->nullable();

            //momo
            $table->string('partner_code')->comment('Mã đối tác của momo')->nullable();
            $table->string('request_id')->comment('Request ID của giao dịch từ MoMo')->nullable();

            $table->date('pay_date')->comment('Thời gian thanh toán');

            $table->enum('status', ['pending', 'success', 'failed'])->default('pending')->comment('Trạng thái thanh toán');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
