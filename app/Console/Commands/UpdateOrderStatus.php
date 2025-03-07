<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Status;
use App\Models\Status_order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-order-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description =  'Cập nhật trạng thái đơn hàng từ Vận chuyển sang Hoàn thành sau 15 ngày';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7);

        // Lấy trạng thái "Shipping"
        $shipping_status = Status::where('name', "Shipping")->first();
        if (!$shipping_status) {
            $this->error("Không tìm thấy trạng thái 'Shipping'.");
            return;
        }

        // Lấy trạng thái "Completed" hoặc tạo mới nếu không có
        $completed_status = Status::firstOrCreate(['name' => "Completed"]);

        // Truy vấn các đơn hàng có trạng thái cuối cùng là "Shipping" và đã hơn 7 ngày
        $status_orders = Status_order::select('order_id', DB::raw('MAX(created_at) as last_status'))
            ->where('status_id', $shipping_status->id) // Chỉ lấy bản ghi có trạng thái "Shipping"
            ->where('created_at', '<', $sevenDaysAgo) // Đã quá 7 ngày
            ->groupBy('order_id')
            ->get();

        // Cập nhật trạng thái đơn hàng
        foreach ($status_orders as $status_order) {
            Status_order::create([
                'status_id' => $completed_status->id,
                'order_id' => $status_order->order_id
            ]);

            $this->info("Cập nhật đơn hàng #{$status_order->order_id} sang trạng thái Hoàn thành.");
        }

        if ($status_orders->isEmpty()) {
            $this->info("Không có đơn hàng nào cần cập nhật.");
        }
    }
}
