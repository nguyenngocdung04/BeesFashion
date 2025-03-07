<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Status;
use App\Models\Status_order;
use App\Models\User_voucher;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private function returnJson($status, $message, $data = null)
    {
        $response = [
            'success' => $status,
            'message' => $message,
            'data' => $data
        ];
        return response()->json($response);
    }
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $data_from_js = request()->input('data_to_store_order');

        $user_id = null;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        } else {
            return $this->returnJson(false, 'Không tìm thấy id người dùng cần đặt hàng!');
        }
        $is_cart = $data_from_js['is_cart'];

        $full_name = null;
        $phone_number = null;
        $address = null;

        $payment_method = null;
        $shipping_price = null;
        $shipping_voucher = null;
        $tax = null;
        $total_cost = null;
        $total_payment = null;
        $voucher = null;
        $voucher_id = null;

        if ($data_from_js['address_id'] == null) {
            $full_name = Auth::user()->full_name;
            $phone_number = Auth::user()->phone;
            $address = Auth::user()->address;
        } else {
            if ($data_from_js['address_id'] != null) {
                $get_address_by_id = Auth::user()->user_shipping_addresses->find($data_from_js['address_id']);
                if ($get_address_by_id) {
                    $full_name = $get_address_by_id->full_name;
                    $phone_number = $get_address_by_id->phone_number;
                    $address = $get_address_by_id->address;
                } else {
                    return $this->returnJson(false, 'Không tìm thấy địa chỉ đã chọn!');
                }
            } else {
                $full_name = Auth::user()->full_name;
                $phone_number = Auth::user()->phone;
                $address = Auth::user()->address;
            }
        }

        $shipping_price = $data_from_js['shipping_price'];
        $shipping_voucher = $data_from_js['shipping_voucher'];
        $tax = $data_from_js['tax'];
        $total_cost = $data_from_js['total_cost'];
        $total_payment = $data_from_js['total_payment'];
        $voucher = $data_from_js['voucher'];
        $voucher_id = $data_from_js['voucher_id'];

        if ($data_from_js['payment_method'] != "") {
            $payment_method = $total_payment != 0 ? $data_from_js['payment_method'] : "cod";
        } else {
            return $this->returnJson(false, 'Không xác định được phương thức thanh toán, vui lòng thử lại!');
        }

        $product_variants = $data_from_js['product_variants'];

        if (count($product_variants) == 0) {
            return $this->returnJson(false, 'Không tìm thấy sản phẩm cần thanh toán!');
        }

        if ($total_cost != null && $shipping_price != null && $tax != null && $total_payment != null) {
            $new_order = Order::create([
                'total_cost' => $total_cost,
                'shipping_price' => $shipping_price,
                'shipping_voucher' => $shipping_voucher == null ? 0 : $shipping_voucher,
                'voucher' => $voucher == null ? 0 : $voucher,
                'tax' => $tax,
                'total_payment' => $total_payment,
                'full_name' => $full_name,
                'phone_number' => $phone_number,
                'address' => $address,
                'payment_method' => $payment_method,
                'user_id' => $user_id
            ]);

            $get_status_id_1 = Status::where('name', 'Processing')->first();
            $get_status_id_2 = Status::where('name', 'Pending')->first();
            if ($get_status_id_1 && $get_status_id_2) {
                Status_order::create([
                    'status_id' => $payment_method == "cod" ? $get_status_id_2->id : $get_status_id_1->id,
                    'order_id' => $new_order->id
                ]);
            } else {
                if (!$get_status_id_1) {
                    $get_status_id_1 = Status::create([
                        'name' => 'Processing',
                    ]);
                }
                if (!$get_status_id_2) {
                    $get_status_id_2 = Status::create([
                        'name' => 'Pending',
                    ]);
                }
                Status_order::create([
                    'status_id' => $payment_method == "cod" ? $get_status_id_2->id : $get_status_id_1->id,
                    'order_id' => $new_order->id
                ]);
            }

            foreach ($product_variants as $product_variant) {
                Order_detail::create([
                    'value_variants' => $product_variant['value_variants'],
                    'original_price' => $product_variant['price'],
                    'amount_reduced' => $product_variant['reduced_price'] != null ? $product_variant['reduced_price'] : 0,
                    'quantity' => $product_variant['quantity'],
                    'order_id' => $new_order->id,
                    'product_variant_id' => $product_variant['id']
                ]);
                if ($is_cart == true || $is_cart == 1) {
                    Cart::where('product_variant_id', $product_variant['id'])
                        ->where('user_id', $user_id)
                        ->delete();
                }
            }

            if ($voucher_id != null) {
                $check_voucher = Voucher::find($voucher_id);
                if ($check_voucher) {
                    $check_voucher->quantity -= 1;
                    $check_voucher->save();
                    if ($check_voucher->is_public == 0) {
                        $user_voucher = User_voucher::where('voucher_id', $voucher_id)
                            ->where('user_id', $user_id)
                            ->first();
                        if ($user_voucher) {
                            $user_voucher->is_used = 1;
                            $user_voucher->save();
                        }
                    }
                }
            }
            $data = [
                'payment_method' => $data_from_js['payment_method'],
                'order_id' =>  $new_order->id,
                'amount' => $data_from_js['total_payment']
            ];
            return $this->returnJson(true, 'Đặt hàng thành công!', $data);
        } else {
            $response = [
                'status' => false,
                'message' => 'Có một số thông tin không hợp lệ, vui lòng thử lại!'
            ];
            return response()->json($response);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order_id = $id;
        if ($order_id) {
            $get_order = Order::with(
                [
                    'order_details.product_variant.product',
                    'order_details.product_variant'
                ]
            )->where('user_id', Auth::user()->id)->find($order_id);
            if ($get_order) {
                $get_order_status = Status_order::with('status')->where('order_id', $order_id)->latest()->first();
                // dd($get_order_status);
                if ($get_order->payment_method != "cod" && $get_order_status->status->name == "Processing") {
                    return view('user.order-failed', compact('get_order', 'get_order_status'))->with('statusError', 'Đặt hàng không thành công!');
                }
                return view('user.order-success', compact('get_order', 'get_order_status'))->with('statusSuccess', 'Đặt hàng thành công!');
            } else {
                return redirect()->route('checkout')->with('statusError', 'Có lỗi xảy ra!');
            }
        } else {
            return redirect()->route('checkout')->with('statusError', 'Có lỗi xảy ra!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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