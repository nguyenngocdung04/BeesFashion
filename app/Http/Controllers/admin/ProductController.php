<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Attribute_value;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Import_history;
use App\Models\Order_detail;
use App\Models\Product;
use App\Models\Product_category;
use App\Models\Product_file;
use App\Models\Product_variant;
use App\Models\Product_variant_attribute_value;
use App\Models\Product_vote;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function returnRedirectRouteWithMessage($routeName, $parameter = '', $messageType, $messageContent)
    {
        return redirect()->route($routeName, $parameter)->with($messageType, $messageContent);
    }
    function convertToSlug($str)
    {
        // Loại bỏ dấu và chuyển thành chữ thường
        $str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);  // Loại bỏ dấu

        // Thay thế các ký tự không phải chữ và số thành dấu "-"
        $str = preg_replace('/[^a-zA-Z0-9]+/', '-', $str);

        // Chuyển chuỗi thành chữ thường
        $str = strtolower($str);

        // Loại bỏ dấu "-" thừa ở đầu và cuối chuỗi
        $str = trim($str, '-');

        return $str;
    }
    public function index()
    {
        $listProducts = Product::with(['product_variants.order_details.order.status_orders', 'product_files'])
            ->select('products.*')
            ->selectRaw('(
            SELECT COALESCE(SUM(od.quantity), 0) 
            FROM order_details od 
            INNER JOIN product_variants pv ON od.product_variant_id = pv.id 
            INNER JOIN orders o ON od.order_id = o.id
            INNER JOIN status_orders so ON o.id = so.order_id
            WHERE pv.product_id = products.id
            AND so.status_id = 3
        ) as total_sold')
            ->where('is_active', 1)
            ->selectRaw('(
            SELECT file_name 
            FROM product_files 
            WHERE is_default=1 and product_id=products.id
            ) as mainImage')
            ->withCount('product_variants')
            ->having('product_variants_count', '>', 0)
            ->orderBy('products.created_at', 'desc')
            ->get();
        // ==================================
        return view('admin.products.index', compact('listProducts'));
    }
    public function inactive()
    {
        $listProducts = Product::with(['product_variants.order_details.order.status_orders', 'product_files'])
            ->select('products.*')
            ->selectRaw('(
            SELECT COALESCE(SUM(od.quantity), 0) 
            FROM order_details od 
            INNER JOIN product_variants pv ON od.product_variant_id = pv.id 
            INNER JOIN orders o ON od.order_id = o.id
            INNER JOIN status_orders so ON o.id = so.order_id
            WHERE pv.product_id = products.id
            AND so.status_id = 3
        ) as total_sold')
            ->selectRaw('(
            SELECT file_name 
            FROM product_files 
            WHERE is_default=1 and product_id=products.id
            ) as mainImage')
            ->where('is_active', 0)
            ->withCount('product_variants')
            ->having('product_variants_count', '>', 0)
            ->orderBy('products.created_at', 'desc')
            ->get();
        // ==================================
        return view('admin.products.index', compact('listProducts'));
    }
    public function changeStatusProduct(Request $request)
    {
        $productId = $request['id'];
        $checkProduct = Product::find($productId);
        if ($checkProduct) {
            $checkProduct->is_active = $checkProduct->is_active == 1 ? 0 : 1;
            $checkProduct->save();
            if ($checkProduct->is_active == 1) {
                return $this->returnRedirectRouteWithMessage('admin.products.index.inactive', '', 'statusSuccess', 'Thay đổi trạng thái thành công!');
            } else {
                return $this->returnRedirectRouteWithMessage('admin.products.index', '', 'statusSuccess', 'Thay đổi trạng thái thành công!');
            }
        } else {
            return $this->returnRedirectRouteWithMessage('admin.products.index', '', 'statusError', 'Không tìm thấy sản phẩm cần thay đổi trạng thái!');
        }
    }
    public function changeStatusProductVariant(Request $request)
    {
        $productVariantId = $request['id'];
        $checkProductVariant = Product_variant::find($productVariantId);
        if ($checkProductVariant) {
            $checkProductVariant->is_active = $checkProductVariant->is_active == 1 ? 0 : 1;
            $checkProductVariant->save();
            if ($checkProductVariant->is_active == 1) {
                return $this->returnRedirectRouteWithMessage('admin.products.show', $checkProductVariant->product_id, 'statusSuccess', 'Thay đổi trạng thái thành công!');
            } else {
                return $this->returnRedirectRouteWithMessage('admin.products.show', $checkProductVariant->product_id, 'statusSuccess', 'Thay đổi trạng thái thành công!');
            }
        } else {
            return $this->returnRedirectRouteWithMessage('admin.products.show', $checkProductVariant->product_id, 'statusError', 'Không tìm thấy biến thể cần thay đổi trạng thái!');
        }
    }
    public function importingGoods()
    {
        $product_variant_id = request()->input('product_variant_id');
        $quantity = request()->input('quantity');
        $import_price = request()->input('import_price');
        $check_product_variant_by_id = Product_variant::find($product_variant_id);
        if ($check_product_variant_by_id) {
            $importing_good = Import_history::create([
                'quantity' => $quantity,
                'import_price' => $import_price,
                'product_variant_id' => $product_variant_id,
                'user_id' => Auth::check() ? Auth::user()->id : null
            ]);
            if ($importing_good) {
                $check_product_variant_by_id->stock += $quantity;
                $check_product_variant_by_id->save();
                $response = [
                    'status' => 200,
                    'message' => 'Nhập hàng thành công!'
                ];
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Có lỗi khi nhập hàng, vui lòng thử lại!'
                ];
            }
        } else {
            $response = [
                'status' => 404,
                'message' => 'Không tìm thấy biến thể cần nhập thêm hàng!'
            ];
        }
        return response()->json($response);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $baseInformation = $request->input('baseInformation');
            $sku = $baseInformation['sku'] ?? null;
            $check_exist = Product::where('SKU', $sku)->first();
            if ($check_exist) {
                $response = [
                    'status' => 400,
                    'message' => 'Mã sản phẩm đã tồn tại!',
                ];
                return response()->json($response);
            }
            $name = $baseInformation['name'] ?? null;
            $description = $baseInformation['description'] ?? null;
            $status = $baseInformation['status'] ?? null;
            $status = $status == "true" ? 1 : 0;
            $brandId = $request->input('brandId');

            if ($sku && $name && $description) {
                $newProduct = Product::create([
                    'SKU' => $sku,
                    'name' => $name,
                    'description' => $description,
                    'brand_id' => $brandId ? $brandId : null,
                    'is_active' => $status
                ]);
                if ($request->hasFile('mainImage')) {
                    $mainImage = $request->file('mainImage');
                    $mainImageNameHashed = $mainImage->hashName();
                    $mainImage->move(public_path('uploads/products/images/'), $mainImageNameHashed);
                    if ($mainImage) {
                        Product_file::create([
                            'file_name' => $mainImageNameHashed,
                            'file_type' => 'image',
                            'is_default' => 1,
                            'product_id' => $newProduct->id
                        ]);
                    }
                }
                // 3. Lấy các hình ảnh khác (images)
                $imagesPaths = [];
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        $imageHashed = $image->hashName();
                        $image->move(public_path('uploads/products/images/'), $imageHashed);
                        $imagesPaths[] = $imageHashed;
                    }
                }
                if (!empty($imagesPaths)) {
                    foreach ($imagesPaths as $imagePath) {
                        Product_file::create([
                            'file_name' => $imagePath,
                            'file_type' => 'image',
                            'product_id' => $newProduct->id
                        ]);
                    }
                }
                // 4. Lấy các video
                $videosPaths = [];
                if ($request->hasFile('videos')) {
                    foreach ($request->file('videos') as $video) {
                        $videoHashed = $video->hashName();
                        $video->move(public_path('uploads/products/videos/'), $videoHashed);
                        $videosPaths[] = $videoHashed;
                    }
                }
                if (!empty($videosPaths)) {
                    foreach ($videosPaths as $videoPath) {
                        Product_file::create([
                            'file_name' => $videoPath,
                            'file_type' => 'video',
                            'product_id' => $newProduct->id
                        ]);
                    }
                }
                // 5. Lấy các ID của danh mục đã chọn
                $categoriesId = $request->input('categoriesId', []);
                if (!empty($categoriesId)) {
                    foreach ($categoriesId as $item) {
                        Product_category::create([
                            'product_id' => $newProduct->id,
                            'category_id' => $item
                        ]);
                    }
                }

                if ($request->has('variations') && is_array($request->input('variations'))) {
                    // Nếu là mảng, gán nó vào biến
                    $variations = $request->input('variations');
                } else {
                    // Nếu không, thử decode từ JSON (nếu cần)
                    $variations = json_decode($request->input('variations'), true);
                }
                $attributeData = [];
                foreach ($variations as $index => $item) {
                    $skuVariation = $request->input("variations.$index.sku");
                    $nameVariation = $request->input("variations.$index.name");
                    $skuVariation = $skuVariation != '' ? $skuVariation : $newProduct->SKU . '-' . $this->convertToSlug($nameVariation);
                    $importPriceVariation = $request->input("variations.$index.import_price");
                    $regularPriceVariation = $request->input("variations.$index.regular_price");
                    $salePriceVariation = $request->input("variations.$index.sale_price");
                    $stockVariation = $request->input("variations.$index.stock");
                    $activeVariation = $request->input("variations.$index.active") == "true" ? 1 : 0;

                    // Kiểm tra và lưu ảnh biến thể nếu tồn tại
                    $imageNameHashed = null;
                    if ($request->hasFile("variations.$index.image_data")) {
                        $imageVariation = $request->file("variations.$index.image_data");
                        $imageNameHashed = $imageVariation->hashName();
                        $imageVariation->move(public_path('uploads/products/images/'), $imageNameHashed);
                    } else {
                        $imageNameHashed = $mainImageNameHashed;
                    }

                    // Tạo mới Product_variant
                    $newProductVariation = Product_variant::create([
                        'SKU' => $skuVariation,
                        'name' => $nameVariation,
                        'image' => $imageNameHashed,
                        'regular_price' => $regularPriceVariation,
                        'sale_price' => $salePriceVariation,
                        'stock' => $stockVariation,
                        'product_id' => $newProduct->id,
                        'is_active' => $activeVariation
                    ]);

                    // Thêm vào bảng Import_history
                    Import_history::create([
                        'quantity' => $stockVariation,
                        'import_price' => $importPriceVariation,
                        'product_variant_id' => $newProductVariation->id,
                        'user_id' => Auth::check() ? Auth::user()->id : null
                    ]);

                    // Xử lý dữ liệu variationAttributeData
                    $variationAttributeData = $request->input("variations.$index.variationAttributeData");
                    foreach ($variationAttributeData as $attributeItem) {
                        if (!empty($attributeItem['attributeId'])) {
                            if (!empty($attributeItem['attributeValueId'])) {
                                $checkAttributeValueId = Attribute_value::find($attributeItem['attributeValueId']);
                                if ($checkAttributeValueId) {
                                    Product_variant_attribute_value::create([
                                        'product_variant_id' => $newProductVariation->id,
                                        'attribute_value_id' => $attributeItem['attributeValueId']
                                    ]);
                                }
                            }
                        } else {
                            if ($attributeItem['attributeValue'] && $attributeItem['attributeValue'] != '') {
                                $checkAttribute = false;
                                foreach ($attributeData as $itemAttributeData) {
                                    //Kiểm tra xem thuộc tính hiện tại đã được tạo trong cơ sở dữ liệu chưa
                                    if ($itemAttributeData['attributeName'] == $attributeItem['attributeName']) {
                                        //Nếu đã tồn tại trong cơ sở dữ liệu thì tìm kiếm giá trị thuộc tính hiện tại của nó đã được tạo trong db chưa
                                        $findAttributeValue = Attribute_value::where('name', $attributeItem['attributeValue'])
                                            ->where('attribute_id', $itemAttributeData['attributeId'])->first();
                                        //Nếu đã đc tạo trong db rồi thì tạo một bản ghi ở bảng 'product_variant_attribute_values'
                                        if ($findAttributeValue) {
                                            Product_variant_attribute_value::create([
                                                'product_variant_id' => $newProductVariation->id,
                                                'attribute_value_id' => $findAttributeValue->id
                                            ]);
                                        } else {
                                            //Nếu giá trị thuộc tính này chưa tồn tại trong thuộc tính hiện tại thì tạo mới nó và thêm 1 bản ghi ở bảng 'product_variant_attribute_values'
                                            $newAttributeValue = Attribute_value::create([
                                                'name' => $attributeItem['attributeValue'],
                                                'attribute_id' => $itemAttributeData['attributeId']
                                            ]);
                                            Product_variant_attribute_value::create([
                                                'product_variant_id' => $newProductVariation->id,
                                                'attribute_value_id' => $newAttributeValue->id
                                            ]);
                                        }
                                        $checkAttribute = true;
                                        break;
                                    }
                                }
                                if (!$checkAttribute) {
                                    $newAttribute = Attribute::create([
                                        'name' => $attributeItem['attributeName']
                                    ]);
                                    $newAttributeValue = Attribute_value::create([
                                        'name' => $attributeItem['attributeValue'],
                                        'attribute_id' => $newAttribute->id
                                    ]);

                                    $attributeData[] = [
                                        'attributeId' => $newAttribute->id,
                                        'attributeName' => $newAttribute->name
                                    ];

                                    Product_variant_attribute_value::create([
                                        'product_variant_id' => $newProductVariation->id,
                                        'attribute_value_id' => $newAttributeValue->id
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
            $response = [
                'status' => 200,
                'message' => 'Tạo mới sản phẩm thành công!',
            ];
        } catch (Exception $e) {
            // Xử lý khi có lỗi
            $response = [
                'status' => 400,
                'message' => 'Có lỗi xảy ra!',
                'error' => $e->getMessage()
            ];
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productDetail = Product::with([
            'product_variants.order_details.order.status_orders',
            'product_gallery',
            'product_videos'
        ])
            ->select('products.*')
            ->selectRaw('(
                SELECT COALESCE(SUM(od.quantity), 0) 
                FROM order_details od 
                INNER JOIN product_variants pv ON od.product_variant_id = pv.id 
                INNER JOIN orders o ON od.order_id = o.id
                INNER JOIN status_orders so ON o.id = so.order_id
                WHERE pv.product_id = products.id
                AND so.status_id = 3
            ) as total_sold')
            ->selectRaw('(
                SELECT file_name 
                FROM product_files 
                WHERE is_default=1 and product_id=products.id
            ) as mainImage')
            ->where('id', $id)
            ->withCount('product_variants')
            ->having('product_variants_count', '>', 0)
            ->first();
        $productVariants = Product_variant::with('order_details.order.status_orders')
            ->select('product_variants.*')
            ->selectRaw('(
                SELECT COALESCE(SUM(od.quantity), 0) 
                FROM order_details od 
                INNER JOIN orders o ON od.order_id = o.id
                INNER JOIN status_orders so ON o.id = so.order_id
                WHERE od.product_variant_id = product_variants.id
                AND so.status_id = 3
            ) as total_sold')
            ->where('product_variants.product_id', $id)
            ->get();
        if ($productVariants) {
            $starRatingOfMultipleProductVariants = 0;
            $variantVoted = 0;
            foreach ($productVariants as $variant) {
                $totalProfitPerItem = 0;
                $import_histories = Import_history::where('product_variant_id', $variant->id)->orderBy('created_at', 'asc')->get();
                if ($import_histories) {
                    foreach ($import_histories as $key => $history) {
                        $totalProfitPerTime = 0;
                        $currentTime = $history->created_at;
                        $nextTime = isset($import_histories[$key + 1]) ? $import_histories[$key + 1]->created_at : Carbon::now('Asia/Ho_Chi_Minh');
                        $order_details = Order_detail::with('order.status_orders')
                            ->whereHas('order.status_orders', function ($query) {
                                $query->where('status_id', 3);
                            })
                            ->where('product_variant_id', $variant->id)
                            ->where('created_at', '>=', $currentTime)
                            ->where('created_at', '<', $nextTime)
                            ->get();
                        if ($order_details) {
                            foreach ($order_details as $key => $order_detail) {
                                $totalProfitPerTime += ($order_detail->original_price - $history->import_price) * $order_detail->quantity;
                            }
                        }
                        $totalProfitPerItem += $totalProfitPerTime;
                    }
                }
                $variant->total_profit = $totalProfitPerItem;

                //Get star
                $productVotes = Product_vote::where('product_variant_id', $variant->id)->get();
                if ($productVotes->count() > 0) {
                    $starRatingPerProductVariant = 0;
                    $productVote = 0;
                    foreach ($productVotes as $voteItem) {
                        $productVote += $voteItem->star;
                    }
                    $starRatingPerProductVariant = $productVote / $productVotes->count();
                    $starRatingOfMultipleProductVariants += $starRatingPerProductVariant;
                    $variantVoted++;
                }
            }
            if ($variantVoted > 0) {
                $starRatingOfMultipleProductVariants /= $variantVoted;
            }
            $productStar = $starRatingOfMultipleProductVariants > 0 ? $starRatingOfMultipleProductVariants : 0;
            // dd($starRatingOfMultipleProductVariants);
        }
        if ($productDetail->product_variants) {
            $totalProfit = 0;
            foreach ($productDetail->product_variants as $variant) {
                $totalProfitPerItem = 0;
                $import_histories = Import_history::where('product_variant_id', $variant->id)->orderBy('created_at', 'asc')->get();
                if ($import_histories) {
                    foreach ($import_histories as $key => $history) {
                        $totalProfitPerTime = 0;
                        $currentTime = $history->created_at;
                        $nextTime = isset($import_histories[$key + 1]) ? $import_histories[$key + 1]->created_at : Carbon::now('Asia/Ho_Chi_Minh');
                        $order_details = Order_detail::with('order.status_orders')
                            ->whereHas('order.status_orders', function ($query) {
                                $query->where('status_id', 3);
                            })
                            ->where('product_variant_id', $variant->id)
                            ->where('created_at', '>=', $currentTime)
                            ->where('created_at', '<', $nextTime)
                            ->get();
                        if ($order_details) {
                            foreach ($order_details as $key => $order_detail) {
                                $totalProfitPerTime += ($order_detail->original_price - $history->import_price) * $order_detail->quantity;
                            }
                        }
                        $totalProfitPerItem += $totalProfitPerTime;
                    }
                }
                $totalProfit += $totalProfitPerItem;
            }
            if ($productDetail) {
                return view('admin.products.show', compact('productDetail', 'productVariants', 'totalProfit', 'productStar', 'variantVoted'));
            } else {
                return $this->returnRedirectRouteWithMessage('admin.products.index', '', 'statusError', 'Không tìm thấy sản phẩm cần xem chi tiết!');
            }
        } else {
            return $this->returnRedirectRouteWithMessage('admin.products.index', '', 'statusError', 'Sản phẩm chi tiết này không có biến thể, đây là sản phẩm lỗi!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $checkProduct = Product::find($id);
        if ($checkProduct) {
            return view('admin.products.edit', compact('id'));
        } else {
            return $this->returnRedirectRouteWithMessage('admin.products.index', '', 'statusError', 'Không tìm thấy sản phẩm cần sửa!');
        }
    }
    public function getOldProductData()
    {
        $product_id = request()->input('product_id');
        $product = Product::find($product_id);
        $data = [];
        if ($product) {
            //Lấy ảnh chính
            $mainImage = Product_file::where('product_id', $product_id)
                ->where('is_default', 1)
                ->first();
            //Lấy thư viện ảnh
            $photoGallery = Product_file::where('product_id', $product_id)
                ->where('file_type', 'image')
                ->where('is_default', 0)
                ->get();
            //Lấy thư viện video
            $videos = Product_file::where('product_id', $product_id)
                ->where('file_type', 'video')
                ->where('is_default', 0)
                ->get();
            //Tạo mảng lưu trữ dữ liêu cơ bản của sp
            $baseInformation = [];
            $baseInformation['id'] = $product->id;
            $baseInformation['sku'] = $product->SKU;
            $baseInformation['name'] = $product->name;
            $baseInformation['description'] = $product->description;
            $baseInformation['brand_id'] = $product->brand_id;
            $baseInformation['is_active'] = $product->is_active;
            $baseInformation['main_image']['id'] = $mainImage->id;
            $baseInformation['main_image']['name'] = $mainImage->file_name;
            $baseInformation['photo_gallery'] = [];
            if ($photoGallery) {
                foreach ($photoGallery as $photo) {
                    $item_photo_gallery = [];
                    $item_photo_gallery['id'] = $photo->id;
                    $item_photo_gallery['name'] = $photo->file_name;
                    $baseInformation['photo_gallery'][] = $item_photo_gallery;
                }
            }
            if ($videos) {
                foreach ($videos as $video) {
                    $item_video = [];
                    $item_video['id'] = $video->id;
                    $item_video['name'] = $video->file_name;
                    $baseInformation['videos'][] = $item_video;
                }
            }
            //Lấy id danh mục
            $getCategoryIds = Product_category::where('product_id', $product_id)->get();
            $categoryIds = [];
            if ($getCategoryIds) {
                foreach ($getCategoryIds as $categoryId) {
                    $categoryIds[] = $categoryId->category_id;
                }
            }
            //Lấy tất cả biến thể
            $getVariants = Product_variant::where('product_id', $product_id)->get();
            //Lấy thuộc tính và giá trị thuộc tính
            $variations = [];
            $array_attribute_value_id = [];
            $array_attribute_id = [];
            $array_attributes = [];
            $attribute_value_ids = Product_variant::leftJoin('products as p', 'product_variants.product_id', '=', 'p.id')
                ->leftJoin('product_variant_attribute_values as pvv', 'product_variants.id', '=', 'pvv.product_variant_id')
                ->select('pvv.attribute_value_id as attribute_value_id')
                ->where('p.id', $product_id)
                ->groupBy('attribute_value_id')
                ->get();
            foreach ($attribute_value_ids as $attribute_value_id) {
                if ($attribute_value_id->attribute_value_id != null) {
                    $array_attribute_value_id[] = $attribute_value_id->attribute_value_id;
                }
            }
            foreach ($array_attribute_value_id as $attribute_value_id) {
                $attribute_id = Attribute_value::find($attribute_value_id)->attribute_id;
                // dd($attributes);
                if ($attribute_id) {
                    if (!in_array($attribute_id, $array_attribute_id)) {
                        $array_attribute_id[] = $attribute_id;
                    }
                }
            }
            sort($array_attribute_id);
            foreach ($array_attribute_id as $attribute_id) {
                $data_attribute = Attribute::with('attribute_values')->where('id', $attribute_id)->first();
                $array_attributes[$attribute_id] = [
                    'id' => $data_attribute->id,
                    'name' => $data_attribute->name,
                    'attribute_values' => $data_attribute->attribute_values->map(function ($value) {
                        return [
                            'id' => $value->id,
                            'name' => $value->name
                        ];
                    })->toArray()
                ];
                foreach ($array_attributes[$attribute_id]['attribute_values'] as $key => $attribute_value) {
                    if (!in_array($attribute_value['id'], $array_attribute_value_id)) {
                        unset($array_attributes[$attribute_id]['attribute_values'][$key]);
                    }
                }
            }
            if ($getVariants) {
                foreach ($getVariants as $variant) {
                    $getImportPrice = Import_history::where('product_variant_id', $variant->id)
                        ->latest()
                        ->first()
                        ->import_price;
                    $variation = [];
                    $variation['id'] = $variant->id;
                    $variation['sku'] = $variant->SKU;
                    $variation['name'] = $variant->name;
                    $variation['image'] = $variant->image;
                    $variation['import_price'] = $getImportPrice;
                    $variation['regular_price'] = $variant->regular_price;
                    $variation['sale_price'] = $variant->sale_price;
                    $variation['stock'] = $variant->stock;
                    $variation['is_active'] = $variant->is_active;

                    $product_variant_attributes = [];
                    $get_attribute_value_ids_of_variant = Product_variant_attribute_value::select('attribute_value_id')->where('product_variant_id', $variant->id)->get();

                    if ($get_attribute_value_ids_of_variant) {
                        foreach ($get_attribute_value_ids_of_variant as $attribute_value_id) {
                            $item = [];
                            $attribute_value = Attribute_value::select('attribute_id', 'name')->find($attribute_value_id->attribute_value_id);
                            if ($attribute_value) {
                                $attribute_name = Attribute::select('name')->find($attribute_value->attribute_id)->name;
                                $item['attribute_id'] = $attribute_value->attribute_id;
                                $item['attribute_name'] = $attribute_name;
                                $item['attribute_value_id'] = $attribute_value_id->attribute_value_id;
                                $item['attribute_value_name'] = $attribute_value->name;
                                $product_variant_attributes[] = $item;
                            }
                        }
                        $variation['variant_attribute'] = $product_variant_attributes;
                        $variations[] = $variation;
                    }
                }
            }
            //Gán dữ liệu lẻ tẻ vào mảng lưu trữ dữ liệu tổng
            $data['base_information'] = $baseInformation;
            $data['category_ids'] = $categoryIds;
            $data['variations'] = $variations;
            $data['attributes'] = $array_attributes;
            //Tạo phản hổi để gửi về ajax
            $response = [
                'status' => 200,
                'message' => 'Lấy dữ liệu sản phẩm cũ thành công!',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'Không tìm thấy sản phẩm!',
            ];
        }
        return response()->json($response);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $mainImageOld = null;
            $product_id = $id;
            $old_product = Product::find($product_id);
            if ($old_product) {
                $baseInformation = $request->input('baseInformation');
                $sku = $baseInformation['sku'] ?? null;
                $name = $baseInformation['name'] ?? null;
                $description = $baseInformation['description'] ?? null;
                $status = $baseInformation['status'] ?? null;
                $status = $status == "true" ? 1 : 0;
                $brandId = $request->input('brandId');

                if ($sku && $name && $description) {
                    $old_product->update([
                        'SKU' => $sku,
                        'name' => $name,
                        'description' => $description,
                        'brand_id' => $brandId ?: null,
                        'is_active' => $status
                    ]);

                    if ($request->hasFile('mainImage')) {
                        $old_main_image = Product_file::where('product_id', $product_id)
                            ->where('is_default', 1)
                            ->where('file_type', 'image')
                            ->first();
                        if ($old_main_image) {
                            $file_name = $old_main_image->file_name;
                            $existingFile = public_path('uploads/products/images/') . $file_name;
                            if ($file_name && file_exists($existingFile)) {
                                unlink($existingFile);
                            }

                            $old_main_image->delete();
                            $mainImage = $request->file('mainImage');

                            $mainImageNameHashed = $mainImage->hashName();
                            $mainImage->move(public_path('uploads/products/images/'), $mainImageNameHashed);
                            if ($mainImage) {
                                Product_file::create([
                                    'file_name' => $mainImageNameHashed,
                                    'file_type' => 'image',
                                    'is_default' => 1,
                                    'product_id' => $product_id
                                ]);
                            }
                        }
                    } else {
                        $old_main_image = Product_file::where('product_id', $product_id)
                            ->where('is_default', 1)
                            ->where('file_type', 'image')
                            ->first();
                        if ($old_main_image) {
                            $mainImageOld = $old_main_image->file_name;
                        }
                    }
                    // 3. Xử lý các hình ảnh khác (images)

                    $oldPhotoGalleryIds = $request->input('oldPhotoGalleryIds', []);

                    $oldPhotoGalleryIds = !empty($oldPhotoGalleryIds) ?
                        array_map('intval', explode(',', $oldPhotoGalleryIds)) :
                        [];
                    $old_photo_gallery = Product_file::where('product_id', $product_id)
                        ->where('is_default', 0)
                        ->where('file_type', 'image')
                        ->get();
                    foreach ($old_photo_gallery as $oldPhoto) {
                        if (!in_array($oldPhoto->id, $oldPhotoGalleryIds)) {
                            $existingFile = public_path('uploads/products/images/') . $oldPhoto->file_name;
                            if ($oldPhoto->file_name && file_exists($existingFile)) {
                                unlink($existingFile);
                            }
                            $oldPhoto->delete();
                        }
                    }

                    if ($request->hasFile('images')) {
                        $files = $request->file('images');
                        foreach ($files as $file) {
                            $imageHashed = $file->hashName();
                            $file->move(public_path('uploads/products/images/'), $imageHashed);
                            Product_file::create([
                                'file_name' => $imageHashed,
                                'file_type' => 'image',
                                'product_id' => $product_id
                            ]);
                        }
                    }
                    // 4. Xử lý các video
                    $oldVideoIds = $request->input('oldVideoIds', []);
                    $oldVideoIds = !empty($oldVideoIds) ?
                        array_map('intval', explode(',', $oldVideoIds)) :
                        [];

                    $old_videos = Product_file::where('product_id', $product_id)
                        ->where('file_type', 'video')
                        ->get();

                    foreach ($old_videos as $old_video) {
                        if (!in_array($old_video->id, $oldVideoIds)) {
                            $existingFile = public_path('uploads/products/videos/') . $old_video->file_name;
                            if ($old_video->file_name && file_exists($existingFile)) {
                                unlink($existingFile);
                            }
                            $old_video->delete();
                        }
                    }


                    if ($request->hasFile('videos')) {
                        foreach ($request->file('videos') as $video) {
                            $videoHashed = $video->hashName();
                            $video->move(public_path('uploads/products/videos/'), $videoHashed);
                            Product_file::create([
                                'file_name' => $videoHashed,
                                'file_type' => 'video',
                                'product_id' => $product_id
                            ]);
                        }
                    }
                    // 5. Lấy các ID của danh mục đã chọn
                    $categoriesId = $request->input('categoriesId', []);

                    if (!empty($categoriesId)) {
                        $oldCategories = Product_category::where('product_id', $product_id)->pluck('category_id')->toArray();

                        Product_category::where('product_id', $product_id)
                            ->whereNotIn('category_id', $categoriesId)
                            ->delete();

                        $newCategories = array_diff($categoriesId, $oldCategories);

                        foreach ($newCategories as $categoryId) {
                            Product_category::create([
                                'category_id' => $categoryId,
                                'product_id' => $product_id
                            ]);
                        }
                    } else {
                        $oldCategories = Product_category::where('product_id', $product_id)->get();
                        if ($oldCategories) {
                            foreach ($oldCategories as $oldCategory) {
                                $oldCategory->delete();
                            }
                        }
                    }


                    //6. Xử lý biến thể
                    if ($request->has('variations') && is_array($request->input('variations'))) {
                        // Nếu là mảng, gán nó vào biến
                        $variations = $request->input('variations');
                    } else {
                        // Nếu không, thử decode từ JSON (nếu cần)
                        $variations = json_decode($request->input('variations'), true);
                    }
                    $attributeData = [];
                    foreach ($variations as $index => $item) {
                        $importPriceVariation = $request->input("variations.$index.import_price");
                        $regularPriceVariation = $request->input("variations.$index.regular_price");
                        $salePriceVariation = $request->input("variations.$index.sale_price");
                        $stockVariation = $request->input("variations.$index.stock");
                        $activeVariation = $request->input("variations.$index.active") == 'true' ? 1 : 0;
                        if ($request->input("variations.$index.id")) {
                            $variation_id = $request->input("variations.$index.id");
                            $oldVariation = Product_variant::find($variation_id);
                            if ($oldVariation) {
                                $lastImportHistory = Import_history::where('product_variant_id', $variation_id)->latest()->first();
                                if ($lastImportHistory) {
                                    if ($lastImportHistory->import_price != $importPriceVariation) {
                                        Import_history::create([
                                            'quantity' => 0,
                                            'import_price' => $importPriceVariation,
                                            'product_variant_id' => $variation_id,
                                            'user_id' => Auth::check() ? Auth::user()->id : null
                                        ]);
                                    }
                                } else {
                                    Import_history::create([
                                        'quantity' => $stockVariation,
                                        'import_price' => $importPriceVariation,
                                        'product_variant_id' => $variation_id,
                                        'user_id' => Auth::check() ? Auth::user()->id : null
                                    ]);
                                }
                            }
                            $updateData = [
                                'regular_price' => $regularPriceVariation,
                                'sale_price' => $salePriceVariation,
                                'stock' => $stockVariation,
                                'is_active' => $activeVariation
                            ];
                            $imageNameHashed = null;
                            if ($request->hasFile("variations.$index.image_data")) {
                                $imageVariation = $request->file("variations.$index.image_data");
                                $imageNameHashed = $imageVariation->hashName();
                                $imageVariation->move(public_path('uploads/products/images/'), $imageNameHashed);
                            }
                            if ($imageNameHashed != null) {
                                $updateData['image'] = $imageNameHashed;
                                $existingFile = public_path('uploads/products/images/') . $oldVariation->image;
                                if ($oldVariation->image && file_exists($existingFile)) {
                                    unlink($existingFile);
                                }
                            }
                            $oldVariation->update($updateData);
                        } else {
                            $nameVariation = $request->input("variations.$index.name");
                            $skuVariation = $request->input("variations.$index.sku");
                            $skuVariation = $skuVariation != '' ? $skuVariation : $old_product->SKU . '-' . $this->convertToSlug($nameVariation) . $index;

                            // Kiểm tra và lưu ảnh biến thể nếu tồn tại
                            $imageNameHashed = null;
                            if ($request->hasFile("variations.$index.image_data")) {
                                $imageVariation = $request->file("variations.$index.image_data");
                                $imageNameHashed = $imageVariation->hashName();
                                $imageVariation->move(public_path('uploads/products/images/'), $imageNameHashed);
                            } else {
                                if ($request->hasFile('mainImage')) {
                                    $mainImage = $request->file('mainImage');
                                    // Tạo tên mới cho bản sao ảnh chính
                                    $mainImageExtension = $mainImage->getClientOriginalExtension(); // Lấy phần mở rộng của file
                                    $mainImageNameHashed = pathinfo($mainImage->hashName(), PATHINFO_FILENAME) . "_variant_$index." . $mainImageExtension;

                                    // Đường dẫn tạm của ảnh chính
                                    $mainImagePath = $mainImage->getRealPath();

                                    // Sao chép ảnh chính cho biến thể
                                    $destinationPath = public_path('uploads/products/images/');
                                    $imageNameHashed = $mainImageNameHashed;
                                    copy($mainImagePath, $destinationPath . $mainImageNameHashed);
                                } else {
                                    if ($mainImageOld &&  file_exists(public_path('uploads/products/images/' . $mainImageOld))) {
                                        $oldImageExtension = pathinfo($mainImageOld, PATHINFO_EXTENSION); // Lấy phần mở rộng
                                        $newImageName = pathinfo($mainImageOld, PATHINFO_FILENAME) . "_variant_$index." . $oldImageExtension;

                                        // Sao chép ảnh cũ cho biến thể
                                        $sourcePath = public_path('uploads/products/images/' . $mainImageOld);
                                        $destinationPath = public_path('uploads/products/images/' . $newImageName);
                                        copy($sourcePath, $destinationPath);

                                        // Lưu tên mới cho biến thể
                                        $imageNameHashed = $newImageName;
                                    } else {
                                        $imageNameHashed = 'default_image.jpg';
                                    }
                                }
                            }

                            // Tạo mới Product_variant
                            $newProductVariation = Product_variant::create([
                                'SKU' => $skuVariation,
                                'name' => $nameVariation,
                                'image' => $imageNameHashed,
                                'regular_price' => $regularPriceVariation,
                                'sale_price' => $salePriceVariation,
                                'stock' => $stockVariation,
                                'product_id' => $old_product->id,
                                'is_active' => $activeVariation
                            ]);

                            // Thêm vào bảng Import_history
                            Import_history::create([
                                'quantity' => $stockVariation,
                                'import_price' => $importPriceVariation,
                                'product_variant_id' => $newProductVariation->id,
                                'user_id' => Auth::check() ? Auth::user()->id : null
                            ]);

                            // Xử lý dữ liệu variationAttributeData
                            $variationAttributeData = $request->input("variations.$index.variationAttributeData");
                            foreach ($variationAttributeData as $attributeItem) {
                                if (!empty($attributeItem['attributeId'])) {
                                    if (!empty($attributeItem['attributeValueId'])) {
                                        $checkAttributeValueId = Attribute_value::find($attributeItem['attributeValueId']);
                                        if ($checkAttributeValueId) {
                                            Product_variant_attribute_value::create([
                                                'product_variant_id' => $newProductVariation->id,
                                                'attribute_value_id' => $attributeItem['attributeValueId']
                                            ]);
                                        }
                                    }
                                } else {
                                    if ($attributeItem['attributeValue'] && $attributeItem['attributeValue'] != '') {
                                        $checkAttribute = false;
                                        foreach ($attributeData as $itemAttributeData) {
                                            //Kiểm tra xem thuộc tính hiện tại đã được tạo trong cơ sở dữ liệu chưa
                                            if ($itemAttributeData['attributeName'] == $attributeItem['attributeName']) {
                                                //Nếu đã tồn tại trong cơ sở dữ liệu thì tìm kiếm giá trị thuộc tính hiện tại của nó đã được tạo trong db chưa
                                                $findAttributeValue = Attribute_value::where('name', $attributeItem['attributeValue'])
                                                    ->where('attribute_id', $itemAttributeData['attributeId'])->first();
                                                //Nếu đã đc tạo trong db rồi thì tạo một bản ghi ở bảng 'product_variant_attribute_values'
                                                if ($findAttributeValue) {
                                                    Product_variant_attribute_value::create([
                                                        'product_variant_id' => $newProductVariation->id,
                                                        'attribute_value_id' => $findAttributeValue->id
                                                    ]);
                                                } else {
                                                    //Nếu giá trị thuộc tính này chưa tồn tại trong thuộc tính hiện tại thì tạo mới nó và thêm 1 bản ghi ở bảng 'product_variant_attribute_values'
                                                    $newAttributeValue = Attribute_value::create([
                                                        'name' => $attributeItem['attributeValue'],
                                                        'attribute_id' => $itemAttributeData['attributeId']
                                                    ]);
                                                    Product_variant_attribute_value::create([
                                                        'product_variant_id' => $newProductVariation->id,
                                                        'attribute_value_id' => $newAttributeValue->id
                                                    ]);
                                                }
                                                $checkAttribute = true;
                                                break;
                                            }
                                        }
                                        if (!$checkAttribute) {
                                            $newAttribute = Attribute::create([
                                                'name' => $attributeItem['attributeName']
                                            ]);
                                            $newAttributeValue = Attribute_value::create([
                                                'name' => $attributeItem['attributeValue'],
                                                'attribute_id' => $newAttribute->id
                                            ]);

                                            $attributeData[] = [
                                                'attributeId' => $newAttribute->id,
                                                'attributeName' => $newAttribute->name
                                            ];

                                            Product_variant_attribute_value::create([
                                                'product_variant_id' => $newProductVariation->id,
                                                'attribute_value_id' => $newAttributeValue->id
                                            ]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $response = [
                    'status' => 200,
                    'message' => 'Cập nhật sản phẩm thành công!',
                    'data' => "Đã cập nhật xong!"
                ];
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Không tìm thấy sản phẩm cần sửa!',
                ];
            }
        } catch (Exception $e) {
            // Xử lý khi có lỗi
            $response = [
                'status' => 400,
                'message' => 'Có lỗi xảy ra!',
                'error' => $e->getMessage()
            ];
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getAllCategories()
    {
        $all_categories = Category::where('is_active', 1)
            ->where('fixed', 1)
            ->get();
        $categories_tree = $this->buildCategoryTree($all_categories);
        $response = [
            'status' => 200,
            'message' => 'Lấy dữ liệu thành công!',
            'data' => $categories_tree
        ];
        return response()->json($response);
    }
    public function createNewCategory()
    {
        $category_name = request()->input('category_name');
        $parent_category_id = request()->input('parent_category_id');
        $check_exist = Category::where('name', $category_name)->first();
        if ($check_exist) {
            $response = [
                'status' => 400,
                'message' => 'Danh mục đã tồn tại!',
            ];
        }
        try {
            if ($parent_category_id) {
                Category::create([
                    'name' => $category_name,
                    'parent_category_id' => $parent_category_id
                ]);
            } else {
                Category::create([
                    'name' => $category_name
                ]);
            }

            $response = [
                'status' => 200,
                'message' => 'Thêm mới danh mục thành công!',
            ];
        } catch (Exception $e) {
            // Xử lý khi có lỗi
            $response = [
                'status' => 400,
                'message' => 'Có lỗi xảy ra!',
                'error' => $e->getMessage()
            ];
        }

        // Trả về JSON response
        return response()->json($response);
    }
    public function checkCategoryById()
    {
        $category_id = request()->input('category_id');
        if ($category_id) {
            $result = Category::find($category_id);
            if ($result) {
                $response = [
                    'status' => 200,
                    'message' => 'Danh mục này hợp lệ vì không tồn tại!',
                ];
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Có lỗi xảy ra!',
                ];
            }
            return response()->json($response);
        }
    }
    public function getAllBrands()
    {
        $all_brands = Brand::where('is_active', 1)->get();
        if ($all_brands) {
            $form = [];
            foreach ($all_brands as $brand) {
                $item = [];
                $item['id'] = $brand->id;
                $item['name'] = $brand->name;
                $form[] = $item;
            }
            $response = [
                'status' => 200,
                'message' => 'Lấy dữ liệu thành công!',
                'data' => $form
            ];
        } else {
            $response = [
                'status' => 400,
                'message' => 'Không thể lấy dữ liệu!'
            ];
        }
        return response()->json($response);
    }
    public function createNewBrand()
    {
        $brand_name = request()->input('brand_name');
        $response = [];
        if ($brand_name) {
            $check_brand_name = Brand::where('name', $brand_name)->first();
            if ($check_brand_name) {
                $response = [
                    'status' => 409,
                    'message' => 'Tên thương hiệu đã tồn tại!'
                ];
                return response()->json($response);
            }
            $newBrand = Brand::create([
                'name' => $brand_name
            ]);
            if ($newBrand) {
                $response = [
                    'status' => 200,
                    'message' => 'Tạo mới thương hiệu thành công!',
                ];
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Không thể tạo mới thương hiệu!'
                ];
            }
        }
        return response()->json($response);
    }
    public function checkBrandById()
    {
        $brand_id = request()->input('brand_id');
        if ($brand_id) {
            $result = Brand::find($brand_id);
            if ($result) {
                $response = [
                    'status' => 200,
                    'message' => 'Thương hiệu này hợp lệ vì không tồn tại!',
                ];
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Có lỗi xảy ra!',
                ];
            }
            return response()->json($response);
        }
    }
    public function getProductSku()
    {
        $sku = request()->input('sku');
        $product_id = request()->input('product_id');
        if ($product_id) {
            $checkSku = Product::where('SKU', $sku)->where('id', '!=', $product_id)->first();
        } else {
            $checkSku = Product::where('SKU', $sku)->first();
        }
        if ($checkSku) {
            $response = [
                'status' => 400,
                'message' => 'Mã sản phẩm đã tồn tại!',
                'data' => $checkSku
            ];
        } else {
            $response = [
                'status' => 200,
                'message' => 'Mã sản phẩm hợp lệ!',
                'data' => $checkSku
            ];
        }
        return response()->json($response);
    }
    public function getProductVariationSku()
    {
        $sku = request()->input('sku');
        $checkSku = Product_variant::where('SKU', $sku)->first();
        if ($checkSku) {
            $response = [
                'status' => 400,
                'message' => 'Mã biến thể đã tồn tại!',
            ];
        } else {
            $response = [
                'status' => 200,
                'message' => 'Mã biến thể hợp lệ!',
            ];
        }
        return response()->json($response);
    }
    private function buildCategoryTree($categories, $parentId = 0)
    {
        $tree = [];

        foreach ($categories as $category) {
            if ($category->parent_category_id == $parentId) {
                $children = $this->buildCategoryTree($categories, $category->id);
                if ($children) {
                    $category->subcategories = $children;
                } else {
                    $category->subcategories = [];
                }
                $tree[] = $category;
            }
        }
        return $tree;
    }
    public function getAllAttributes()
    {
        $attributes = Attribute::all();
        $attributesJson = [];
        foreach ($attributes as $item) {
            $array = [];
            $array['id'] = $item->id;
            $array['name'] = $item->name;
            $attributesJson[] = $array;
        }
        $response = [
            'status' => 'Successfully',
            'message' => 'Lấy dữ liệu thành công!',
            'data' => $attributesJson
        ];
        return response()->json($response);
    }
    public function getAllAttributeValuesById()
    {
        $attribute_id = request()->input('attribute_id');
        $attributeValues = Attribute_value::where('attribute_id', $attribute_id)->get();
        $attributeValuesJson = [];
        foreach ($attributeValues as $item) {
            $array = [];
            $array['id'] = $item->id;
            $array['name'] = $item->name;
            $array['value'] = $item->value ?: '';
            $attributeValuesJson[] = $array;
        }
        $response = [
            'status' => 'Successfully',
            'message' => 'Lấy dữ liệu thành công!',
            'data' => $attributeValuesJson
        ];
        return response()->json($response);
    }
    public function addNewAttributeValueById()
    {
        $attribute_id = request()->input('attribute_id');
        $newAttributeValue = request()->input('new_attribute_value');
        $checkAttributeValue = Attribute_value::where('attribute_id', $attribute_id)->where('name', $newAttributeValue)->first();
        if ($checkAttributeValue) {
            $response = [
                'status' => 400,
                'message' => 'Giá trị thuộc tính đã tồn tại!',
            ];
            return response()->json($response);
        }
        $newAttributeValueModel = new Attribute_value();
        $newAttributeValueModel->attribute_id = $attribute_id;
        $newAttributeValueModel->name = $newAttributeValue;
        $newAttributeValueModel->save();
        $array = [];
        $array['id'] = $newAttributeValueModel->id;
        $array['name'] = $newAttributeValueModel->name;
        $response = [
            'status' => 200,
            'message' => 'Thêm mới giá trị thuộc tính thành công!',
            'data' => $array
        ];
        return response()->json($response);
    }
}
