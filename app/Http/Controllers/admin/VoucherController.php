<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listVouchers = Voucher::orderBy('created_at', 'desc')->get();
        return view('admin.vouchers.index', compact('listVouchers'));
    }

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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|regex:/^[a-zA-Z0-9]+$/|unique:vouchers,code',
            'amount' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value >= $request->minimum_order_value) {
                        $fail('Giá trị giảm phải nhỏ hơn giá tối thiểu đơn hàng.');
                    }
                    if ($request->type === 'percent' && $value >= 100) {
                        $fail('Giá trị giảm phải nhỏ hơn 100 nếu loại voucher là phần trăm.');
                    }
                },
            ],
            'maximum_reduction' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value > $request->minimum_order_value) {
                        $fail('Giá tiền giảm tối đa không được lớn hơn giá tối thiểu đơn hàng.');
                    }
                },
            ],
            'image' => 'required|image',
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'minimum_order_value' => 'required|numeric|min:0',
        ], [
            'name.required' => 'Tên voucher là bắt buộc.',
            'code.required' => 'Mã voucher là bắt buộc.',
            'code.regex' => 'Mã voucher phải viết liền, không chứa khoảng trắng.',
            'code.unique' => 'Mã voucher đã tồn tại.',
            'amount.required' => 'Giá trị giảm là bắt buộc.',
            'amount.numeric' => 'Giá trị giảm phải là một số.',
            'amount.min' => 'Giá trị giảm phải lớn hơn hoặc bằng 0.',
            'maximum_reduction.required' => 'Giá tiền giảm tối đa là bắt buộc.',
            'maximum_reduction.numeric' => 'Giá tiền giảm tối đa phải là một số.',
            'maximum_reduction.min' => 'Giá tiền giảm tối đa phải lớn hơn hoặc bằng 0.',
            'image.required' => 'Không được để trống ảnh.',
            'image.image' => 'Tệp tải lên phải là một hình ảnh.',
            'quantity.required' => 'Số lượng là bắt buộc.',
            'quantity.integer' => 'Số lượng phải là một số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            'minimum_order_value.required' => 'Giá trị tối thiểu đơn hàng là bắt buộc.',
            'minimum_order_value.numeric' => 'Giá trị tối thiểu đơn hàng phải là một số.',
            'minimum_order_value.min' => 'Giá trị tối thiểu đơn hàng phải lớn hơn hoặc bằng 0.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu phải là một ngày hợp lệ.',
            'start_date.before_or_equal' => 'Ngày bắt đầu phải trước hoặc bằng ngày hết hạn.',
            'end_date.required' => 'Ngày hết hạn là bắt buộc.',
            'end_date.date' => 'Ngày hết hạn phải là một ngày hợp lệ.',
            'end_date.after_or_equal' => 'Ngày hết hạn phải sau hoặc bằng ngày bắt đầu.',
        ]);
        if (Voucher::where('code', $request->code)->exists()) {
            return back()->withInput()->withErrors(['code' => 'Mã voucher này đã tồn tại.']);
        }

        $params = $request->except('_token');

        if ($image = $request->file('image')) {
            $imageName = $image->hashName();
            $image->move(public_path('uploads/vouchers/images'), $imageName);
            $params['image'] = $imageName;
        } else {
            $params['image'] = null;
        }

        $params['is_active'] = $request->has('is_active') ? 1 : 0;
        $params['is_public'] = $request->has('is_public') ? 1 : 0;
        Voucher::create($params);

        return back()->with('statusSuccess', 'Thêm voucher thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Lấy voucher dựa trên ID được truyền vào
        $getVoucher = Voucher::where('id', $id)->first();

        // Lấy danh sách sản phẩm liên kết với voucher hoặc mảng rỗng nếu không có voucher
        $showProductVoucher = $getVoucher ? $getVoucher->products : [];

        // Lấy tất cả sản phẩm đang hoạt động
        $allProducts = Product::where('is_active', 1)->get();

        // Lấy danh sách ID của các sản phẩm liên kết với voucher
        $showProductVoucherIds = $showProductVoucher->pluck('id')->toArray();
        return view('admin.vouchers.detail', compact('allProducts', 'getVoucher', 'showProductVoucher', 'showProductVoucherIds'));
    }
    public function addProductVoucher(Request $request)
    {
        // Lấy ID của voucher từ request
        $voucherId = $request->input('id');

        // Lấy voucher cụ thể
        $getVoucher = Voucher::find($voucherId);

        if (!$getVoucher || !$getVoucher->is_active) {
            return back()->with('statusError', 'Voucher không tồn tại hoặc không hoạt động.');
        }

        // Kiểm tra nếu có sản phẩm được chọn
        if ($request->has('product_ids')) {
            // Lấy danh sách ID sản phẩm được chọn
            $productIds = $request->input('product_ids');

            // Gắn sản phẩm vào voucher, bỏ qua các sản phẩm đã tồn tại
            $getVoucher->products()->syncWithoutDetaching($productIds);

            return back()->with('statusSuccess', 'Sản phẩm đã được thêm vào voucher.');
        }

        return back()->with('statusError', 'Không có sản phẩm nào được chọn.');
    }

    public function remove($productId, $voucherId)
    {
        // Tìm sản phẩm
        $product = Product::find($productId);

        if ($product) {
            $voucher = $product->vouchers()->where('voucher_id', $voucherId)->first();

            if ($voucher) {
                $product->vouchers()->detach($voucherId);

                return back()->with('statusSuccess', 'Sản phẩm đã được gỡ khỏi voucher hiện tại.');
            }

            return back()->with('statusError', 'Sản phẩm không thuộc voucher này.');
        }

        return back()->with('statusError', 'Không tìm thấy sản phẩm.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vouchers = Voucher::query()->findOrFail($id);
        return view('admin.vouchers.edit', compact('vouchers'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $voucher = Voucher::findOrFail($id);

        // Sử dụng validate giống hàm store
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'regex:/^[a-zA-Z0-9]+$/',
                // Kiểm tra duy nhất ngoại trừ ID hiện tại
                'unique:vouchers,code,' . $voucher->id,
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value >= $request->minimum_order_value) {
                        $fail('Giá trị giảm phải nhỏ hơn giá tối thiểu đơn hàng.');
                    }
                    if ($request->type === 'percent' && $value >= 100) {
                        $fail('Giá trị giảm phải nhỏ hơn 100 nếu loại voucher là phần trăm.');
                    }
                },
            ],
            'maximum_reduction' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value > $request->minimum_order_value) {
                        $fail('Giá tiền giảm tối đa không được lớn hơn giá tối thiểu đơn hàng.');
                    }
                },
            ],
            'image' => 'nullable|image',
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'minimum_order_value' => 'required|numeric|min:0',
        ], [
            'name.required' => 'Tên voucher là bắt buộc.',
            'code.required' => 'Mã voucher là bắt buộc.',
            'code.regex' => 'Mã voucher phải viết liền, không chứa khoảng trắng.',
            'code.unique' => 'Mã voucher đã tồn tại.',
            'amount.required' => 'Giá trị giảm là bắt buộc.',
            'amount.numeric' => 'Giá trị giảm phải là một số.',
            'amount.min' => 'Giá trị giảm phải lớn hơn hoặc bằng 0.',
            'maximum_reduction.required' => 'Giá tiền giảm tối đa là bắt buộc.',
            'maximum_reduction.numeric' => 'Giá tiền giảm tối đa phải là một số.',
            'maximum_reduction.min' => 'Giá tiền giảm tối đa phải lớn hơn hoặc bằng 0.',
            'image.image' => 'Tệp tải lên phải là một hình ảnh.',
            'quantity.required' => 'Số lượng là bắt buộc.',
            'quantity.integer' => 'Số lượng phải là một số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            'minimum_order_value.required' => 'Giá trị tối thiểu đơn hàng là bắt buộc.',
            'minimum_order_value.numeric' => 'Giá trị tối thiểu đơn hàng phải là một số.',
            'minimum_order_value.min' => 'Giá trị tối thiểu đơn hàng phải lớn hơn hoặc bằng 0.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu phải là một ngày hợp lệ.',
            'start_date.before_or_equal' => 'Ngày bắt đầu phải trước hoặc bằng ngày hết hạn.',
            'end_date.required' => 'Ngày hết hạn là bắt buộc.',
            'end_date.date' => 'Ngày hết hạn phải là một ngày hợp lệ.',
            'end_date.after_or_equal' => 'Ngày hết hạn phải sau hoặc bằng ngày bắt đầu.',
        ]);

        // Cập nhật dữ liệu
        $params = $request->except('_token', '_method');

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($voucher->image && file_exists(public_path('uploads/vouchers/images/' . $voucher->image))) {
                unlink(public_path('uploads/vouchers/images/' . $voucher->image));
            }

            $image = $request->file('image');
            $imageName = $image->hashName();
            $image->move(public_path('uploads/vouchers/images'), $imageName);

            $params['image'] = $imageName;
        } else {
            $params['image'] = $voucher->image;
        }

        $params['is_active'] = $request->has('is_active') ? 1 : 0;
        $params['is_public'] = $request->has('is_public') ? 1 : 0;

        $voucher->update($params);

        return redirect()->route('admin.vouchers.index')->with('statusSuccess', 'Cập nhật voucher thành công');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $voucher = Voucher::findOrFail($id);

        // Kiểm tra xem voucher có sản phẩm nào liên kết hay không
        if ($voucher->products()->exists()) {
            return redirect()->route('admin.vouchers.index')->with('statusError', 'Không thể xóa voucher này vì đang chứa sản phẩm áp dụng.');
        }

        // Xóa ảnh liên quan nếu có
        if ($voucher->image && file_exists(public_path('uploads/vouchers/images/' . $voucher->image))) {
            unlink(public_path('uploads/vouchers/images/' . $voucher->image));
        }

        $voucher->delete();

        return redirect()->route('admin.vouchers.index')->with('statusSuccess', 'Xóa voucher thành công!');
    }



    public function onActive($id)
    {

        $vouchers = Voucher::find($id);
        $vouchers->is_active = 1;
        $vouchers->save();


        return redirect()->route('admin.vouchers.index')->with('statusSuccess', 'Voucher đã được bật');
    }

    public function offActive($id)
    {

        $voucher = Voucher::find($id);
        $voucher->is_active = 0;
        $voucher->save();

        return redirect()->route('admin.vouchers.index')->with('statusSuccess', 'Voucher đã được tắt');
    }
}
