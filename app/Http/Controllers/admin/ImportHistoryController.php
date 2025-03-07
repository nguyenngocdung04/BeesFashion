<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\Import_history;
use App\Models\Product_variant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ImportHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $importHistories = Import_history::latest()->get();
        return view('admin.import_history.index', compact('importHistories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function updateQuantity(Request $request)
    {
        // Validate input
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ], [
            'quantity.required' => 'Số lượng là bắt buộc.',
            'quantity.integer' => 'Số lượng phải là một số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
        ]);

        $skuId = $request->SKU;
        $quantityToAdd = $request->quantity;

        // Tìm sản phẩm variant
        $productVariant = Product_variant::find($skuId);

        if (!$productVariant) {
            return redirect()->route('admin.import_history.index')
                ->with('statusError', 'Sản phẩm không tồn tại.');
        }

        $lastImportHistory = Import_history::where('product_variant_id', $productVariant->id)
            ->orderBy('created_at', 'desc')
            ->first();

        // Nếu không có lịch sử nhập trước đó, sử dụng giá nhập từ yêu cầu
        $importPrice = $lastImportHistory ? $lastImportHistory->import_price : $request->import_price;

        // Sử dụng transaction để đảm bảo dữ liệu không bị lỗi
        DB::beginTransaction();

        try {
            // Cập nhật tồn kho sản phẩm
            $productVariant->stock += $quantityToAdd;
            $productVariant->save();

            // Tạo một bản ghi mới trong Import_history để lưu lại thay đổi
            Import_history::create([
                'product_variant_id' => $productVariant->id,
                'quantity' => $quantityToAdd,
                'user_id' => auth()->id(), // Nếu bạn cần lưu thông tin người nhập
                'import_price' => $importPrice, // Lưu giá nhập (sử dụng giá cũ nếu có)
            ]);

            // Commit transaction nếu không có lỗi
            DB::commit();

            return redirect()->route('admin.import_history.index')
                ->with('statusSuccess', 'Nhập hàng thành công!');
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();
            return redirect()->route('admin.import_history.index')
                ->with('statusError', 'Có lỗi xảy ra khi cập nhật!');
        }
    }



    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
