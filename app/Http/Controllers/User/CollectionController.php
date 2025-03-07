<?php

namespace App\Http\Controllers\user;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $listCategory = Category::query()->get();
    //     $listProduct = Product::query()->get();
    //     $cate_parent = Category::all(); 
    //     $listCate = []; 
    //     $query = Product::query();

    //     if ($request->has('categories')) {
    //         $categoryIds = explode(',', $request->input('categories'));
    //         $query->whereHas('categories', function($q) use ($categoryIds) {
    //             $q->whereIn('category_id', $categoryIds);
    //         });
    //     }


    //     $listProduct = $query->get();

    //     if ($request->ajax()) {
    //         return response()->json(['listProduct' => $listProduct]);
    //     }

    //     Category::recursive($cate_parent, 0, 1, $listCate);
    //     return view('user.collection', compact('listProduct', 'listCategory', 'listCate'));
    // }



    public function index(Request $request)
    {
        $listCategory = Category::all(); // Lấy tất cả danh mục
        $cate_parent = Category::all();
        $listCate = [];
        $query = Product::query();
        if ($request->has('categories')) {
            $categoryIds = explode(',', $request->input('categories'));
            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds);
            });
        }


        $listProduct = $query->get();

        // Gọi phương thức recursive để lấy danh sách danh mục
        Category::recursive($cate_parent, 0, 1, $listCate);

        if ($request->ajax()) {
            return response()->json(['listProduct' => $listProduct]);
        }

        return view('user.filterProduct', compact('listCate', 'listCategory', 'listProduct'));
    }

    public function getProducts()
    {
        $products = Product::all();
        return response()->json($products);
    }


    public function getProductsByCategory($id)
    {
        // Lấy danh mục theo ID
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Lấy tất cả sản phẩm liên quan đến danh mục này thông qua bảng product_categories
        $products = $category->products()->with('product_categories')->get();

        return response()->json([
            'category' => $category,
            'products' => $products,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function filterProducts(Request $request)
    {
        // Lấy danh sách các danh mục được chọn từ request
        $categoryIds = $request->input('categories');

        // Truy vấn để lấy các sản phẩm thuộc danh mục được chọn
        if (!empty($categoryIds)) {
            $products = Product::whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })->get();
        } else {
            // Nếu không có danh mục nào được chọn, lấy tất cả sản phẩm
            $products = Product::all();
        }

        // Trả về danh sách sản phẩm dưới dạng JSON
        return response()->json(['products' => $products]);
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
    public function show(string $id) {}

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
