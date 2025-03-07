<?php

use App\Models\Order;
use App\Models\Status;
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
        Schema::create('status_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Status::class)->comment('Xác định trạng thái nào')->constrained();
            $table->foreignIdFor(Order::class)->comment('Xác định đơn hàng nào có trạng thái này')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_orders');
    }
};
