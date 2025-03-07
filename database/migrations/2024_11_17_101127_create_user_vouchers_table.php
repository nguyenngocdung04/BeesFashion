<?php

use App\Models\User;
use App\Models\Voucher;
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
        Schema::create('user_vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->comment('Xác định người dùng nào lưu voucher này')->constrained();
            $table->foreignIdFor(Voucher::class)->comment('Xác định voucher nào được người dùng này lưu')->constrained();
            $table->boolean('is_used')->comment('Lưu trạng thái đã sử dụng voucher hay chưa, mặc định là chưa == 0!')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vouchers');
    }
};
