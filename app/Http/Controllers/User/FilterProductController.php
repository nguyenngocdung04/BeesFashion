<?php

namespace App\Http\Controllers\user;

use App\Models\Cart;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Product_file;
use App\Models\Product_vote;
use Illuminate\Http\Request;
use App\Models\Attribute_value;
use App\Models\Product_variant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FilterProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {

        function priceProduct($product)
        {
            // Lấy giá sale và giá nhập của sản phẩm từ product_variants
            $salePrices = $product->product_variants->pluck('sale_price');
            $importPrices = $product->product_variants->pluck('regular_price');

            $minSalePrice = $salePrices->min();
            $maxSalePrice = $salePrices->max();
            $minImportPrice = $importPrices->min();
            $maxImportPrice = $importPrices->max();

            // Kiểm tra và trả về giá
            if ($salePrices->every(fn($price) => $price === null)) {
                // Tất cả sale_price đều là null
                return "$" . number_format($minImportPrice) . " - $" . number_format($maxImportPrice);
            } elseif ($salePrices->contains(null)) {
                // Có sale_price là null
                if ($minSalePrice === null) {
                    return "$" . number_format($minImportPrice) . " - $" . number_format($maxSalePrice);
                } elseif ($maxSalePrice === null) {
                    return "$" . number_format($minSalePrice) . " - $" . number_format($maxImportPrice);
                } else {
                    return "$" . number_format($minSalePrice) . " - $" . number_format($maxSalePrice);
                }
            } else {
                // Tất cả có sale_price
                return "$" . number_format($minSalePrice) . " - $" . number_format($maxSalePrice);
            }
        }

        // Lấy danh sách các danh mục cha
        $listCategory = Category::whereNull('parent_category_id')->where('categories.fixed', 1)->with('categoryChildrent')->get();
        // Lấy danh sách sản phẩm và danh sách thương hiệu
        $listProduct = Product::with(['categories', 'brand'])->get();
        $listBrand = Brand::all();
        // Lấy danh sách màu sắc (attributes) cho sản phẩm
        $listColor = Attribute_value::all();
        $productsQuery = Product::join('product_categories', 'products.id', '=', 'product_categories.product_id')
            ->join('categories', 'product_categories.category_id', '=', 'categories.id')
            ->where('categories.fixed', 0)
            ->where('products.is_active', 1) // Lọc sản phẩm đang hoạt động
            ->with(['product_files', 'product_variants.product_votes'])
            ->select('products.*')
            ->get();;
        if ($request->has('brand_id')) {
            $productsQuery->where('brand_id', $request->brand_id);
        }

        // Tính trung bình số sao
        $productsQuery->map(function ($product) {
            // Lấy dữ liệu đánh giá cho sản phẩm
            $rating = $this->getProductReviewData($product);
            $product->averageRating = $rating['average_rating']; // Gán giá trị average_rating cho sản phẩm
        });

        $products = $productsQuery;
        // dd($products);

        $minPriceProduct = $products->map(function ($product) {
            return priceProduct($product);
        })->min();
        $maxPriceProduct = $products->map(function ($product) {
            return priceProduct($product);
        })->max();
        return view('user.filterProduct', compact(
            'listCategory',
            'listProduct',
            'listBrand',
            'maxPriceProduct',
            'minPriceProduct',
            'listColor',
            'products' // Truyền danh sách sản phẩm đã phân trang
        ));
    }




    public function getMinMaxPriceProduct()
    {
        $products = Product::where('is_active', 1)->get();
        if ($products) {
            $minPriceProduct = 0;
            $maxPriceProduct = 0;
            foreach ($products as $key => $product) {
                $product_variants = Product_variant::where('product_id', $product->id)->get();
                if ($product_variants) {
                    $minPriceProductVariant = 0;
                    $maxPriceProductVariant = 0;

                    foreach ($product_variants as $key => $product_variant) {
                        if ($key == 0) {
                            if ($product_variant->sale_price != '') {
                                $minPriceProductVariant = $product_variant->sale_price;
                                $maxPriceProductVariant = $product_variant->sale_price;
                            } else {
                                $minPriceProductVariant = $product_variant->regular_price;
                                $maxPriceProductVariant = $product_variant->regular_price;
                            }
                        } else {
                            if ($product_variant->sale_price != '' && $product_variant->sale_price < $minPriceProductVariant) {
                                $minPriceProductVariant = $product_variant->sale_price;
                            } elseif ($product_variant->sale_price != '' && $product_variant->sale_price > $maxPriceProductVariant) {
                                $maxPriceProductVariant = $product_variant->sale_price;
                            } elseif ($product_variant->sale_price == '' && $product_variant->regular_price > $maxPriceProductVariant) {
                                $maxPriceProductVariant = $product_variant->regular_price;
                            } elseif ($product_variant->sale_price == '' && $product_variant->regular_price < $minPriceProductVariant) {
                                $minPriceProductVariant = $product_variant->regular_price;
                            }
                        }
                    }
                    if ($key == 0) {
                        $minPriceProduct = $minPriceProductVariant;
                        $maxPriceProduct = $maxPriceProductVariant;
                    } else {
                        if ($minPriceProduct != 0 && $minPriceProduct > $minPriceProductVariant) {
                            $minPriceProduct = $minPriceProductVariant;
                        }
                        if ($maxPriceProduct != 0 && $maxPriceProduct < $maxPriceProductVariant) {
                            $maxPriceProduct = $maxPriceProductVariant;
                        }
                    }
                }
            }
            $response = [
                'status' => 200,
                'message' => 'Get min max price product successfully!',
                'data' => [
                    'minPrice' => $minPriceProduct,
                    'maxPrice' => $maxPriceProduct
                ]
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => 400,
                'message' => 'Get min max price product error!',
            ];
            return response()->json($response);
        }
    }

    public function filterProduct(Request $request)
    {
        $query = Product::with(['product_variants', 'product_files'])
            ->leftJoin('product_files', function ($join) {
                $join->on('product_files.product_id', '=', 'products.id')
                    ->where('product_files.is_default', 1)
                    ->where('product_files.file_type', 'image');
            })
            ->where('products.is_active', 1)
            ->select('products.*', 'product_files.file_name as image');

        if ($request->has('color') && $request->color != '') {
            $query->whereHas('product_files', function ($query) use ($request) {
                $query->where('value', $request->color); // Lọc theo màu
            });
        }

        // Lọc theo tên sản phẩm nếu có
        if ($request->has('name') && $request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Lọc theo danh mục nếu có
        if ($request->has('categories') && $request->categories) {
            $categoryIds = explode(',', $request->categories);
            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds);
            });
        }

        // Lọc theo thương hiệu nếu có
        if ($request->has('brands') && $request->brands) {
            $brandIds = explode(',', $request->brands);
            $query->whereIn('brand_id', $brandIds);
        }

        // Lọc theo khoảng giá
        if ($request->has('min_price') || $request->has('max_price')) {
            $minPrice = $request->min_price;
            $maxPrice = $request->max_price;

            $query->whereHas('product_variants', function ($q) use ($minPrice, $maxPrice) {
                if ($minPrice) {
                    $q->where('sale_price', '>=', $minPrice)
                        ->orWhere('regular_price', '>=', $minPrice);
                }
                if ($maxPrice) {
                    $q->where('sale_price', '<=', $maxPrice)
                        ->orWhere('regular_price', '<=', $maxPrice);
                }
            });
        }

        $products = $query->get()->map(function ($product) {
            // Kiểm tra xem sản phẩm có ảnh không, nếu có thì tạo URL
            $product->productURL = route('product.detail', ['sku' => $product->SKU]);
            if ($product->image) {
                $product->image_url = asset('uploads/products/images/' . $product->image);
            } else {
                $product->image_url = null; // Nếu không có ảnh thì để null
            }
            return $product;
        });
        list($minPriceProduct, $maxPriceProduct) = $this->calculatePriceRange($products);


        return response()->json([
            'listProduct' => $products,
            'min_price_product' => $minPriceProduct,
            'max_price_product' => $maxPriceProduct,
        ]);
    }

    private function calculatePriceRange($products)
    {


        $minPriceProduct = null;
        $maxPriceProduct = null;

        foreach ($products as $product) {
            $product_variants = $product->product_variants;
            $minVariantPrice = null;
            $maxVariantPrice = null;

            foreach ($product_variants as $variant) {
                $variantPrice = $variant->sale_price ? $variant->sale_price : $variant->regular_price;

                $minVariantPrice = $minVariantPrice === null ? $variantPrice : min($minVariantPrice, $variantPrice);
                $maxVariantPrice = $maxVariantPrice === null ? $variantPrice : max($maxVariantPrice, $variantPrice);
            }
            // Cập nhật giá min/max của sản phẩm
            $minPriceProduct = $minPriceProduct === null ? $minVariantPrice : min($minPriceProduct, $minVariantPrice);
            $maxPriceProduct = $maxPriceProduct === null ? $maxVariantPrice : max($maxPriceProduct, $maxVariantPrice);

            // Lưu giá min/max của mỗi sản phẩm
            $product->variant_sale_price_min = $minVariantPrice;
            $product->variant_sale_price_max = $maxVariantPrice;
        }
        return [$minPriceProduct, $maxPriceProduct];
    }

    public function getAllProducts()
    {
        $products = Product::with(['product_variants', 'product_files'])
            ->leftJoin('product_files', function ($join) {
                $join->on('product_files.product_id', '=', 'products.id')
                    ->where('product_files.is_default', 1)
                    ->where('product_files.file_type', 'image');
            })
            ->where('products.is_active', 1)
            ->select('products.*', 'product_files.file_name as image')
            ->get();

        // Tính toán giá trị min và max
        list($minPriceProduct, $maxPriceProduct) = $this->calculatePriceRange($products);

        // Xử lý đường dẫn ảnh cho mỗi sản phẩm
        $products = $products->map(function ($product) {
            $product->productURL = route('product.detail', ['sku' => $product->SKU]);
            // Kiểm tra xem sản phẩm có ảnh không, nếu có thì tạo URL

            if ($product->image) {
                $product->image_url = asset('uploads/products/images/' . $product->image);
            } else {
                $product->image_url = null; // Nếu không có ảnh thì để null
            }

            return $product;
        });
        $products->map(function ($product) {
            // Lấy dữ liệu đánh giá cho sản phẩm
            $rating = $this->getProductReviewData($product);
            $product->averageRating = $rating['average_rating']; // Gán giá trị average_rating cho sản phẩm
        });

        $products = $products->map(function ($product) {
            $product->productID = route('product.detail', ['sku' => $product->SKU]);
            return $product;
        });

        return response()->json([

            'products' => $products,
            'minPrice' => $minPriceProduct,
            'maxPrice' => $maxPriceProduct,
        ]);
    }

    public function getBestSellingProducts()
    {


        $products = Product::join('product_categories', 'products.id', '=', 'product_categories.product_id')
            ->join('categories', 'product_categories.category_id', '=', 'categories.id')
            ->leftJoin('product_files', function ($join) {
                $join->on('product_files.product_id', '=', 'products.id')
                    ->where('product_files.is_default', 1)
                    ->where('product_files.file_type', 'image');
            })
            ->where('categories.fixed', 0)
            ->with(['product_files', 'product_variants'])
            ->select('products.*', 'product_files.file_name as image')
            ->get();
        // Tính toán giá trị min và max từ các sản phẩm
        list($minPriceProduct, $maxPriceProduct) = $this->calculatePriceRange($products);

        // Xử lý đường dẫn ảnh cho mỗi sản phẩm
        $products = $products->map(function ($product) {
            $product->productURL = route('product.detail', ['sku' => $product->SKU]);
            // Kiểm tra xem sản phẩm có ảnh không, nếu có thì tạo URL
            if ($product->image) {
                $product->image_url = asset('uploads/products/images/' . $product->image);
            } else {
                $product->image_url = null; // Nếu không có ảnh thì để null
            }

            return $product;
        });
        $products->map(function ($product) {
            // Lấy dữ liệu đánh giá cho sản phẩm
            $rating = $this->getProductReviewData($product);
            $product->averageRating = $rating['average_rating']; // Gán giá trị average_rating cho sản phẩm
        });

        // Trả về dữ liệu JSON
        return response()->json([
            'products' => $products,
            'minPrice' => $minPriceProduct,
            'maxPrice' => $maxPriceProduct,
        ]);
    }

    public function getNewProduct()
    {
        $products = Product::with(['product_variants', 'product_files'])
            ->leftJoin('product_files', function ($join) {
                $join->on('product_files.product_id', '=', 'products.id')
                    ->where('product_files.is_default', 1)
                    ->where('product_files.file_type', 'image');
            })
            ->where('products.is_active', 1)
            ->select('products.*', 'product_files.file_name as image')
            ->orderBy('products.created_at', 'desc')
            ->get();

        // Tính toán giá trị min và max
        list($minPriceProduct, $maxPriceProduct) = $this->calculatePriceRange($products);

        // Xử lý đường dẫn ảnh cho mỗi sản phẩm
        $products = $products->map(function ($product) {
            $product->productURL = route('product.detail', ['sku' => $product->SKU]);
            // Kiểm tra xem sản phẩm có ảnh không, nếu có thì tạo URL
            if ($product->image) {
                $product->image_url = asset('uploads/products/images/' . $product->image);
            } else {
                $product->image_url = null; // Nếu không có ảnh thì để null
            }

            return $product;
        });
        $products = $products->map(function ($product) {
            $product->productID = route('product.detail', ['sku' => $product->SKU]);
            return $product;
        });
        $products->map(function ($product) {
            // Lấy dữ liệu đánh giá cho sản phẩm
            $rating = $this->getProductReviewData($product);
            $product->averageRating = $rating['average_rating']; // Gán giá trị average_rating cho sản phẩm
        });

        return response()->json([

            'products' => $products,
            'minPrice' => $minPriceProduct,
            'maxPrice' => $maxPriceProduct,
        ]);
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
    public function getDescPriceProducts()
    {
        $products = Product::with(['product_variants', 'product_files'])
            ->leftJoin('product_files', function ($join) {
                $join->on('product_files.product_id', '=', 'products.id')
                    ->where('product_files.is_default', 1)
                    ->where('product_files.file_type', 'image');
            })
            ->where('products.is_active', 1)
            ->select('products.*', 'product_files.file_name as image')
            ->get();

        // Sắp xếp sản phẩm theo giá trị giảm dần của maxPriceProduct
        $products = $products->sortByDesc(function ($product) {
            // Lấy giá trị maxPrice từ biến thể sản phẩm (sale_price nếu có, nếu không lấy regular_price)
            $maxPriceProduct = $product->product_variants->max('sale_price') ?: $product->product_variants->max('regular_price');
            return $maxPriceProduct; // Trả về giá trị maxPriceProduct để sắp xếp
        });

        // Tính toán giá trị min và max
        list($minPriceProduct, $maxPriceProduct) = $this->calculatePriceRange($products);

        // Xử lý đường dẫn ảnh cho mỗi sản phẩm
        $products = $products->map(function ($product) {
            $product->productURL = route('product.detail', ['sku' => $product->SKU]);
            // Kiểm tra xem sản phẩm có ảnh không, nếu có thì tạo URL
            if ($product->image) {
                $product->image_url = asset('uploads/products/images/' . $product->image);
            } else {
                $product->image_url = null; // Nếu không có ảnh thì để null
            }
            return $product;
        });

        return response()->json([
            'products' => $products,
            'minPrice' => $minPriceProduct,
            'maxPrice' => $maxPriceProduct,
        ]);
    }

    public function getEscPriceProducts()
    {
        $products = Product::with(['product_variants', 'product_files'])
            ->leftJoin('product_files', function ($join) {
                $join->on('product_files.product_id', '=', 'products.id')
                    ->where('product_files.is_default', 1)
                    ->where('product_files.file_type', 'image');
            })
            ->where('products.is_active', 1)
            ->select('products.*', 'product_files.file_name as image')
            ->get();

        // Sắp xếp sản phẩm theo giá trị minPriceProduct (theo thứ tự giảm dần)
        $products = $products->sortByDesc(function ($product) {
            // Lấy giá trị minPrice từ biến thể sản phẩm
            $maxPriceProduct = $product->product_variants->max('sale_price') ?: $product->product_variants->max('regular_price');
            return $maxPriceProduct; // Trả về giá trị minPriceProduct để sắp xếp
        });

        // Tính toán giá trị min và max
        list($minPriceProduct, $maxPriceProduct) = $this->calculatePriceRange($products);

        // Xử lý đường dẫn ảnh cho mỗi sản phẩm
        $products = $products->map(function ($product) {
            $product->productURL = route('product.detail', ['sku' => $product->SKU]);
            // Kiểm tra xem sản phẩm có ảnh không, nếu có thì tạo URL
            if ($product->image) {
                $product->image_url = asset('uploads/products/images/' . $product->image);
            } else {
                $product->image_url = null; // Nếu không có ảnh thì để null
            }
            return $product;
        });

        return response()->json([
            'products' => $products,
            'minPrice' => $minPriceProduct,
            'maxPrice' => $maxPriceProduct,
        ]);
    }

    public function getProductDetails($productId)
    {
        // Lấy sản phẩm từ database
        $product = Product::with([
            'product_variants.variant_attribute_values.attribute_value.attribute',
            'product_files'
        ])->findOrFail($productId);

        // Chuẩn bị dữ liệu cần trả về
        $productDetails = [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->SKU,
            'description' => $product->description,
            'imageUrl' => asset('uploads/products/images/' . $product->product_files->first()->file_name), // Ảnh sản phẩm chính
            'relatedImages' => $product->product_files->map(function ($file) {
                return asset('uploads/products/images/' . $file->file_name);
            })->toArray(),
            'array_variants' => $product->product_variants->map(function ($variant) {
                return [
                    'variant_id' => $variant->id,
                    'regular_price' => $variant->regular_price,
                    'sale_price' => $variant->sale_price,
                    'stock' => $variant->stock,
                    'is_active' => $variant->is_active,
                    'attribute_values' => $variant->variant_attribute_values->pluck('attribute_value_id')->toArray()
                ];
            })->toArray(),

            $attribute_value_ids = $product->product_variants
                ->pluck('variant_attribute_values.*.attribute_value_id')
                ->flatten()
                ->unique()
                ->toArray(),

            $attribute_ids = Attribute_value::whereIn('id', $attribute_value_ids)
                ->pluck('attribute_id')
                ->unique()
                ->sort()
                ->toArray(),

            'array_attributes' => Attribute::with([
                'attribute_values' => function ($query) use ($attribute_value_ids) {
                    $query->whereIn('id', $attribute_value_ids);
                },
                'attribute_type' // Lấy thông tin loại thuộc tính
            ])->whereIn('id', $attribute_ids)->get()->mapWithKeys(function ($attribute) {
                return [
                    $attribute->id => [
                        'id' => $attribute->id,
                        'name' => $attribute->name,
                        'type' => $attribute->attribute_type ? $attribute->attribute_type->type_name : null, // Lấy tên loại thuộc tính
                        'attribute_values' => $attribute->attribute_values->sortBy(function ($value) {
                            // Sắp xếp theo thứ tự "S", "M", "L", "XL", nếu giá trị khác số
                            $sizes = ['S' => 1, 'M' => 2, 'L' => 3, 'XL' => 4, 'XXL' => 5];
                            return $sizes[$value->name] ?? $value->name; // Sắp xếp theo thứ tự định trước hoặc theo tên
                        })->values()->map(function ($value) {
                            return [
                                'id' => $value->id,
                                'name' => $value->name,
                                'value' => $value->value
                            ];
                        })->toArray()
                    ]
                ];
            })->toArray(),

        ];

        // Trả về dữ liệu sản phẩm dưới dạng JSON
        return response()->json($productDetails);
    }
    public function addToCart(Request $request)
    {
        // Xác định các dữ liệu cần thiết từ request
        $variant_id = $request->input('variant_id');
        $quantity = $request->input('quantity', 1); // Mặc định số lượng là 1 nếu không có

        // Kiểm tra nếu không có variant_id
        if (!$variant_id) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ.',
            ], 400); // Trả về mã lỗi 400
        }

        // Kiểm tra thông tin biến thể sản phẩm
        $variant = Product_variant::find($variant_id);
        if (!$variant) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại.',
            ], 404); // Trả về mã lỗi 404
        }

        // Kiểm tra tồn kho
        $cartItem = Cart::where('product_variant_id', $variant_id)
            ->where('user_id', auth()->id())
            ->first();

        $currentQuantityInCart = $cartItem ? $cartItem->quantity : 0;
        $totalRequestedQuantity = $currentQuantityInCart + $quantity;

        if ($totalRequestedQuantity > $variant->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng đã đạt giới hạn số lượng.',
            ], 400); // Trả về mã lỗi 400
        }

        // Xử lý thêm vào giỏ hàng
        if ($cartItem) {
            // Nếu sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm sản phẩm mới vào giỏ hàng
            Cart::create([
                'product_variant_id' => $variant_id,
                'user_id' => auth()->id(),
                'quantity' => $quantity,
            ]);
        }

        // Lấy tổng số sản phẩm trong giỏ hàng
        $cartCount = Cart::where('user_id', Auth::id())->count();

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng.',
            'cartCount' => $cartCount
        ]);
    }
    private function getProductReviewData($product)
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
    public function getColor() {}
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
