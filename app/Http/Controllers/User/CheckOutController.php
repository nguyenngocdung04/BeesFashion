<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Product_variant;
use App\Models\Product_voucher;
use App\Models\User;
use App\Models\User_shipping_address;
use App\Models\User_voucher;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOutController extends Controller
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
    public function index(Request $request)
    {
        $is_cart = $request->input('status_cart');
        $is_cart = $is_cart == "true" ? true : false;
        $check_out_data['product_variant_data'] = [];
        $total_price = 0;
        if ($is_cart) {
            $cart_ids = $request->input('cart_ids');
            $cart_ids = explode(",", $cart_ids);

            $check_out_data = [];
            foreach ($cart_ids as $cart_id) {
                $get_cart_by_cart_id = Cart::find($cart_id);
                if ($get_cart_by_cart_id) {
                    $get_product_variant_by_variant_id = Product_variant::find($get_cart_by_cart_id->product_variant_id);
                    if ($get_product_variant_by_variant_id) {
                        $get_product_name = Product::find($get_product_variant_by_variant_id->product->id)->name;
                        $product_variant_data = [];
                        $product_variant_price = $get_product_variant_by_variant_id->sale_price != null ? $get_product_variant_by_variant_id->sale_price : $get_product_variant_by_variant_id->regular_price;
                        $product_variant_data['id'] = $get_product_variant_by_variant_id->id;
                        $product_variant_data['name'] = $get_product_name;
                        $product_variant_data['image'] = $get_product_variant_by_variant_id->image;
                        $product_variant_data['price'] = $product_variant_price;
                        $product_variant_data['quantity'] = $get_cart_by_cart_id->quantity;
                        $product_variant_data['variant_values'] = $get_product_variant_by_variant_id->name;
                        $check_out_data['product_variant_data'][] = $product_variant_data;

                        $total_price += $product_variant_price * $get_cart_by_cart_id->quantity;
                    }
                }
            }
        } else {
            $product_variant_id = $request->input('product_variant_id');
            $quantity = $request->input('quantity');
            $get_product_variant_by_variant_id = Product_variant::find($product_variant_id);
            if ($get_product_variant_by_variant_id) {
                $get_product_name = Product::find($get_product_variant_by_variant_id->product->id)->name;
                $product_variant_data = [];
                $product_variant_price = $get_product_variant_by_variant_id->sale_price != null ? $get_product_variant_by_variant_id->sale_price : $get_product_variant_by_variant_id->regular_price;
                $product_variant_data['id'] = $get_product_variant_by_variant_id->id;
                $product_variant_data['name'] = $get_product_name;
                $product_variant_data['image'] = $get_product_variant_by_variant_id->image;
                $product_variant_data['price'] = $product_variant_price;
                $product_variant_data['quantity'] = $quantity;
                $product_variant_data['variant_values'] = $get_product_variant_by_variant_id->name;
                $check_out_data['product_variant_data'][] = $product_variant_data;

                $total_price += $product_variant_price * $quantity;
            }
        }
        $check_out_data['is_from_cart'] = $is_cart;
        $check_out_data['minimum_payment_for_free_ship'] = 200000;
        $check_out_data['shipping_fee'] = 30000;
        $check_out_data['tax'] = $total_price * (0.5 / 100);
        $check_out_data['sub_total'] = $total_price;
        $check_out_data['is_cart'] = $is_cart;
        $check_out_data['free_ship'] = $check_out_data['minimum_payment_for_free_ship'] > $total_price ? false : true;

        $check_out_data['total'] = ($check_out_data['free_ship'] ? 0 : $check_out_data['shipping_fee']) + $check_out_data['tax'] + $check_out_data['sub_total'];
        if (isset($check_out_data['product_variant_data']) && count($check_out_data['product_variant_data']) > 1) {
            usort($check_out_data['product_variant_data'], function ($a, $b) {
                $valueA = $a['price'] * $a['quantity'];
                $valueB = $b['price'] * $b['quantity'];

                return $valueA <=> $valueB;
            });
        }
        // dd($check_out_data);
        return view('user.check-out', compact('check_out_data'));
    }
    public function addAddress(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|regex:/^0\d{9,10}$/',
            'address' => 'required|string|max:255',
        ], [
            'full_name.required' => 'Please enter your full name.',
            'phone_number.required' => 'Please enter your phone number.',
            'phone_number.regex' => 'The phone number must start with 0 and have 10 or 11 digits.',
            'address.required' => 'Please enter your address.'
        ]);

        // Tạo địa chỉ mới
        $address_shipping = new User_shipping_address;
        $address_shipping->full_name = $request->full_name;
        $address_shipping->phone_number = $request->phone_number;
        $address_shipping->address = $request->address;
        $address_shipping->user_id = auth()->id();
        $address_shipping->is_active = 0;
        $address_shipping->save();

        $response = [
            'success' => true,
            'message' => 'Shipping address added successfully.',
            'data' => $address_shipping
        ];
        return response()->json($response);
    }
    public function getListAddresses()
    {
        $user_id = Auth::user()->id;
        if ($user_id) {
            $data = [];
            $data_user = User::find($user_id);
            if ($data_user) {
                $data['user_id'] = $user_id;
                $data['full_name'] = $data_user->full_name ? $data_user->full_name : "Chưa được cập nhật";
                $data['phone'] = $data_user->phone ? $data_user->phone : "Chưa được cập nhật";
                $data['address'] = $data_user->address ? $data_user->address : "Chưa được cập nhật";
                $data['updated'] = $data_user->full_name || $data_user->phone || $data_user->address ? true : false;
                $data['is_default'] = true;
                $data_shipping_addresses = User_shipping_address::where('user_id', $user_id)->get();
                // dd($data_shipping_addresses);
                if ($data_shipping_addresses) {
                    foreach ($data_shipping_addresses as $shipping_address_item) {
                        $listAddresses = [];
                        $listAddresses['id'] = $shipping_address_item->id;
                        $listAddresses['full_name'] = $shipping_address_item->full_name;
                        $listAddresses['phone_number'] = $shipping_address_item->phone_number;
                        $listAddresses['address'] = $shipping_address_item->address;
                        $listAddresses['is_active'] = $shipping_address_item->is_active;
                        if ($shipping_address_item->is_active == 1) {
                            $data['is_default'] = false;
                            $listAddresses['is_default'] = true;
                        } else {
                            $listAddresses['is_default'] = false;
                        }
                        $data['list_address_others'][] = $listAddresses;
                    }
                }
                $response = [
                    'status' => 200,
                    'message' => 'Get list addresses successfully!',
                    'data' => $data
                ];
                return response()->json($response);
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'Không tìm thấy dữ liệu người dùng!',
                ];
                return response()->json($response);
            }
        }
    }
    public function editDefaultAddress(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|regex:/^0\d{9,10}$/',
            'address' => 'required|string|max:255',
        ], [
            'full_name.required' => 'Please enter your full name.',
            'phone.required' => 'Please enter your phone number.',
            'phone.regex' => 'The phone number must start with 0 and have 10 or 11 digits.',
            'address.required' => 'Please enter your address.'
        ]);
        $user_id = Auth::user()->id;
        $address = User::find($user_id);
        if ($address) {
            $address->update($request->all());
        }

        $response = [
            'success' => true,
            'message' => 'Default address updated successfully.'
        ];
        return response()->json($response);
    }
    public function editAddress(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|regex:/^0\d{9,10}$/',
            'address' => 'required|string|max:255',
        ], [
            'full_name.required' => 'Please enter your full name.',
            'phone_number.required' => 'Please enter your phone number.',
            'phone_number.regex' => 'The phone number must start with 0 and have 10 or 11 digits.',
            'address.required' => 'Please enter your address.'
        ]);
        $address = Auth::user()->user_shipping_addresses()->findOrFail($id);
        if ($address) {
            $address->update($request->all());
        }

        $response = [
            'success' => true,
            'message' => 'Updated address successfully.'
        ];
        return response()->json($response);
    }
    public function deleteAddress($id)
    {
        // Tìm địa chỉ bằng cách sử dụng where và id của địa chỉ
        $address = Auth::user()->user_shipping_addresses()->where('id', $id)->first();
        $address->delete();
        $response = [
            'success' => true,
            'message' => 'Deleted address successfully.'
        ];
        return response()->json($response);
    }

    public function setDefaultAddressOther($id)
    {
        $addressOthers = Auth::user()->user_shipping_addresses()->get();
        if ($addressOthers) {
            foreach ($addressOthers as $addressOther) {
                if ($addressOther->is_active != 0) {
                    $addressOther->is_active = 0;
                    $addressOther->save();
                }
            }
        }
        $address = Auth::user()->user_shipping_addresses()->where('id', $id)->first();
        if ($address) {
            $address->is_active = 1;
            $address->save();
        }
        $response = [
            'success' => true,
            'message' => 'Set default address successfully.'
        ];
        return response()->json($response);
    }
    public function setDefaultAddress()
    {
        $addressOthers = Auth::user()->user_shipping_addresses()->get();
        if ($addressOthers) {
            foreach ($addressOthers as $addressOther) {
                if ($addressOther->is_active != 0) {
                    $addressOther->is_active = 0;
                    $addressOther->save();
                }
            }
        }
        $response = [
            'success' => true,
            'message' => 'Set default address successfully.'
        ];
        return response()->json($response);
    }
    public function getVoucherByCode()
    {
        //Lấy mã giảm giá từ mã mà người dùng nhập vào
        $voucher_code = request()->input('voucher_code');
        //Lấy dữ liệu từ code js
        $check_out_data = request()->input('check_out_data');
        //Lấy id của user đang đăng nhập
        $user_id = Auth::user()->id;
        //Nếu mã giảm giá hợp lệ thì chạy tiếp
        if ($voucher_code) {
            //Lấy dữ liệu mã giảm giá thông qua mã mà người dùng nhập
            $voucher = Voucher::where('code', $voucher_code)->first();
            //Nếu nó tồn tại thì xử lý tiếp
            if ($voucher) {
                //Nếu trạng thái mã này vẫn còn hoạt động thì kiểm tra tiếp
                if ($voucher->is_active == 1) {
                    //Nếu số lượng vẫn còn thì kiểm tra tiếp
                    if ($voucher->quantity > 0) {
                        //Nếu ngày sử dụng đang có hiệu lực và chưa hết hạn thì kiểm tra tiếp
                        if ($voucher->start_date < Carbon::now('Asia/Ho_Chi_Minh') && $voucher->end_date > Carbon::now('Asia/Ho_Chi_Minh')) {
                            if ($voucher->minimum_order_value) {
                                if ($voucher->minimum_order_value <= $check_out_data['sub_total']) {
                                    //Nếu voucher này là công khai (ai cũng có thể sử dụng) thì kiểm tra tiếp
                                    if ($voucher->is_public == 1) {
                                        //Kiểm tra xem voucher này có thể sử dụng cho tất cả sản phẩm hay chỉ một số sản phẩm
                                        $check_this_voucher_is_use_for_certain_product = Product_voucher::where('voucher_id', $voucher->id)->get();
                                        //Nếu voucher này chỉ được sử dụng cho một số sản phẩm thì chạy tiếp
                                        if (!$check_this_voucher_is_use_for_certain_product->isEmpty()) {
                                            //Nếu dữ liệu từ js hợp lệ thì chạy tiếp
                                            if ($check_out_data) {
                                                //Tạo mảng để lưu trữ các id của sản phẩm và các biến thể cho mỗi id sản phẩm tương ứng
                                                $group_product_variants = [];
                                                //Lặp qua các sản phẩm biến thể từ dữ liệu bên js
                                                foreach ($check_out_data['product_variants'] as $product_variant) {
                                                    //Kiểm tra xem biến thể này có hợp lệ không thì chạy tiếp
                                                    $check_product_variant = Product_variant::where('id', $product_variant['id'])
                                                        ->where('is_active', 1)
                                                        ->where('stock', '>=', $product_variant['quantity'])
                                                        ->first();
                                                    //Nếu biến thể này hợp lệ thì chạy tiếp
                                                    if ($check_product_variant) {
                                                        //Tạo mảng để lưu trữ từng thông tin sản phẩm và các biến thể của nó
                                                        $exists_in_group = false;
                                                        foreach ($group_product_variants as &$variant_item) {
                                                            if ($variant_item['product_id'] == $check_product_variant->product_id) {
                                                                // Nếu tồn tại, thêm id biến thể vào danh sách
                                                                $variant_item['variant_ids'][] = $check_product_variant->id;
                                                                $exists_in_group = true;
                                                                break; // Dừng vòng lặp vì đã tìm thấy
                                                            }
                                                        }

                                                        // Nếu sản phẩm chưa tồn tại trong danh sách, thêm mới
                                                        if (!$exists_in_group) {
                                                            $group_product_variants[] = [
                                                                'product_id' => $check_product_variant->product_id,
                                                                'variant_ids' => [$check_product_variant->id],
                                                            ];
                                                        }
                                                        //Nếu có sản phẩm nào không hợp lệ thì dừng luôn, gửi lỗi và thông báo sang js để hiển thị cho người dùng
                                                    } else {
                                                        return $this->returnJson(false, 'Có một số sản phẩm không hợp lệ, vui lòng thử lại!');
                                                    }
                                                }
                                                //Tạo mảng mới để lưu trữ những sản phẩm có thể sử dụng được voucher này
                                                $valid_products = [];
                                                //Lặp qua từng sản phẩm có thể sử dụng voucher này
                                                foreach ($check_this_voucher_is_use_for_certain_product as $product_voucher) {
                                                    foreach ($group_product_variants as $product_variant) {
                                                        //Nếu sản phẩm từ js là sản phẩm có thể sử dụng được voucher này thì thêm dữ liệu vào mảng valid_products
                                                        if ($product_variant['product_id'] == $product_voucher->product_id) {
                                                            //Tạo biến để kiểm tra tránh thêm trùng lặp vào mảng valid_products
                                                            $check_valid_product = true;
                                                            //Nếu mảng valid_products có dữ liệu thì kiểm tra tiếp
                                                            if (!empty($valid_products)) {
                                                                //Lặp qua từng id của sản phẩm trong valid_products
                                                                foreach ($valid_products as $valid_product) {
                                                                    //Nếu id của sản phẩm này đã tồn tại trong valid_products thì gán check_valid_product thành false
                                                                    if ($valid_product == $product_variant['product_id']) {
                                                                        $check_valid_product = false;
                                                                    }
                                                                }
                                                                //check_valid_product là true có nghĩa là id của sản phẩm này chưa tồn tại trong mảng valid_products thì thêm nó vào mảng valid_products
                                                                if ($check_valid_product) {
                                                                    $valid_products[] = $product_variant['product_id'];
                                                                }
                                                                //Nếu valid_products chưa có dữ liệu thì thêm luôn id sp vào
                                                            } else {
                                                                $valid_products[] = $product_variant['product_id'];
                                                            }
                                                        }
                                                    }
                                                }
                                                //Nếu mảng valid_products có dữ liệu thì chạy tiếp
                                                if (!empty($valid_products)) {
                                                    //Tạo mảng lưu trữ id của các biến thể trong các sản phẩm đã được lọc là hợp lệ trong mảng valid_products
                                                    $total_valid_variants = [];
                                                    //Lặp qua từng id sp hợp lệ trong mảng valid_products
                                                    foreach ($valid_products as $valid_product) {
                                                        //Lặp qua các sản phẩm với mỗi item là id sp và các biến thể của nó
                                                        foreach ($group_product_variants as $product_variant) {
                                                            //Nếu khớp id sp thì thêm các biến thể của nó vào mảng total_valid_variants
                                                            if ($valid_product == $product_variant['product_id']) {
                                                                foreach ($product_variant['variant_ids'] as $product_variant_id) {
                                                                    $total_valid_variants[] = $product_variant_id;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    //Nếu mảng total_valid_variants có dữ liệu thì chạy tiếp
                                                    if (!empty($total_valid_variants)) {
                                                        //Tạo mảng lưu trữ dữ liệu để trả về json
                                                        $return_data_json = [];
                                                        $return_data_json['is_private_product'] = false;
                                                        $return_data_json['voucher_id'] = $voucher->id;
                                                        $return_data_json['user_id'] = $user_id;
                                                        $average = $voucher->amount / count($total_valid_variants);
                                                        if ($voucher->type == "fixed") {
                                                            $variants_contain_id_and_price = [];
                                                            $total_price_of_variant = 0;
                                                            $amount = $voucher->amount;
                                                            foreach ($check_out_data['product_variants'] as $product_variant) {
                                                                foreach ($total_valid_variants as $valid_variant) {
                                                                    $check = false;
                                                                    // Nếu biến thể chưa tồn tại trong mảng, thêm mới
                                                                    if (!isset($variants_contain_id_and_price[$valid_variant])) {
                                                                        $variants_contain_id_and_price[$valid_variant] = $product_variant['total_price'];
                                                                        $check = true;
                                                                    }
                                                                    if ($check) {
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                            // Tính tổng giá trị của các biến thể
                                                            $total_price_of_variant = array_sum($variants_contain_id_and_price);
                                                            if ($total_price_of_variant < $voucher->amount) {
                                                                $average = $total_price_of_variant / count($total_valid_variants);
                                                                $amount = $total_price_of_variant;
                                                            }
                                                            foreach ($total_valid_variants as $valid_variant) {
                                                                $variant_item = [];
                                                                $variant_item['variant_id'] = $valid_variant;
                                                                $variant_item['reduce_price'] = $average;
                                                                $return_data_json['variant_data'][] = $variant_item;
                                                            }
                                                            $return_data_json['amount'] = $amount;
                                                            $return_data_json['type'] = "fixed";
                                                            $return_data_json['free_order'] = $voucher->amount > $total_price_of_variant ? true : false;
                                                        } else if ($voucher->type == "percent") {
                                                            if ($voucher->amount > 0 && $voucher->amount <= 100) {
                                                                $variants_contain_id_and_price = [];
                                                                $total_price_of_variant = 0;
                                                                foreach ($check_out_data['product_variants'] as $product_variant) {
                                                                    foreach ($total_valid_variants as $valid_variant) {
                                                                        $check = false;
                                                                        // Nếu biến thể chưa tồn tại trong mảng, thêm mới
                                                                        if (!isset($variants_contain_id_and_price[$valid_variant])) {
                                                                            $variants_contain_id_and_price[$valid_variant] = $product_variant['total_price'];
                                                                            $check = true;
                                                                        }
                                                                        if ($check) {
                                                                            break;
                                                                        }
                                                                    }
                                                                }
                                                                // Tính tổng giá trị của các biến thể
                                                                $total_price_of_variant = array_sum($variants_contain_id_and_price);
                                                                $price_from_percent = $total_price_of_variant * ($voucher->amount / 100);
                                                                $average = $price_from_percent / count($total_valid_variants);
                                                                $excess_reduction_amount = 0;
                                                                if ($voucher->maximum_reduction && $price_from_percent > $voucher->maximum_reduction) {
                                                                    $excess_reduction_amount = $price_from_percent - $voucher->maximum_reduction;
                                                                    $average = $voucher->maximum_reduction / count($total_valid_variants);
                                                                }
                                                                foreach ($check_out_data['product_variants'] as $product_variant) {
                                                                    foreach ($total_valid_variants as $valid_variant) {
                                                                        if ($product_variant['id'] == $valid_variant) {
                                                                            $variant_item = [];
                                                                            $variant_item['variant_id'] = $valid_variant;
                                                                            $variant_item['reduce_price'] = $average;
                                                                            $return_data_json['variant_data'][] = $variant_item;
                                                                        }
                                                                    }
                                                                }
                                                                $return_data_json['amount'] = $price_from_percent - $excess_reduction_amount;
                                                                $return_data_json['type'] = "percent";

                                                                $return_data_json['free_order'] = false;
                                                            } else {
                                                                return $this->returnJson(false, 'Voucher này không hợp lệ!');
                                                            }
                                                        } else if ($voucher->type == "free_ship") {
                                                            $return_data_json['amount'] = $voucher->amount;
                                                            $return_data_json['type'] = "free_ship";
                                                            $return_data_json['free_ship'] = $voucher->amount > 30000 ? true : false;
                                                            $return_data_json['free_order'] = false;
                                                        }
                                                        return $this->returnJson(true, "Áp dụng voucher thành công!", $return_data_json);
                                                    }
                                                }
                                            } else {
                                                return $this->returnJson(false, 'Không lấy được dữ liệu sản phẩm biến thể, vui lòng thử lại!');
                                            }
                                        } else {
                                            if ($check_out_data) {
                                                $total_valid_variants = [];
                                                foreach ($check_out_data['product_variants'] as $product_variant) {
                                                    $check_product_variant = Product_variant::where('id', $product_variant['id'])
                                                        ->where('is_active', 1)
                                                        ->where('stock', '>', $product_variant['quantity'])
                                                        ->first();
                                                    if ($check_product_variant) {
                                                        $total_valid_variants[] = $check_product_variant->id;
                                                    } else {
                                                        return $this->returnJson(false, 'Có một số sản phẩm không hợp lệ, vui lòng thử lại!');
                                                    }
                                                }
                                                if (!empty($total_valid_variants)) {
                                                    $return_data_json = [];
                                                    $return_data_json['is_private_product'] = false;
                                                    $return_data_json['voucher_id'] = $voucher->id;
                                                    $return_data_json['user_id'] = $user_id;
                                                    $average = $voucher->amount / count($total_valid_variants);
                                                    if ($voucher->type == "fixed") {
                                                        $variants_contain_id_and_price = [];
                                                        $total_price_of_variant = 0;
                                                        $amount = $voucher->amount;
                                                        foreach ($check_out_data['product_variants'] as $product_variant) {
                                                            foreach ($total_valid_variants as $valid_variant) {
                                                                $check = false;
                                                                // Nếu biến thể chưa tồn tại trong mảng, thêm mới
                                                                if (!isset($variants_contain_id_and_price[$valid_variant])) {
                                                                    $variants_contain_id_and_price[$valid_variant] = $product_variant['total_price'];
                                                                    $check = true;
                                                                }
                                                                if ($check) {
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                        // Tính tổng giá trị của các biến thể
                                                        $total_price_of_variant = array_sum($variants_contain_id_and_price);
                                                        if ($total_price_of_variant < $voucher->amount) {
                                                            $average = $total_price_of_variant / count($total_valid_variants);
                                                            $amount = $total_price_of_variant;
                                                        }
                                                        foreach ($total_valid_variants as $valid_variant) {
                                                            $variant_item = [];
                                                            $variant_item['variant_id'] = $valid_variant;
                                                            $variant_item['reduce_price'] = $average;
                                                            $return_data_json['variant_data'][] = $variant_item;
                                                        }
                                                        $return_data_json['amount'] = $amount;
                                                        $return_data_json['type'] = "fixed";
                                                        $return_data_json['free_order'] = $voucher->amount > $total_price_of_variant ? true : false;
                                                    } else if ($voucher->type == "percent") {
                                                        if ($voucher->amount > 0 && $voucher->amount <= 100) {

                                                            $variants_contain_id_and_price = [];
                                                            $total_price_of_variant = 0;
                                                            foreach ($check_out_data['product_variants'] as $product_variant) {
                                                                foreach ($total_valid_variants as $valid_variant) {
                                                                    $check = false;
                                                                    // Nếu biến thể chưa tồn tại trong mảng, thêm mới
                                                                    if (!isset($variants_contain_id_and_price[$valid_variant])) {
                                                                        $variants_contain_id_and_price[$valid_variant] = $product_variant['total_price'];
                                                                        $check = true;
                                                                    }
                                                                    if ($check) {
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                            // Tính tổng giá trị của các biến thể
                                                            $total_price_of_variant = array_sum($variants_contain_id_and_price);
                                                            $price_from_percent = $total_price_of_variant * ($voucher->amount / 100);
                                                            $average = $price_from_percent / count($total_valid_variants);
                                                            $excess_reduction_amount = 0;
                                                            if ($voucher->maximum_reduction && $price_from_percent > $voucher->maximum_reduction) {
                                                                $excess_reduction_amount = $price_from_percent - $voucher->maximum_reduction;
                                                                $average = $voucher->maximum_reduction / count($total_valid_variants);
                                                            }
                                                            foreach ($check_out_data['product_variants'] as $product_variant) {
                                                                foreach ($total_valid_variants as $valid_variant) {
                                                                    if ($product_variant['id'] == $valid_variant) {
                                                                        $variant_item = [];
                                                                        $variant_item['variant_id'] = $valid_variant;
                                                                        $variant_item['reduce_price'] = $average;
                                                                        $return_data_json['variant_data'][] = $variant_item;
                                                                    }
                                                                }
                                                            }
                                                            $return_data_json['amount'] = $price_from_percent - $excess_reduction_amount;
                                                            $return_data_json['type'] = "percent";
                                                            $return_data_json['free_order'] = false;
                                                        } else {
                                                            return $this->returnJson(false, 'Voucher này không hợp lệ!');
                                                        }
                                                    } else if ($voucher->type == "free_ship") {
                                                        $return_data_json['amount'] = $voucher->amount;
                                                        $return_data_json['type'] = "free_ship";
                                                        $return_data_json['free_ship'] = $voucher->amount > 30000 ? true : false;
                                                        $return_data_json['free_order'] = false;
                                                    }
                                                    return $this->returnJson(true, "Áp dụng voucher thành công!", $return_data_json);
                                                }
                                            } else {
                                                return $this->returnJson(false, 'Không lấy được dữ liệu sản phẩm biến thể, vui lòng thử lại!');
                                            }
                                        }
                                    } else {
                                        $check_user_can_use_this_voucher = User_voucher::where('user_id', $user_id)->where('voucher_id', $voucher->id)->first();
                                        if ($check_user_can_use_this_voucher) {
                                            if ($check_user_can_use_this_voucher->is_used == 0) {
                                                //Kiểm tra xem voucher này có thể sử dụng cho tất cả sản phẩm hay chỉ một số sản phẩm
                                                $check_this_voucher_is_use_for_certain_product = Product_voucher::where('voucher_id', $voucher->id)->get();
                                                //Nếu voucher này chỉ được sử dụng cho một số sản phẩm thì chạy tiếp
                                                if (!$check_this_voucher_is_use_for_certain_product->isEmpty()) {
                                                    //Nếu dữ liệu từ js hợp lệ thì chạy tiếp
                                                    if ($check_out_data) {
                                                        //Tạo mảng để lưu trữ các id của sản phẩm và các biến thể cho mỗi id sản phẩm tương ứng
                                                        $group_product_variants = [];
                                                        //Lặp qua các sản phẩm biến thể từ dữ liệu bên js
                                                        foreach ($check_out_data['product_variants'] as $product_variant) {
                                                            //Kiểm tra xem biến thể này có hợp lệ không thì chạy tiếp
                                                            $check_product_variant = Product_variant::where('id', $product_variant['id'])
                                                                ->where('is_active', 1)
                                                                ->where('stock', '>=', $product_variant['quantity'])
                                                                ->first();
                                                            //Nếu biến thể này hợp lệ thì chạy tiếp
                                                            if ($check_product_variant) {
                                                                //Tạo mảng để lưu trữ từng thông tin sản phẩm và các biến thể của nó
                                                                $exists_in_group = false;
                                                                foreach ($group_product_variants as &$variant_item) {
                                                                    if ($variant_item['product_id'] == $check_product_variant->product_id) {
                                                                        // Nếu tồn tại, thêm id biến thể vào danh sách
                                                                        $variant_item['variant_ids'][] = $check_product_variant->id;
                                                                        $exists_in_group = true;
                                                                        break; // Dừng vòng lặp vì đã tìm thấy
                                                                    }
                                                                }

                                                                // Nếu sản phẩm chưa tồn tại trong danh sách, thêm mới
                                                                if (!$exists_in_group) {
                                                                    $group_product_variants[] = [
                                                                        'product_id' => $check_product_variant->product_id,
                                                                        'variant_ids' => [$check_product_variant->id],
                                                                    ];
                                                                }
                                                                //Nếu có sản phẩm nào không hợp lệ thì dừng luôn, gửi lỗi và thông báo sang js để hiển thị cho người dùng
                                                            } else {
                                                                return $this->returnJson(false, 'Có một số sản phẩm không hợp lệ, vui lòng thử lại!');
                                                            }
                                                        }
                                                        //Tạo mảng mới để lưu trữ những sản phẩm có thể sử dụng được voucher này
                                                        $valid_products = [];
                                                        //Lặp qua từng sản phẩm có thể sử dụng voucher này
                                                        // return $this->returnJson(true, "Đã lấy được dữ liệu", $group_product_variants);
                                                        foreach ($check_this_voucher_is_use_for_certain_product as $product_voucher) {
                                                            foreach ($group_product_variants as $product_variant) {
                                                                //Nếu sản phẩm từ js là sản phẩm có thể sử dụng được voucher này thì thêm dữ liệu vào mảng valid_products
                                                                if ($product_variant['product_id'] == $product_voucher->product_id) {
                                                                    //Tạo biến để kiểm tra tránh thêm trùng lặp vào mảng valid_products
                                                                    $check_valid_product = true;
                                                                    //Nếu mảng valid_products có dữ liệu thì kiểm tra tiếp
                                                                    if (!empty($valid_products)) {
                                                                        //Lặp qua từng id của sản phẩm trong valid_products
                                                                        foreach ($valid_products as $valid_product) {
                                                                            //Nếu id của sản phẩm này đã tồn tại trong valid_products thì gán check_valid_product thành false
                                                                            if ($valid_product == $product_variant['product_id']) {
                                                                                $check_valid_product = false;
                                                                            }
                                                                        }
                                                                        //check_valid_product là true có nghĩa là id của sản phẩm này chưa tồn tại trong mảng valid_products thì thêm nó vào mảng valid_products
                                                                        if ($check_valid_product) {
                                                                            $valid_products[] = $product_variant['product_id'];
                                                                        }
                                                                        //Nếu valid_products chưa có dữ liệu thì thêm luôn id sp vào
                                                                    } else {
                                                                        $valid_products[] = $product_variant['product_id'];
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        //Nếu mảng valid_products có dữ liệu thì chạy tiếp
                                                        if (!empty($valid_products)) {
                                                            //Tạo mảng lưu trữ id của các biến thể trong các sản phẩm đã được lọc là hợp lệ trong mảng valid_products
                                                            $total_valid_variants = [];
                                                            //Lặp qua từng id sp hợp lệ trong mảng valid_products
                                                            foreach ($valid_products as $valid_product) {
                                                                //Lặp qua các sản phẩm với mỗi item là id sp và các biến thể của nó
                                                                foreach ($group_product_variants as $product_variant) {
                                                                    //Nếu khớp id sp thì thêm các biến thể của nó vào mảng total_valid_variants
                                                                    if ($valid_product == $product_variant['product_id']) {
                                                                        foreach ($product_variant['variant_ids'] as $product_variant_id) {
                                                                            $total_valid_variants[] = $product_variant_id;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            //Nếu mảng total_valid_variants có dữ liệu thì chạy tiếp
                                                            if (!empty($total_valid_variants)) {
                                                                //Tạo mảng lưu trữ dữ liệu để trả về json
                                                                $return_data_json = [];
                                                                $return_data_json['is_private_product'] = true;
                                                                $return_data_json['voucher_id'] = $voucher->id;
                                                                $return_data_json['user_id'] = $user_id;
                                                                $average = $voucher->amount / count($total_valid_variants);
                                                                if ($voucher->type == "fixed") {
                                                                    $variants_contain_id_and_price = [];
                                                                    $total_price_of_variant = 0;
                                                                    $amount = $voucher->amount;
                                                                    foreach ($check_out_data['product_variants'] as $product_variant) {
                                                                        foreach ($total_valid_variants as $valid_variant) {
                                                                            $check = false;
                                                                            // Nếu biến thể chưa tồn tại trong mảng, thêm mới
                                                                            if (!isset($variants_contain_id_and_price[$valid_variant])) {
                                                                                $variants_contain_id_and_price[$valid_variant] = $product_variant['total_price'];
                                                                                $check = true;
                                                                            }
                                                                            if ($check) {
                                                                                break;
                                                                            }
                                                                        }
                                                                    }
                                                                    // Tính tổng giá trị của các biến thể
                                                                    $total_price_of_variant = array_sum($variants_contain_id_and_price);
                                                                    if ($total_price_of_variant < $voucher->amount) {
                                                                        $average = $total_price_of_variant / count($total_valid_variants);
                                                                        $amount = $total_price_of_variant;
                                                                    }
                                                                    foreach ($total_valid_variants as $valid_variant) {
                                                                        $variant_item = [];
                                                                        $variant_item['variant_id'] = $valid_variant;
                                                                        $variant_item['reduce_price'] = $average;
                                                                        $return_data_json['variant_data'][] = $variant_item;
                                                                    }
                                                                    $return_data_json['amount'] = $amount;
                                                                    $return_data_json['type'] = "fixed";
                                                                    $return_data_json['free_order'] = $voucher->amount > $total_price_of_variant ? true : false;
                                                                } else if ($voucher->type == "percent") {
                                                                    if ($voucher->amount > 0 && $voucher->amount <= 100) {

                                                                        $variants_contain_id_and_price = [];
                                                                        $total_price_of_variant = 0;
                                                                        foreach ($check_out_data['product_variants'] as $product_variant) {
                                                                            foreach ($total_valid_variants as $valid_variant) {
                                                                                $check = false;
                                                                                // Nếu biến thể chưa tồn tại trong mảng, thêm mới
                                                                                if (!isset($variants_contain_id_and_price[$valid_variant])) {
                                                                                    $variants_contain_id_and_price[$valid_variant] = $product_variant['total_price'];
                                                                                    $check = true;
                                                                                }
                                                                                if ($check) {
                                                                                    break;
                                                                                }
                                                                            }
                                                                        }
                                                                        // Tính tổng giá trị của các biến thể
                                                                        $total_price_of_variant = array_sum($variants_contain_id_and_price);
                                                                        $price_from_percent = $total_price_of_variant * ($voucher->amount / 100);
                                                                        $average = $price_from_percent / count($total_valid_variants);
                                                                        $excess_reduction_amount = 0;
                                                                        if ($voucher->maximum_reduction && $price_from_percent > $voucher->maximum_reduction) {
                                                                            $excess_reduction_amount = $price_from_percent - $voucher->maximum_reduction;
                                                                            $average = $voucher->maximum_reduction / count($total_valid_variants);
                                                                        }
                                                                        foreach ($check_out_data['product_variants'] as $product_variant) {
                                                                            foreach ($total_valid_variants as $valid_variant) {
                                                                                if ($product_variant['id'] == $valid_variant) {
                                                                                    $variant_item = [];
                                                                                    $variant_item['variant_id'] = $valid_variant;
                                                                                    $variant_item['reduce_price'] = $average;
                                                                                    $return_data_json['variant_data'][] = $variant_item;
                                                                                }
                                                                            }
                                                                        }
                                                                        $return_data_json['amount'] = $price_from_percent - $excess_reduction_amount;
                                                                        $return_data_json['type'] = "percent";
                                                                        $return_data_json['free_order'] = false;
                                                                    } else {
                                                                        return $this->returnJson(false, 'Voucher này không hợp lệ!');
                                                                    }
                                                                } else if ($voucher->type == "free_ship") {
                                                                    $return_data_json['amount'] = $voucher->amount;
                                                                    $return_data_json['type'] = "free_ship";
                                                                    $return_data_json['free_ship'] = $voucher->amount > 30000 ? true : false;
                                                                    $return_data_json['free_order'] = false;
                                                                }
                                                                return $this->returnJson(true, "Áp dụng voucher thành công!", $return_data_json);
                                                            }
                                                        }
                                                    } else {
                                                        return $this->returnJson(false, 'Không lấy được dữ liệu sản phẩm biến thể, vui lòng thử lại!');
                                                    }
                                                } else {
                                                    if ($check_out_data) {
                                                        $total_valid_variants = [];
                                                        foreach ($check_out_data['product_variants'] as $product_variant) {
                                                            $check_product_variant = Product_variant::where('id', $product_variant['id'])
                                                                ->where('is_active', 1)
                                                                ->where('stock', '>', $product_variant['quantity'])
                                                                ->first();
                                                            if ($check_product_variant) {
                                                                $total_valid_variants[] = $check_product_variant->id;
                                                            } else {
                                                                return $this->returnJson(false, 'Có một số sản phẩm không hợp lệ, vui lòng thử lại!');
                                                            }
                                                        }
                                                        if (!empty($total_valid_variants)) {
                                                            $return_data_json = [];
                                                            $return_data_json['is_private_product'] = true;
                                                            $return_data_json['voucher_id'] = $voucher->id;
                                                            $return_data_json['user_id'] = $user_id;
                                                            $average = $voucher->amount / count($total_valid_variants);
                                                            if ($voucher->type == "fixed") {
                                                                $variants_contain_id_and_price = [];
                                                                $total_price_of_variant = 0;
                                                                $amount = $voucher->amount;
                                                                foreach ($check_out_data['product_variants'] as $product_variant) {
                                                                    foreach ($total_valid_variants as $valid_variant) {
                                                                        $check = false;
                                                                        // Nếu biến thể chưa tồn tại trong mảng, thêm mới
                                                                        if (!isset($variants_contain_id_and_price[$valid_variant])) {
                                                                            $variants_contain_id_and_price[$valid_variant] = $product_variant['total_price'];
                                                                            $check = true;
                                                                        }
                                                                        if ($check) {
                                                                            break;
                                                                        }
                                                                    }
                                                                }
                                                                // Tính tổng giá trị của các biến thể
                                                                $total_price_of_variant = array_sum($variants_contain_id_and_price);
                                                                if ($total_price_of_variant < $voucher->amount) {
                                                                    $average = $total_price_of_variant / count($total_valid_variants);
                                                                    $amount = $total_price_of_variant;
                                                                }
                                                                foreach ($total_valid_variants as $valid_variant) {
                                                                    $variant_item = [];
                                                                    $variant_item['variant_id'] = $valid_variant;
                                                                    $variant_item['reduce_price'] = $average;
                                                                    $return_data_json['variant_data'][] = $variant_item;
                                                                }
                                                                $return_data_json['amount'] = $amount;
                                                                $return_data_json['type'] = "fixed";
                                                                $return_data_json['free_order'] = $voucher->amount > $total_price_of_variant ? true : false;
                                                            } else if ($voucher->type == "percent") {
                                                                if ($voucher->amount > 0 && $voucher->amount <= 100) {

                                                                    $variants_contain_id_and_price = [];
                                                                    $total_price_of_variant = 0;
                                                                    foreach ($check_out_data['product_variants'] as $product_variant) {
                                                                        foreach ($total_valid_variants as $valid_variant) {
                                                                            $check = false;
                                                                            // Nếu biến thể chưa tồn tại trong mảng, thêm mới
                                                                            if (!isset($variants_contain_id_and_price[$valid_variant])) {
                                                                                $variants_contain_id_and_price[$valid_variant] = $product_variant['total_price'];
                                                                                $check = true;
                                                                            }
                                                                            if ($check) {
                                                                                break;
                                                                            }
                                                                        }
                                                                    }
                                                                    // Tính tổng giá trị của các biến thể
                                                                    $total_price_of_variant = array_sum($variants_contain_id_and_price);
                                                                    $price_from_percent = $total_price_of_variant * ($voucher->amount / 100);
                                                                    $average = $price_from_percent / count($total_valid_variants);
                                                                    $excess_reduction_amount = 0;
                                                                    if ($voucher->maximum_reduction && $price_from_percent > $voucher->maximum_reduction) {
                                                                        $excess_reduction_amount = $price_from_percent - $voucher->maximum_reduction;
                                                                        $average = $voucher->maximum_reduction / count($total_valid_variants);
                                                                    }
                                                                    foreach ($check_out_data['product_variants'] as $product_variant) {
                                                                        foreach ($total_valid_variants as $valid_variant) {
                                                                            if ($product_variant['id'] == $valid_variant) {
                                                                                $variant_item = [];
                                                                                $variant_item['variant_id'] = $valid_variant;
                                                                                $variant_item['reduce_price'] = $average;
                                                                                $return_data_json['variant_data'][] = $variant_item;
                                                                            }
                                                                        }
                                                                    }
                                                                    $return_data_json['amount'] = $price_from_percent - $excess_reduction_amount;
                                                                    $return_data_json['type'] = "percent";
                                                                    $return_data_json['free_order'] = false;
                                                                } else {
                                                                    return $this->returnJson(false, 'Voucher này không hợp lệ!');
                                                                }
                                                            } else if ($voucher->type == "free_ship") {
                                                                $return_data_json['amount'] = $voucher->amount;
                                                                $return_data_json['type'] = "free_ship";
                                                                $return_data_json['free_ship'] = $voucher->amount > 30000 ? true : false;
                                                                $return_data_json['free_order'] = false;
                                                            }
                                                            return $this->returnJson(true, "Áp dụng voucher thành công!", $return_data_json);
                                                        }
                                                    } else {
                                                        return $this->returnJson(false, 'Không lấy được dữ liệu sản phẩm biến thể, vui lòng thử lại!');
                                                    }
                                                }
                                            } else {
                                                return $this->returnJson(false, 'Bạn đã sử dụng voucher này rồi!');
                                            }
                                        } else {
                                            return $this->returnJson(false, 'Bạn không có quyền sử dụng voucher này!');
                                        }
                                    }
                                } else {
                                    return $this->returnJson(false, 'Giá trị đơn hàng tối thiểu ' . number_format($voucher->minimum_order_value, 0, '.', ',') . ' đ mới có thể áp dụng được voucher này!');
                                }
                            }
                        } else if ($voucher->start_date < Carbon::now('Asia/Ho_Chi_Minh') && $voucher->end_date < Carbon::now('Asia/Ho_Chi_Minh')) {
                            return $this->returnJson(false, 'Voucher này đã hết hiệu lực!');
                        } else if ($voucher->start_date > Carbon::now('Asia/Ho_Chi_Minh')) {
                            return $this->returnJson(false, 'Voucher không tồn tại!');
                        }
                    } else {
                        return $this->returnJson(false, 'Voucher này đã hết lượt sử dụng!');
                    }
                } else {
                    return $this->returnJson(false, 'Voucher này đã hết hiệu lực!');
                }
            } else {
                return $this->returnJson(false, 'Không tìm thấy voucher, vui lòng thử lại!');
            }
        }
    }
}
