<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Components\Recusive;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listCategory = Category::whereNull('parent_category_id')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.categories.index', compact('listCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $htmlOption = $this->getCategory($parentId = '');
        return view('admin.categories.create', compact('htmlOption'));
    }

    public function getCategory($parentId)
    {
        $data = $this->category->all();
        $recusive = new Recusive($data);
        $htmlOption = $recusive->categoryRecursive($parentId);

        return $htmlOption;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required|string',
        ], [
            'name.required' => 'Tên danh mục chưa được nhập.',
            'name.string' => 'Tên danh mục phải là một chuỗi ký tự.',
            'name.max' => 'Tên danh mục không được quá 255 ký tự.',

            'image.required' => 'Không được để trống ảnh.',
            'image.image' => 'Tệp tải lên phải là một hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif, svg.',

            'description.required' => 'Mô tả danh mục chưa được nhập.',
            'description.string' => 'Mô tả phải là một chuỗi ký tự.',
        ]);
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');

            // Kiểm tra và xử lý ảnh nếu có
            if ($image = $request->file('image')) {
                $imageName = $image->hashName();
                $image->move(public_path('uploads/categories/images'), $imageName);
                $params['image'] = $imageName;
            } else {
                $params['image'] = null;
            }

            $params['is_active'] = $request->has('is_active') ? 1 : 0;

            // Tạo danh mục mới
            Category::create($params);

            return redirect()->route('admin.categories.index')->with('statusSuccess', 'Thêm danh mục thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $cate_parent = Category::where('is_active', 1)->get();
        $parentCategory = Category::findOrFail($id);
        $htmlOption = $this->getCategory($parentId = '');
        // Lấy tất cả danh mục con có parent_category_id bằng ID của danh mục cha
        $childCategories = $this->getAllChildCategories($parentCategory->id);
        return view('admin.categories.detail', compact('parentCategory', 'childCategories', 'cate_parent', 'htmlOption'));
    }


    private function getAllChildCategories($parentId)
    {
        // Lấy danh sách các danh mục con trực tiếp
        $childCategories = Category::where('parent_category_id', $parentId)->get();

        // Biến lưu trữ tất cả các danh mục con
        $allCategories = collect($childCategories);

        // Duyệt qua từng danh mục con và lấy thêm các danh mục cháu của nó
        foreach ($childCategories as $child) {
            $allCategories = $allCategories->merge($this->getAllChildCategories($child->id));
        }

        return $allCategories;
    }
    /**
     * Show the form for editing the specified resource.
     */


    public function edit(string $id)
    {
        // $cate_parent = Category::where('is_active', 1)->get();
        // $sub_parent = Category::where('parent_category_id', $id)->pluck('id')->toArray();
        $Cate = $this->category->find($id);
        $htmlOption = $this->getCategory($Cate->parent_category_id);

        return view('admin.categories.edit', compact('htmlOption', 'Cate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Cate = Category::findOrFail($id);

        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required|string',
            'parent_category_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($id) {
                    // Kiểm tra không cho phép chọn danh mục chính là cha của nó
                    if ($value == $id) {
                        $fail('Danh mục không thể là cha của chính nó.');
                    }
                }
            ],
        ], [
            'name.required' => 'Tên danh mục chưa được nhập.',
            'name.string' => 'Tên danh mục phải là một chuỗi ký tự.',
            'name.max' => 'Tên danh mục không được quá 255 ký tự.',

            'image.image' => 'Tệp tải lên phải là một hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif, svg.',

            'description.required' => 'Mô tả danh mục chưa được nhập.',
            'description.string' => 'Mô tả phải là một chuỗi ký tự.',

            'parent_category_id.exists' => 'Danh mục cha không hợp lệ.',
        ]);

        // Kiểm tra mối quan hệ danh mục cha/con
        if ($Cate->parent_category_id === null) {
            $childCategories = Category::where('parent_category_id', $Cate->id)->pluck('id')->toArray();
            if (in_array($request->parent_category_id, $childCategories)) {
                return redirect()->back()->with('statusError', 'Bạn không thể chọn danh mục cha làm con của nó.');
            }
        }

        // Xử lý ảnh nếu có
        $params = $request->except('_token', '_method');
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có và ảnh mới được tải lên
            if ($Cate->image && file_exists(public_path('uploads/categories/images/' . $Cate->image))) {
                unlink(public_path('uploads/categories/images/' . $Cate->image));
            }

            // Lưu ảnh mới
            $image = $request->file('image');
            $imageName = $image->hashName();
            $image->move(public_path('uploads/categories/images'), $imageName);
            $params['image'] = $imageName;
        } else {
            $params['image'] = $Cate->image;
        }

        // Cập nhật trạng thái hoạt động
        $params['is_active'] = $request->has('is_active') ? 1 : 0;

        // Cập nhật thông tin danh mục
        $Cate->update($params);

        return redirect()->route('admin.categories.index')->with('statusSuccess', 'Cập nhật danh mục thành công');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Cate = Category::findOrFail($id);

        // Kiểm tra và không cho phép xóa nếu có danh mục con
        $childCategories = Category::where('parent_category_id', $Cate->id)->count();
        if ($childCategories > 0) {
            return redirect()->route('admin.categories.index')->with('statusError', 'Không thể xóa danh mục vì có danh mục con.');
        }

        // Xóa ảnh nếu tồn tại
        if ($Cate->image && file_exists(public_path('uploads/categories/images/' . $Cate->image))) {
            unlink(public_path('uploads/categories/images/' . $Cate->image));
        }

        // Xóa danh mục
        $Cate->delete();

        return redirect()->route('admin.categories.index')->with('statusSuccess', 'Xóa danh mục thành công!');
    }


    public function product(Request $request, $categoryId)
    {
        // Lấy danh mục theo ID được truyền vào
        $currentCategory = Category::where('id', $categoryId)->where('fixed', 0)->first();

        // Kiểm tra nếu danh mục tồn tại, lấy tất cả sản phẩm thuộc danh mục
        $bestSellingProducts = $currentCategory ? $currentCategory->products : collect();

        // Lấy tất cả sản phẩm đang hoạt động
        $allProducts = Product::where('is_active', 1)->get();

        // Lấy danh sách ID của sản phẩm bán chạy
        $bestSellingProductIds = $bestSellingProducts->pluck('id')->toArray();

        return view('admin.categories.topproduct', compact('currentCategory', 'allProducts', 'bestSellingProducts', 'bestSellingProductIds'));
    }



    public function updateBestSelling(Request $request, $categoryId)
    {
        // Lấy danh mục hiện tại thông qua ID
        $currentCategory = Category::find($categoryId);

        // Kiểm tra nếu danh mục tồn tại
        if (!$currentCategory) {
            return redirect()->back()->with('statusError', 'Danh mục không tồn tại.');
        }

        // Kiểm tra nếu có sản phẩm được chọn
        if (!$request->has('product_ids')) {
            return redirect()->back()->with('statusError', 'Không có sản phẩm nào được chọn.');
        }

        // Lấy danh sách ID sản phẩm được chọn từ request
        $productIds = $request->input('product_ids');

        // Lọc các sản phẩm chưa tồn tại trong danh mục
        $existingProductIds = $currentCategory->product_categories()->pluck('product_id')->toArray();
        $newProductIds = array_diff($productIds, $existingProductIds);

        // Thêm sản phẩm mới nếu có
        if (!empty($newProductIds)) {
            $data = [];
            foreach ($newProductIds as $productId) {
                $data[] = [
                    'product_id' => $productId,
                    'category_id' => $currentCategory->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            $currentCategory->product_categories()->insert($data);

            return back()->with('statusSuccess', 'Sản phẩm mới đã được thêm vào danh mục.');
        }

        // Nếu không có sản phẩm mới
        return back()->with('statusInfo', 'Tất cả sản phẩm đã có trong danh mục.');
    }


    public function remove(Request $request, $categoryId, $productId)
    {
        // Lấy danh mục theo ID
        $currentCategory = Category::find($categoryId);

        // Kiểm tra nếu danh mục tồn tại
        if (!$currentCategory) {
            return back()->with('statusError', 'Danh mục không tồn tại.');
        }

        // Lấy sản phẩm theo ID
        $product = Product::find($productId);

        // Kiểm tra nếu sản phẩm tồn tại và thuộc danh mục hiện tại
        if (!$product) {
            return back()->with('statusError', 'Sản phẩm không tồn tại.');
        }

        // Kiểm tra xem sản phẩm có thuộc danh mục này không
        if (!$product->categories->contains($currentCategory->id)) {
            return back()->with('statusError', 'Sản phẩm không thuộc danh mục này.');
        }

        // Gỡ sản phẩm khỏi danh mục
        $product->categories()->detach($currentCategory->id);

        return back()->with('statusSuccess', 'Sản phẩm đã được gỡ khỏi danh mục.');
    }

    public function fake_sales(Request $request, $id)
    {

        $validated = $request->validate([
            'fake_sales' => 'required|integer|min:1',
        ]);

        try {
            $newFakeSales = $validated['fake_sales']; // Lấy số lượng nhập từ request

            $product = Product::findOrFail($id);

            $product->update([
                'fake_sales' => $newFakeSales,
            ]);

            // Trả về thông báo thành công
            return redirect()->back()->with('statusSuccess', 'Số lượng ảo đã được cập nhật!');
        } catch (\Exception $e) {
            // Nếu có lỗi, trả về thông báo lỗi
            return redirect()->back()->with('statusError', 'Có lỗi xảy ra, vui lòng thử lại!');
        }
    }
}
