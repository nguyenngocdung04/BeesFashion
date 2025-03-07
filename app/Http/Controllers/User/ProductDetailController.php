<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Order_detail;
use App\Models\Product_vote;
use Illuminate\Http\Request;
use App\Models\Attribute_value;
use App\Models\Product_variant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductDetailController extends Controller
{
    public function index(string $sku)
    {
        $product = Product::with([
            'product_variants.variant_attribute_values.attribute_value.attribute',
            'categories',
            'product_files',
            'product_variants.product_votes.user',
            'product_variants.order_details.order.status_orders.status'
        ])->where('SKU', $sku)->first();

        if ($product) {
            // Tăng lượt xem
            $product->increment('view');

            // Tính toán giá và % giảm
            $product->priceRange = $product->getPriceRange();
            $product->regularPrice = $product->getRegularPrice();
            $product->discountPercent = $product->getDiscountPercent();

            // Xử lý variants và attributes
            $array_variants = $this->getFormattedVariants($product);
            $array_attributes = $this->getFormattedAttributes($product);

            // Tính tổng stock thực tế
            $total_stock = $this->calculateTotalRealStock($product->product_variants);

            // Lấy sản phẩm liên quan
            $relatedProducts = $this->getRelatedProducts($product);

            // Lấy sản phẩm bán chạy
            $bestProducts = $this->getBestProducts($product);

            // Lấy đánh giá sản phẩm
            $reviewData = $this->getProductReviewData($product);

            return view('user.product-detail', compact(
                'product',
                'array_variants',
                'array_attributes',
                'total_stock',
                'relatedProducts',
                'bestProducts',
                'reviewData'
            ));
        }

        return redirect()->route('home')->with('error', 'Sản phẩm không tồn tại');
    }

    private function getFormattedVariants($product)
    {
        return $product->product_variants->map(function ($variant) {
            // Tính toán real stock cho variant
            $realStock = $this->calculateRealStock($variant->id, $variant->stock);

            return [
                'variant_id' => $variant->id,
                'regular_price' => $variant->regular_price,
                'sale_price' => $variant->sale_price,
                'stock' => $realStock,
                'is_active' => $variant->is_active,
                'attribute_values' => $variant->variant_attribute_values->pluck('attribute_value_id')->toArray()
            ];
        })->toArray();
    }

    private function getFormattedAttributes($product)
    {
        // Lấy tất cả attribute_value_ids và attribute_ids duy nhất
        $attribute_value_ids = $product->product_variants
            ->pluck('variant_attribute_values.*.attribute_value_id')
            ->flatten()
            ->unique()
            ->toArray();

        $attribute_ids = Attribute_value::whereIn('id', $attribute_value_ids)
            ->pluck('attribute_id')
            ->unique()
            ->sort()
            ->toArray();

        // Xây dựng mảng thuộc tính đã lọc
        return Attribute::with([
            'attribute_values' => function ($query) use ($attribute_value_ids) {
                $query->whereIn('id', $attribute_value_ids);
            },
            'attribute_type'
        ])->whereIn('id', $attribute_ids)
        ->get()
        ->mapWithKeys(function ($attribute) {
            return [
                $attribute->id => [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'type' => $attribute->attribute_type ? $attribute->attribute_type->type_name : null,
                    'attribute_values' => $attribute->attribute_values
                        ->sortBy(function ($value) {
                            $sizes = ['S' => 1, 'M' => 2, 'L' => 3, 'XL' => 4, 'XXL' => 5];
                            return $sizes[$value->name] ?? $value->name;
                        })
                        ->values()
                        ->map(function ($value) {
                            return [
                                'id' => $value->id,
                                'name' => $value->name,
                                'value' => $value->value
                            ];
                        })->toArray()
                ]
            ];
        })->toArray();
    }

    private function calculateRealStock($variantId, $originalStock)
    {
        // Trừ số lượng cho các đơn hàng đang xử lý
        $reduceQuantity = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('status_orders', 'orders.id', '=', 'status_orders.order_id')
            ->join('statuses', 'status_orders.status_id', '=', 'statuses.id')
            ->where('order_details.product_variant_id', $variantId)
            ->whereIn('statuses.name', ['Processing', 'Pending', 'Shipping', 'Completed'])
            ->sum('order_details.quantity');

        // Cộng lại số lượng cho đơn hàng hoàn/trả
        $addQuantity = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('status_orders', 'orders.id', '=', 'status_orders.order_id')
            ->join('statuses', 'status_orders.status_id', '=', 'statuses.id')
            ->where('order_details.product_variant_id', $variantId)
            ->whereIn('statuses.name', ['Cancelled', 'Returned'])
            ->sum('order_details.quantity');

        return $originalStock - $reduceQuantity + $addQuantity;
    }

    private function calculateTotalRealStock($productVariants)
    {
        return $productVariants->sum(function ($variant) {
            return $this->calculateRealStock($variant->id, $variant->stock);
        });
    }

    private function getRelatedProducts($product)
    {
        return Product::whereHas('categories', function ($query) use ($product) {
            $query->whereIn('category_id', $product->categories->pluck('id'))
                ->where('categories.fixed', 1);
        })
        ->where('id', '!=', $product->id)
        ->take(8)
        ->get()
        ->map(function ($relatedProduct) {
            return $this->formatProductForDisplay($relatedProduct);
        });
    }

    private function getBestProducts($product)
    {
        $firstCategory = Category::where('fixed', 0)->first();

        return Product::whereHas('categories', function ($query) use ($firstCategory) {
            $query->where('categories.id', $firstCategory->id);
        })
        ->with(['product_files', 'product_variants', 'product_variants.product_votes.user'])
        ->where('id', '!=', $product->id)
        ->take(8)
        ->get()
        ->map(function ($bestProduct) {
            return $this->formatProductForDisplay($bestProduct);
        });
    }

    private function formatProductForDisplay($product)
    {
        $product->priceRange = $product->getPriceRange();

        $activeImage = $product->product_files->where('is_default', 1)->first();
        $inactiveImage = $product->product_files->where('is_default', 0)->first();

        $product->active_image = $activeImage ? $activeImage->file_name : null;
        $product->inactive_image = $inactiveImage ? $inactiveImage->file_name : null;

        $product->rating = $this->calculateProductRating($product);

        return $product;
    }

    public function updateInformationProduct(Request $request)
    {
        $array_attribute_value_ids = $request->input('attribute_value_ids');
        $product_id = $request->input('product_id');

        // Tìm variant phù hợp
        $variant = DB::table('product_variants as pv')
            ->select('pv.*')
            ->where('pv.product_id', $product_id)
            ->whereIn('pv.id', function ($query) use ($array_attribute_value_ids) {
                $query->select('product_variant_id')
                    ->from('product_variant_attribute_values')
                    ->whereIn('attribute_value_id', $array_attribute_value_ids)
                    ->groupBy('product_variant_id')
                    ->havingRaw('COUNT(attribute_value_id) = ?', [count($array_attribute_value_ids)]);
            })->first();

        if ($variant) {
            // Tính toán real stock
            $realStock = $this->calculateRealStock($variant->id, $variant->stock);

            return response()->json([
                'status' => 'success',
                'data' => array_merge(
                    (array)$variant,
                    ['real_stock' => $realStock]
                )
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Không tìm thấy biến thể phù hợp'
        ]);
    }
    public function addToCart()
    {
        $variant_id = request()->input('variant_id');
        $quantity = request()->input('quantity');
        if (!auth()->check()) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.'
            ]);
        }
        // Lấy thông tin biến thể
        $variant = Product_variant::select('stock', 'is_active')
            ->where('id', $variant_id)
            ->first();

        // Kiểm tra biến thể có tồn tại và đang hoạt động
        if (!$variant || $variant->is_active == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sản phẩm này đã ngưng bán. Vui lòng chọn mẫu khác.'
            ]);
        }

        // Kiểm tra nếu biến thể đã có trong giỏ hàng
        $checkCart = Cart::with('product_variant')
            ->where('product_variant_id', $variant_id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if ($checkCart) {
            // Tính toán số lượng mới
            $newQuantity = $checkCart->quantity + $quantity;
            // Kiểm tra số lượng sản phẩm còn lại trong kho
            $availableStock = $checkCart->product_variant->stock - $checkCart->quantity;
            // Đảm bảo không vượt quá tồn kho
            if ($newQuantity > $checkCart->product_variant->stock) {
                if ($availableStock > 0) {
                    $checkCart->quantity = $checkCart->quantity + $availableStock;
                    $checkCart->save();
                    // Trả về thông báo số lượng sản phẩm đã đạt đến giới hạn kho
                    return response()->json([
                        'status' => 'warning',
                        'message' => "Đã thêm $availableStock sản phẩm vào giỏ hàng vì đã đạt giới hạn kho."
                    ]);
                } else {
                    // Nếu kho đã hết, không thể thêm bất kỳ sản phẩm nào
                    return response()->json([
                        'status' => 'warning',
                        'message' => 'Sản phẩm này đã đạt giới hạn của kho trong giỏ hàng.'
                    ]);
                }
            } else {
                // Nếu số lượng không vượt quá tồn kho, cập nhật số lượng trong giỏ hàng
                $checkCart->quantity = $newQuantity;
                $checkCart->updated_at = now();  // Cập nhật thời gian
                $checkCart->save();
            }
        } else {
            if ($variant) {
                // Nếu sản phẩm chưa có trong giỏ hàng, thêm sản phẩm vào giỏ hàng
                $quantityToAdd = min($variant->stock, $quantity);  // Giới hạn theo số lượng tồn kho

                // Nếu kho không đủ để thêm toàn bộ số lượng, thông báo
                if ($quantityToAdd < $quantity) {
                    // Thêm số lượng tối đa có thể vào giỏ hàng
                    Cart::create([
                        'quantity' => $quantityToAdd,
                        'product_variant_id' => $variant_id,
                        'user_id' => Auth::user()->id,
                        'created_at' => now()
                    ]);

                    // Trả về thông báo về số lượng đã thêm vào giỏ hàng
                    return response()->json([
                        'status' => 'success',
                        'message' => "Đã thêm $quantityToAdd sản phẩm vào giỏ hàng vì đã đạt giới hạn kho."
                    ]);
                }

                Cart::create([
                    'quantity' => $quantityToAdd,  // Thêm vào giỏ hàng với số lượng tối đa có sẵn trong kho
                    'product_variant_id' => $variant_id,
                    'user_id' => Auth::user()->id,
                    'created_at' => now()
                ]);
            }
        }
        // Tính tổng số lượng giỏ hàng
        $cartCount = Cart::where('user_id', Auth::id())->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Thêm sản phẩm vào giỏ hàng thành công.',
            'cartCount' => $cartCount
        ]);
    }

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

    private function getProductReviewData($product)
    {
        $variantIds = $product->product_variants->pluck('id')->toArray();

        // Lấy đánh giá
        $reviews = Product_vote::whereIn('product_variant_id', $variantIds)
            ->with(['user', 'product_variant'])
            ->orderBy('created_at', 'desc')
            ->get();
        // Lấy đánh giá active để hiển thị trong comments
        $activeReviews = $reviews->where('is_active', 1);
        // Tính toán thống kê
        $totalReviews = $reviews->count();
        $activeReviewCount = $activeReviews->count();
        $averageRating = $totalReviews > 0 ? round($reviews->avg('star'), 1) : 5;

        // Tính phần trăm cho từng số sao
        $starCounts = $reviews->groupBy('star');
        $starPercentages = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = isset($starCounts[$i]) ? $starCounts[$i]->count() : 0;
            $starPercentages[$i] = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
        }

        // Tính tổng số lượng đã bán
        $totalSold = Order_detail::whereIn('product_variant_id', $variantIds)
            ->whereHas('order.status_orders.status', function ($query) {
                $query->where('name', 'Completed');
            })
            ->sum('quantity');

        // Thêm fake_sales nếu có
        $totalSold += $product->fake_sales ?? 0;

        return [
            'reviews' => $activeReviews,
            'stats' => [
                'average_rating' => $averageRating,
                'total_reviews' => $totalReviews,
                'active_review_count' => $activeReviewCount,
                'star_percentages' => $starPercentages,
                'total_sold' => $totalSold
            ]
        ];
    }
}
