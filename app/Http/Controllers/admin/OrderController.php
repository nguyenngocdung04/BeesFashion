<?php

namespace App\Http\Controllers\Admin;

use Log;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use App\Http\Controllers\Controller;
use Picqer\Barcode\BarcodeGeneratorHTML;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //tất cả đơn hàng
        $allOrders = Order::with(['status_orders' => function ($query) {
            $query->orderBy('created_at', 'desc')->take(1);  // Lấy trạng thái mới nhất
        }])->orderBy('created_at', 'desc')->get();
        $allCount = $allOrders->count();
        //đơn hàng chờ xác nhận
        $pendingOrders = Order::whereHas('status_orders', function ($query) {
            // Chỉ lấy các đơn hàng có trạng thái "Pending" (status_id = 2)
            $query->where('status_id', 2);
        })->whereDoesntHave('status_orders', function ($query) {
            // Loại bỏ các đơn hàng đã có trạng thái "Cancelled" (status_id = 5) hoặc "Shipping" (status_id = 3)
            $query->whereIn('status_id', [5, 3]);
        })->orderBy('created_at', 'desc')->get();
        $pendingCount = $pendingOrders->count();

        //đơn hàng chờ xử lý
        $processingOrders = Order::with('status_orders')
            ->whereHas('status_orders', function ($query) {
                $query->where('status_id', 1); // Lọc đơn hàng có trạng thái "Processing"
            })
            ->whereDoesntHave('status_orders', function ($query) {
                $query->whereIn('status_id', [5, 2]); // Loại bỏ nếu có trạng thái "Cancelled" hoặc "Pending"
            })
            ->whereDoesntHave('status_orders', function ($query) {
                $query->where('status_id', 1)->whereIn('status_id', [2, 5]); // Loại bỏ trạng thái lặp xung đột
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $processingCount = $processingOrders->count();
        //Đơn hàng đã giao 
        $shippingOrders = Order::whereHas('status_orders', function ($query) {
            $query->where('status_id', 3);  // Trạng thái 'Shipping'
        })
            ->whereDoesntHave('status_orders', function ($query) {
                $query->whereIn('status_id', [4, 6, 5]);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        $shippingCount = $shippingOrders->count();

        //Đơn hàng đã hoàn thành
        $completedOrders = Order::whereHas('status_orders', function ($query) {
            $query->where('status_id', 4);
        })->orderBy('created_at', 'desc')
            ->get();
        $completedCount = $completedOrders->count();


        //Đơn hàng đã hủy
        $cancelledOrders = Order::whereHas('status_orders', function ($query) {
            $query->where('status_id', 5);
        })->orderBy('created_at', 'desc')
            ->get();
        $cancelledCount = $cancelledOrders->count();


        $fail_delivery = Order::whereHas('status_orders', function ($query) {
            $query->where('status_id', 6);
        })->orderBy('created_at', 'desc')
            ->get();
        $fail_deliveryCount = $fail_delivery->count();

        return view('admin.orders.index', compact(
            'allOrders',
            'allCount',
            'pendingOrders',
            'pendingCount',
            'processingCount',
            'processingOrders',
            'shippingOrders',
            'shippingCount',
            'completedCount',
            'completedOrders',
            'cancelledOrders',
            'cancelledCount',
            'fail_delivery',
            'fail_deliveryCount'
        ));
    }

    public function printOrder($id)
    {
        try {
            // Tìm đơn hàng và load các quan hệ liên quan
            $order = Order::with('order_details.product_variant.product')->findOrFail($id);
    
            // Khởi tạo generator và tạo mã vạch cho SKU
            $generator = new BarcodeGeneratorHTML();
            $barcode = $generator->getBarcode($order->id, $generator::TYPE_CODE_128);
    
            // Tạo file PDF từ view và truyền dữ liệu
            $pdf = PDF::loadView('admin.orders.print', [
                'order' => $order,
                'barcode' => $barcode, // Truyền mã vạch trực tiếp
            ]);
    
            // Xuất file PDF dưới dạng stream
            return $pdf->stream('order_' . $id . '.pdf');
        } catch (\Exception $e) {
            // Log lỗi để theo dõi và trả về phản hồi
            return response()->json(['error' => 'Không thể tạo hóa đơn. Vui lòng thử lại.'], 500);
        }
    }
    
    //TAB 
    public function onActive(Request $request, string $id)
    {
        $order = Order::with('order_details.product_variant')->findOrFail($id);
        if ($order) {
            $shippingStatus = $order->status_orders()->where('status_id', 4)->first();

            if (!$shippingStatus) {
                $order->status_orders()->create(['status_id' => 4]);

                return redirect()->route('admin.orders.index')->with('statusSuccess', 'Đơn hàng đã được giao thành công');
            }

            return redirect()->route('admin.orders.index')->with('statusWarning', 'Đơn hàng này đang trong trạng thái hoàn thành.');
        }

    }

    // TAB Chờ xác nhận
    public function onSuccess(Request $request, string $id)
    {
        $order = Order::with('order_details.product_variant')->findOrFail($id);
        if ($order) {

            $existingCancelledStatus = $order->status_orders()->where('status_id', 5)->first();

            // Thêm bản ghi trạng thái "Shipping" (status_id = 3)
            if (!$existingCancelledStatus) {
                $order->status_orders()->create(['status_id' => 3]);
            }

            return redirect()->route('admin.orders.index')->with('statusSuccess', 'Đơn hàng đã được gửi đi');
        }

        return redirect()->route('admin.orders.index')->with('statusError', 'Đơn hàng đã bị hủy');
    }
    // TAB Chờ xác nhận
    public function cancelOrder(Request $request, string $id)
    {
        $order = Order::with('order_details.product_variant')->findOrFail($id);
    
        if ($order) {
            // Kiểm tra xem đơn hàng đã có trạng thái Cancelled (status_id = 5) chưa
            $existingCancelledStatus = $order->status_orders()->where('status_id', 5)->first();
    
            // Nếu đã có trạng thái Cancelled, hiển thị thông báo "Đơn hàng này đang trong trạng thái hủy"
            if ($existingCancelledStatus) {
                return redirect()->route('admin.orders.index')->with('statusError', 'Đơn hàng này đang trong trạng thái hủy');
            }
    
            // Nếu chưa có trạng thái Cancelled, tạo bản ghi mới
            $order->status_orders()->create(['status_id' => 5]);
    
            // Hiển thị thông báo "Đơn hàng đã được hủy thành công"
            return redirect()->route('admin.orders.index')->with('statusSuccess', 'Đơn hàng đã được hủy thành công');
        }
    
        // Nếu không tìm thấy đơn hàng
        return redirect()->route('admin.orders.index')->with('statusError', 'Không tìm thấy đơn hàng');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $getInfo = Order::with('order_details.product_variant')
            ->findOrFail($id);

        // Lấy bản ghi trạng thái thay đổi gần đây nhất của đơn hàng
        $latestStatus = $getInfo->status_orders()->latest()->first();
        // Lấy tất cả trạng thái của đơn hàng và sắp xếp theo thời gian tạo
        $statusOrders = $getInfo->status_orders()->orderBy('created_at', 'asc')->get();


        // Trả về view và truyền dữ liệu
        return view('admin.orders.info', compact('getInfo', 'latestStatus', 'statusOrders'));
    }


    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $orderIds = explode(',', $request->input('order_ids'));
    
        if ($action == 'success') {
            foreach ($orderIds as $orderId) {
                $order = Order::find($orderId);
                if ($order) {
                    // Xử lý xác nhận đơn hàng
                    $order->status_orders()->create(['status_id' => 3]);
                }
            }
            return redirect()->route('admin.orders.index')->with('statusSuccess', 'Đơn hàng đã được xác nhận.');
        }
    
        return redirect()->route('admin.orders.index')->with('statusError', 'Hành động không hợp lệ.');
    }
    
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
