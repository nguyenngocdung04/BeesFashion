<?php

namespace App\Http\Controllers\admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $listBrand = Brand::get();
        // dd($listBrand);
        return view('admin.brands.index', compact('listBrand'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        // Kiểm tra phương thức POST (Laravel đã tự động xử lý nhưng nếu bạn muốn giữ lại kiểm tra, thì có thể)
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/brands/images'), $imageName); 
                $params['image'] = $imageName;
            } else {
                $params['image'] = null;
            }
            Brand::create($params);
            // Chuyển hướng về trang danh sách thương hiệu và hiển thị thông báo thành công
            return redirect()->route('admin.brands.index')->with('statusSuccess', 'Thêm thương hiệu thành công');
        }
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
        $brandID = Brand::findOrFail($id);
        // dd($brandID);
        return view('admin.brands.edit', compact('brandID'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, string $id)
    {
        //
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $brandID = Brand::query()->findOrFail($id);

            if ($request->hasFile('image')) {
                // Xóa ảnh cũ nếu có và ảnh mới được tải lên
                if ($brandID->image && file_exists(public_path('uploads/brands/images/' . $brandID->image))) {
                    unlink(public_path('uploads/brands/images/' . $brandID->image));
                }
        
                // Tạo tên ảnh duy nhất và lưu ảnh mới
                $image = $request->file('image');
                $imageName = $image->hashName();
                $image->move(public_path('uploads/brands/images'), $imageName);
        
                // Lưu tên ảnh mới
                $params['image'] = $imageName;
            } else {
                // Nếu không có ảnh mới, giữ ảnh cũ
                $params['image'] = $brandID->image;
            }

            $brandID->update($params);

            return redirect()->route('admin.brands.index')->with('statusSuccess', 'Cập nhật thương hiệu thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Tìm thương hiệu theo ID, nếu không tìm thấy sẽ trả về lỗi 404
            $brand = Brand::findOrFail($id);

            // Kiểm tra nếu thương hiệu này có sản phẩm liên kết
            if ($brand->products()->exists()) {
                // Nếu có sản phẩm, trả về thông báo lỗi
                return redirect()->route('admin.brands.index')->with(
                    'statusError',
                    'Không thể xóa thương hiệu đã có sản phẩm nằm trong thương hiệu này!'
                );
            }

            // Nếu không có sản phẩm liên kết, tiến hành xóa hình ảnh nếu có
            if ($brand->image && Storage::disk('public')->exists('uploads/brands/images/' . $brand->image)) {
                // Xóa ảnh từ storage
                Storage::disk('public')->delete('uploads/brands/images/' . $brand->image);
            }
            if ($brand->image && file_exists(public_path('uploads/brands/images/' . $brand->image))) {
                unlink(public_path('uploads/brands/images/' . $brand->image));
            }

            // Xóa thương hiệu
            $brand->delete();

            // Thông báo thành công và chuyển hướng về trang danh sách
            return redirect()->route('admin.brands.index')->with('statusSuccess', 'Xóa thương hiệu thành công!');
        } catch (\Exception $e) {
            // Nếu có lỗi, thông báo lỗi và chuyển hướng về danh sách
            return redirect()->route('admin.brands.index')->with(
                'statusError',
                'Đã xảy ra lỗi không mong muốn. Vui lòng thử lại.'
            );
        }
    }
}
