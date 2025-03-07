<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\CheckOutController;
use App\Http\Controllers\user\WishlistController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\user\FilterProductController;
use App\Http\Controllers\User\ProductDetailController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\User\ContactController;

//---------------------------------------------ROUTE DÙNG CHUNG----------------------------------------------------------
Route::get('/', [HomeController::class, 'index'])->name('/');
//Trang chi tiết sản phẩm
Route::get('productDetail/{sku}', [ProductDetailController::class, 'index'])->name('product.detail');
Route::post('productDetail', [ProductDetailController::class, 'updateInformationProduct'])->name('userProductDetailFocused');
Route::post('cart', [ProductDetailController::class, 'addToCart'])->name('addToCart'); //Add cart
//Bộ sưu tập
Route::get('product', [FilterProductController::class, 'index'])->name('product');
Route::get('/getProductDetail/{productId}', [FilterProductController::class, 'getProductDetails']);
Route::post('product/getMinMaxPriceProduct', [FilterProductController::class, 'getMinMaxPriceProduct'])->name('getMinMaxPriceProduct');
//Trang bài viết
Route::get('blog', [HomeController::class, 'blog'])->name('blog');
Route::get('blog-detail', [HomeController::class, 'blogDetail'])->name('blog-detail');
Route::get('about-us', [HomeController::class, 'aboutUs'])->name('about-us');
//Trang liên hệ
Route::get('contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
//Thêm sản phẩm vào giỏ trang chủ
Route::get('/get-product-details/{productId}', [HomeController::class, 'getProductDetails']);
Route::post('/cart/add', [HomeController::class, 'addToCart'])->name('cart.add');

//Lưu voucher
Route::post('/save-voucher', [HomeController::class, 'saveVoucher'])->name('saveVoucher');

//Yêu thích sản phẩm
Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::post('wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::delete('/wishlist/delete', [WishlistController::class, 'deleteToWishlist'])->name('wishlist.delete');

//---------------------------------------------ROUTE CHO KHÁCH----------------------------------------------------------
Route::middleware('guest')->group(function () {
    //Đăng ký
    Route::get('register', [RegisterController::class, 'index'])->name('register'); //Trang đăng ký
    Route::post('register', [RegisterController::class, 'register'])->name('register'); //Chức năng đăng ký
    //Xác thực tài khoản
    Route::get('verify/{token}', [RegisterController::class, 'verify'])->name('verifyEmail');
    //Đăng nhập google
    Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('google');
    Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback']);
    //Đăng nhập
    Route::get('login', [LoginController::class, 'index'])->name('login'); //Trang đăng nhập
    Route::post('login', [LoginController::class, 'login'])->name('login'); //Chức năng đăng nhập
    //Quên mật khẩu
    Route::get('forgot-password', [ForgotPasswordController::class, 'ForgotForm'])->name('fotgot-pasword'); //Trang quên mật khẩu
    Route::post('forgot-processing', [ForgotPasswordController::class, 'resetPassword'])->name('forgot-processing'); // Chức năng lấy lại mật khẩu
});

//--------------------------------------ROUTE ĐĂNG NHẬP MỚI DÙNG ĐƯỢC---------------------------------------------------
Route::middleware(['auth', 'checkBanned'])->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout'); //Chức năng đăng xuất
    //Dashboard người dùng
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::put('dashboard/edit-profile', [DashboardController::class, 'editProfile'])->name('dashboard.editProfile'); // Cập nhật thông tin profile
    Route::put('dashboard/edit-password', [DashboardController::class, 'editPassword'])->name('dashboard.editPassword'); // Edit password
    Route::post('dashboard/add-address', [DashboardController::class, 'addAddress'])->name('dashboard.addAddress'); //Thêm địa chỉ giao hàng
    Route::put('dashboard/edit-address/{id}', [DashboardController::class, 'editAddress'])->name('dashboard.editAddress'); // Sửa địa chỉ
    Route::delete('dashboard/delete-address/{id}', [DashboardController::class, 'deleteAddress'])->name('dashboard.deleteAddress'); // Xoá địa chỉ
    Route::post('dashboard/shipping-addresses/set-default/{id}', [DashboardController::class, 'setDefaultShippingAddress'])->name('dashboard.addresses.set.default'); //Set địa chỉ mặc định

    Route::post('dashboard/get-orders', [DashboardController::class, 'getOrders'])->name('dashboard.getOrders');
    Route::post('dashboard/cancel-order', [DashboardController::class, 'cancelOrder'])->name('dashboard.cancelOrder');
    Route::post('dashboard/confirm-done-order', [DashboardController::class, 'confirmDoneOrder'])->name('dashboard.confirmDoneOrder');
    Route::post('dashboard/order-detail', [DashboardController::class, 'getOrderDetail'])->name('dashboard.orderDetail');
    Route::post('dashboard/vote-order-detail', [DashboardController::class, 'getVoteOrderDetail'])->name('dashboard.getVoteOrderDetail');
    Route::post('dashboard/submit-vote-order-detail', [DashboardController::class, 'submitVoteOrderDetail'])->name('dashboard.submitVoteOrderDetail');
    Route::post('dashboard/submit-edit-vote-order-detail', [DashboardController::class, 'submitEditVoteOrderDetail'])->name('dashboard.submitEditVoteOrderDetail');

    //Trang giỏ hàng
    Route::get('cart', [CartController::class, 'index'])->name('cart');
    Route::delete('cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove'); // Route xóa sản phẩm khỏi giỏ hàng
    Route::delete('cart/clear', [CartController::class, 'clearAll'])->name('cart.clearAll'); // Xóa tất cả sản phẩm trong giỏ hàng
    Route::get('cart/product/{product_id}/variants', [CartController::class, 'getProductVariants'])->name('getProductVariants');
    Route::post('product/{product_id}/update-variant', [CartController::class, 'updateVariant']); //cập nhật biến thể trong giỏ hàng
    Route::get('product/{product_id}/variants', [CartController::class, 'getProductVariants']);
    Route::get('api/cart-items', [CartController::class, 'getCartItemsApi']);

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    Route::post('cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
    //Trang yêu thích
    Route::get('wishlist/{product_id}', [WishlistController::class, 'index']);
    //Checkout
    Route::prefix('check-out')->group(function () {
        Route::get('/', [CheckOutController::class, 'index'])->name('checkout');
        Route::post('/add-address', [CheckOutController::class, 'addAddress'])->name('checkout.addAddress');
        Route::post('/get-list-addresses', [CheckOutController::class, 'getListAddresses'])->name('checkout.getListAddresses');
        Route::put('/edit-default-address', [CheckOutController::class, 'editDefaultAddress'])->name('checkout.editDefaultAddress');
        Route::put('/edit-address/{id}', [CheckOutController::class, 'editAddress'])->name('checkout.editAddress');
        Route::put('/set-default-address', [CheckOutController::class, 'setDefaultAddress'])->name('checkout.setDefaultAddress');
        Route::put('/set-default-address-other/{id}', [CheckOutController::class, 'setDefaultAddressOther'])->name('checkout.setDefaultAddressOther'); // Xoá địa chỉ
        Route::delete('/delete-address/{id}', [CheckOutController::class, 'deleteAddress'])->name('checkout.deleteAddress'); // Xoá địa chỉ
        Route::post('/get-voucher-by-code', [CheckOutController::class, 'getVoucherByCode'])->name('checkout.getVoucherByCode');
        Route::post('/store-order', [OrderController::class, 'store'])->name('checkout.storeOrder');

        Route::post('/vnpay-create_payment', [PaymentController::class, 'vnpay_payment'])->name('checkout.vnpay_payment');
        Route::get('/vnpay-return', [PaymentController::class, 'vnpay_return'])->name('checkout.vnpay_return');

        Route::post('/momo-payment', [PaymentController::class, 'momo_payment'])->name('checkout.momo_payment');
        Route::get('/momo-return', [PaymentController::class, 'momo_return'])->name('checkout.momo_return');
    });

    Route::get('order-success/{id}', [OrderController::class, 'show'])->name('order_success');
    Route::get('order-failed/{id}', [OrderController::class, 'show'])->name('order_failed');
});
