<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\user\WishlistController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\user\CollectionController;
use App\Http\Controllers\user\FilterProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//lấy toàn bộ sản phẩm
Route::get('products/all', [FilterProductController::class, 'getAllProducts']);
Route::get('products/bestselingproduct', [FilterProductController::class, 'getBestSellingProducts']);
Route::get('products/getNewProduct', [FilterProductController::class, 'getNewProduct']);
Route::get('products/getDescPriceProducts', [FilterProductController::class, 'getDescPriceProducts']);
Route::get('products/getEscPriceProducts', [FilterProductController::class, 'getEscPriceProducts']);
//lọc theo danh mục

//hiển thị sản phẩm sau khi lọc
Route::get('products/filter', [FilterProductController::class, 'filterProduct']);
Route::get('/products/sort', [FilterProductController::class, 'sortProducts']);
Route::get('/product/{id}', [FilterProductController::class, 'getProductDetails']);
Route::get('/favorite', [WishlistController::class, 'getAllFavotited']);
//cart
Route::get('product/{product_id}/variants', [CartController::class, 'getProductVariants']);
Route::get('product/{product_id}/variantstest', [CartController::class, 'test']);
Route::get('cart-items', [CartController::class, 'getCartItemsApi']);

