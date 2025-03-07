<?php

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
        Schema::create('user_shipping_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->comment('Tên đầy đủ của người dùng ví dụ: Phạm Văn A');
            $table->string('phone_number')->nullable()->comment('Số điện thoại');
            $table->text('address')->nullable()->comment('Địa chỉ');
            $table->foreignIdFor(User::class)->comment('Xác định thông tin này thuộc người dùng nào')->constrained()->onDelete('cascade');
            $table->tinyInteger('is_active')->default(1)->comment('Trạng thái kích hoạt thông tin này, mặc định là 1(đã kích hoạt)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_shipping_addresses');
    }
};
