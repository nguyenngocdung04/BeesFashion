<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner_image;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::get();
        return view('admin.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'file_name' => 'required|array',
         

        ], [
            'name.required' => 'Tên banner là bắt buộc.',
            'name.string' => 'Tên banner phải là một chuỗi ký tự.',
            'name.max' => 'Tên banner không được quá 255 ký tự.',
            'file_name.required' => 'Bạn cần chọn ít nhất một ảnh.',
            'file_name.array' => 'Danh sách ảnh phải là một mảng.',
        ]);

        if ($request->isMethod('POST')) {
            $params = $request->except('_token');

            // Kiểm tra xem có banner nào đã có trạng thái 'is_active' = 1 hay chưa
            $isActiveExists = Banner::where('is_active', 1)->exists();

            // Nếu có banner có trạng thái is_active = 1, gán is_active của banner mới là 0
            if ($isActiveExists) {
                $params['is_active'] = 0; // Gán trạng thái của banner mới là 0
            } else {
                $params['is_active'] = 1; // Nếu chưa có banner với trạng thái 1, gán banner mới là 1
            }

            // Tạo mới banner
            $Ban = Banner::create($params);
            $banID = $Ban->id;

            // Xử lý thêm album ảnh
            if ($request->hasFile('file_name')) {
                foreach ($request->file('file_name') as $image) {
                    if ($image) {
                        // Tạo tên ảnh duy nhất
                        $imageName = $image->hashName();

                        // Di chuyển ảnh vào thư mục uploads
                        $image->move(public_path('uploads/banners/images/id_' . $banID), $imageName);

                        // Lưu thông tin hình ảnh vào bảng banner_images
                        $Ban->banner_images()->create([
                            'file_name' => $imageName,
                        ]);
                    }
                }
            }

            return redirect()->route('admin.banner.index')->with('statusSuccess', 'Thêm thành công');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $Ban = Banner::query()->findOrFail($id);
        return view('admin.banner.edit', compact('Ban'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('PUT')) {
            // Lấy tất cả các tham số từ form, bỏ qua _token và _method
            $params = $request->except('_token', '_method');
            $Ban = Banner::findOrFail($id);

            // Kiểm tra xem có ảnh mới trong yêu cầu không
            $hasNewImages = isset($request->file_name) && is_array($request->file_name) && count($request->file_name) > 0;

            // Kiểm tra nếu không có ảnh nào được chọn và người dùng không chọn xóa ảnh
            if (!$hasNewImages) {
                // Nếu không có ảnh mới, nhưng người dùng muốn giữ ảnh cũ hoặc không chọn ảnh mới, cần phải báo lỗi
                return back()->with(['statusError' => 'Bạn chưa thêm ảnh.']);
            }

            // Nếu có ảnh mới hoặc ảnh cần thay thế
            if ($hasNewImages) {
                // Lấy các ID của ảnh hiện tại từ DB
                $currentImages = $Ban->banner_images->pluck('id')->toArray();

                // Kiểm tra và xóa ảnh không còn trong yêu cầu
                foreach ($currentImages as $imageId) {
                    // Kiểm tra nếu ảnh không còn trong request
                    if (!isset($request->file_name[$imageId])) {
                        $banner_image = Banner_image::find($imageId);
                        // Nếu ảnh tồn tại, xóa ảnh và bản ghi trong DB
                        if ($banner_image) {
                            $imagePath = public_path('uploads/banners/images/id_' . $id . '/' . $banner_image->file_name);
                            if (file_exists($imagePath)) {
                                unlink($imagePath); // Xóa ảnh cũ
                            }
                            $banner_image->delete(); // Xóa bản ghi ảnh cũ
                        }
                    }
                }

                // Xử lý ảnh mới hoặc ảnh thay thế
                foreach ($request->file_name as $key => $image) {
                    // Nếu ảnh mới được chọn (là đối tượng UploadedFile)
                    if ($image instanceof \Illuminate\Http\UploadedFile) {
                        // Tạo tên ảnh duy nhất
                        $imageName = $image->hashName();

                        // Di chuyển ảnh vào thư mục uploads
                        $image->move(public_path('uploads/banners/images/id_' . $id), $imageName);

                        // Nếu ảnh đã tồn tại trong DB (cập nhật)
                        if (isset($currentImages[$key])) {
                            // Tìm ảnh trong DB và xóa ảnh cũ
                            $banner_image = Banner_image::find($currentImages[$key]);
                            if ($banner_image) {
                                $imagePath = public_path('uploads/banners/images/id_' . $id . '/' . $banner_image->file_name);
                                if (file_exists($imagePath)) {
                                    unlink($imagePath); // Xóa ảnh cũ
                                }

                                // Cập nhật tên ảnh mới vào DB
                                $banner_image->update([
                                    'file_name' => $imageName,
                                ]);
                            }
                        } else {
                            // Nếu là ảnh mới (chưa có trong DB), lưu vào bảng
                            $Ban->banner_images()->create([
                                'ban_id' => $id,
                                'file_name' => $imageName,
                            ]);
                        }
                    }
                }
            }

            // Cập nhật các trường khác
            $params['is_active'] = $request->has('is_active') ? 1 : 0;
            $Ban->update($params);

            return redirect()->route('admin.banner.index')->with('statusSuccess', 'Cập nhật thành công!');
        }
    }








    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Tìm banner theo ID
        $Ban = Banner::findOrFail($id);

        // Xóa các hình ảnh liên quan đến banner
        foreach ($Ban->banner_images as $bannerImage) {
            // Đường dẫn của ảnh cần xóa
            $imagePath = public_path('uploads/banners/images/id_' . $id . '/' . $bannerImage->file_name);

            // Kiểm tra xem ảnh có tồn tại trong thư mục không, nếu có thì xóa
            if (file_exists($imagePath)) {
                unlink($imagePath);  // Xóa ảnh khỏi thư mục
            }

            // Xóa bản ghi ảnh trong cơ sở dữ liệu
            $bannerImage->delete();
        }

        // Kiểm tra và xóa thư mục nếu nó trống
        $directoryPath = public_path('uploads/banners/images/id_' . $id);

        // Nếu thư mục tồn tại và trống, xóa thư mục
        if (is_dir($directoryPath) && count(scandir($directoryPath)) == 2) {
            rmdir($directoryPath);  // Xóa thư mục nếu nó trống
        }

        // Xóa banner
        $Ban->delete();

        // Quay lại trang danh sách banner với thông báo thành công
        return redirect()->route('admin.banner.index')->with('statusSuccess', 'Xóa thành công!');
    }




    public function onActive($id)
    {

        Banner::where('is_active', 1)->update(['is_active' => 0]);

        // Bật banner được chọn
        $banner = Banner::find($id);
        $banner->is_active = 1;
        $banner->save();


        return redirect()->route('admin.banner.index')->with('statusSuccess', 'Banner đã được bật');
    }

    public function offActive($id)
    {

        $activeBanner = Banner::where('is_active', 1)->count();

        // Nếu chỉ còn một banner đang bật và nó là banner cần tắt
        if ($activeBanner <= 1) {
            return redirect()->route('admin.banner.index')->with('statusError', 'Phải có ít nhất một banner đang bật');
        }
        // Tắt banner được chọn
        $banner = Banner::find($id);
        $banner->is_active = 0;
        $banner->save();

        return redirect()->route('admin.banner.index')->with('statusSuccess', 'Banner đã được tắt');
    }
}
