<?php

namespace App\Http\Controllers\user;

use App\Models\Product;
use App\Models\Product_vote;
use Illuminate\Http\Request;
use App\Models\Favorite_product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id(); // Lấy ID người dùng hiện tại

        // Lấy tất cả sản phẩm mà người dùng đã thêm vào wishlist
        $products = Product::whereHas('favorite_products', function ($query) use ($userId) {
            $query->where('user_id', $userId); // Lọc theo user_id từ bảng favorite_products
        })
            ->with([
                'product_files', 
                'product_variants', 
                'product_variants.product_votes.user'
            ])
            ->limit(8)  // Giới hạn số lượng sản phẩm lấy ra
            ->get()
            ->map(function ($product) {
                // Lấy ảnh sản phẩm mặc định và không mặc định
                $activeImage = $product->product_files->where('is_default', 1)->first();
                $inactiveImage = $product->product_files->where('is_default', 0)->first();
        
                // Gán giá trị cho các thuộc tính ảnh
                $product->active_image = $activeImage ? $activeImage->file_name : null;
                $product->inactive_image = $inactiveImage ? $inactiveImage->file_name : null;
        
                // Lấy phạm vi giá của sản phẩm (ví dụ: giá min-max)
                $product->priceRange = $product->getPriceRange();
        
                $rating = $this->calculateProductRating($product);
                $product->rating = $rating;
                return $product;
        
            });
        return view('user.wishlist', compact('products'));
    }

    public function addToWishlist(Request $request)
    {
        $user_id = auth()->id();

        // Kiểm tra xem sản phẩm đã tồn tại trong wishlist của người dùng chưa
        $exists = Favorite_product::where('user_id', $user_id)
            ->where('product_id', $request->product_id)
            ->exists();
    
        if ($exists) {
            return response()->json(['status' => 'error', 'message' => 'Sản phẩm đã có trong yêu thích.']);
        }
    
        // Thêm sản phẩm vào wishlist
        Favorite_product::create([
            'user_id' => $user_id,
            'product_id' => $request->product_id,
        ]);
    
        // Đếm lại số lượng sản phẩm yêu thích của người dùng
        $wishCount = Favorite_product::where('user_id', $user_id)->count();

        return response()->json([
            'status' => 'success', 
            'message' => 'Sản phẩm đã được thêm vào yêu thích.',
            'wishCount' => $wishCount
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    
     private function calculateProductRating($product)
     {
         $variantIds = $product->product_variants->pluck('id')->toArray();
 
         $reviews = Product_vote::whereIn('product_variant_id', $variantIds)
             ->where('is_active', 1)
             ->get();
 
         $totalReviews = $reviews->count();
         $averageRating = $totalReviews > 0 ? round($reviews->avg('star'), 1) : 5; // Mặc định 5 sao nếu chưa có đánh giá
 
         return [
             'average_rating' => $averageRating,
             'total_reviews' => $totalReviews
         ];
     }


     public function deleteToWishlist(Request $request)
     {
         // Xác thực dữ liệu từ yêu cầu
         $request->validate([
             'product_id' => 'required|exists:products,id',
         ]);
     
         // Lấy ID người dùng (giả sử người dùng đã đăng nhập)
         $user_id = auth()->id();
     
         // Kiểm tra xem sản phẩm có tồn tại trong danh sách yêu thích không
         $favorite = Favorite_product::where('user_id', $user_id)
             ->where('product_id', $request->product_id)
             ->first();
     
         if (!$favorite) {
             // Trả về phản hồi lỗi nếu sản phẩm không tồn tại
             return response()->json([
                 'status' => 'error',
                 'message' => 'Sản phẩm không có trong danh sách yêu thích.',
             ]);
         }
     
         // Xóa sản phẩm khỏi danh sách yêu thích
         $favorite->delete();
     
         // Trả về phản hồi thành công
         return response()->json([
             'status' => 'success',
             'message' => 'Sản phẩm đã được xóa khỏi danh sách yêu thích.',
         ]);
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
