@extends('user.layouts.master')

@section('content')
<!-- Container content -->
<main>
    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Bảng Điều Khiển</h4>
                    </div>
                    {{-- <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="{{route('/')}}">Home </a></li>
                    <li class="breadcrumb-item active"> <a href="#">Dashboard</a></li>
                    </ul>
                </div> --}}
            </div>
        </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container container user-dashboard-section">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="left-dashboard-show"><button class="btn btn_black sm rounded bg-primary">Show
                            Menu</button></div>
                    <div class="dashboard-left-sidebar sticky">
                        <div class="profile-box">
                            <div class="profile-bg-img"></div>
                            <div class="dashboard-left-sidebar-close"><i class="fa-solid fa-xmark"></i></div>
                            <div class="profile-contain">
                                <div class="profile-image"> <img class="img-fluid" src="{{ asset('assets/images/user/user-icon.jpg') }}" alt=""></div>
                                {{-- Profile --}}
                                <div class="profile-name">
                                    <h4>{{ Auth::user()->full_name ?? Auth::user()->username }}</h4>
                                    <h6>{{ Auth::user()->email }}</h6>
                                    <span data-bs-toggle="modal" data-bs-target="#edit-profile" title="Edit Profile" tabindex="0">Sửa hồ sơ</span>
                                </div>
                            </div>
                        </div>
                        <ul class="nav flex-column nav-pills dashboard-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <li>
                                <button class="nav-link active" id="dashboard-tab" data-bs-toggle="pill" data-bs-target="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true">
                                    <i class="iconsax" data-icon="home-1"></i>
                                    Tài Khoản Của Tôi
                                </button>
                            </li>
                            <li>
                                <button class="nav-link" id="notifications-tab" data-bs-toggle="pill" data-bs-target="#notifications" role="tab" aria-controls="notifications"
                                    aria-selected="false">
                                    <i class="iconsax" data-icon="lamp-2"></i>
                                    Thông Báo
                                </button>
                            </li>
                            <li>
                                <button class="nav-link" id="order-tab" data-bs-toggle="pill" data-bs-target="#order" role="tab" aria-controls="order" aria-selected="false" data-clicked="false">
                                    <i class="iconsax" data-icon="receipt-square"></i>
                                    Đơn Hàng
                                </button>
                            </li>
                            <li>
                                <button class="nav-link" id="wishlist-tab" data-bs-toggle="pill" data-bs-target="#wishlist" role="tab" aria-controls="wishlist" aria-selected="false">
                                    <i class="iconsax" data-icon="heart"></i>
                                    Yêu Thích
                                </button>
                            </li>
                            <li>
                                <button class="nav-link" id="vouchers-tab" data-bs-toggle="pill" data-bs-target="#vouchers" role="tab" aria-controls="vouchers" aria-selected="false">
                                    <svg fill="#000000" width="21px" data-icon="bank-card" height="21px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g id="coupon">
                                                <path
                                                    d="M21,10a2.2489,2.2489,0,0,1,.4087.0415.5072.5072,0,0,0,.4111-.1074A.4992.4992,0,0,0,22,9.55V7.5A2.503,2.503,0,0,0,19.5,5H4.5A2.503,2.503,0,0,0,2,7.5V9.55a.5.5,0,0,0,.5913.4917A2.2489,2.2489,0,0,1,3,10a2,2,0,0,1,0,4,2.2489,2.2489,0,0,1-.4087-.0415.5073.5073,0,0,0-.4111.1074A.4992.4992,0,0,0,2,14.45V16.5A2.503,2.503,0,0,0,4.5,19h15A2.503,2.503,0,0,0,22,16.5V14.45a.4992.4992,0,0,0-.18-.3843.5081.5081,0,0,0-.4111-.1074A2.2489,2.2489,0,0,1,21,14a2,2,0,0,1,0-4Zm0,5v1.5A1.5017,1.5017,0,0,1,19.5,18H4.5A1.5017,1.5017,0,0,1,3,16.5V15A3,3,0,0,0,3,9V7.5A1.5017,1.5017,0,0,1,4.5,6h15A1.5017,1.5017,0,0,1,21,7.5V9a3,3,0,0,0,0,6Z">
                                                </path>
                                                <path d="M12.5,9v1a.5.5,0,0,1-1,0V9a.5.5,0,0,1,1,0Z"></path>
                                                <path d="M12.5,14v1a.5.5,0,0,1-1,0V14a.5.5,0,0,1,1,0Z"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    Phiếu Giảm Giá
                                </button>
                            </li>
                            <li>
                                <button class="nav-link" id="address-tab" data-bs-toggle="pill" data-bs-target="#address" role="tab" aria-controls="address" aria-selected="false">
                                    <i class="iconsax" data-icon="cue-cards"></i>
                                    Địa Chỉ
                                </button>
                            </li>
                            <li>
                                <button class="nav-link" id="privacy-tab" data-bs-toggle="pill" data-bs-target="#privacy" role="tab" aria-controls="privacy" aria-selected="false">
                                    <i class="iconsax" data-icon="security-user"></i>
                                    Riêng Tư
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="tab-content" id="v-pills-tabContent">
                        {{-- Dashboard --}}
                        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                            <div class="dashboard-right-box">
                                <div class="my-dashboard-tab">
                                    <div class="dashboard-items"> </div>
                                    <div class="sidebar-title">
                                        <div class="loader-line"></div>
                                        <h4>Tài khoản của tôi</h4>
                                    </div>
                                    <div class="dashboard-user-name">
                                        <h6>Xin chào,
                                            <b>{{ Auth::user()->full_name ? Auth::user()->full_name : Auth::user()->username }}</b>
                                        </h6>
                                        <p>Chào mừng bạn đến với BeesFashion, shop thời trang mang đến phong cách và sự
                                            tự tin cho bạn!
                                            Bảng điều khiển của chúng tôi cung cấp thông tin chi tiết về các số liệu
                                            quan trọng,
                                            giúp bạn dễ dàng quản lý tài khoản, theo dõi đơn hàng, và khám phá các ưu
                                            đãi hấp dẫn.
                                            Chúc bạn có trải nghiệm mua sắm thật tuyệt vời cùng BeesFashion!</p>
                                    </div>
                                    <div class="total-box">
                                        <div class="row gy-4">
                                            <div class="col-xl-4">
                                                <div class="totle-contain">
                                                    <div class="wallet-point"><img src="{{ asset('assets/images/user/wallet.svg') }}" alt=""><img class="img-1"
                                                            src="{{ asset('assets/images/user/wallet.svg') }}" alt=""></div>
                                                    <div class="totle-detail">
                                                        <h6>Chi Tiêu</h6>
                                                        <h4>{{ number_format(Auth::user()->getTotalSpent(), 0, ',', '.') }}đ
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="totle-contain">
                                                    <div class="wallet-point"><img src="{{ asset('assets/images/user/coin.svg') }}" alt=""><img class="img-1"
                                                            src="{{ asset('assets/images/user/coin.svg') }}" alt=""></div>
                                                    <div class="totle-detail">
                                                        <h6>Hạng</h6>
                                                        <h4>{{ Auth::user()->getMembershipRank() }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="totle-contain">
                                                    <div class="wallet-point"><img src="{{ asset('assets/images/user/order.svg') }}" alt=""><img class="img-1"
                                                            src="{{ asset('assets/images/user/order.svg') }}" alt=""></div>
                                                    <div class="totle-detail">
                                                        <h6>Số Lượng Đơn Hàng</h6>
                                                        <h4>{{ Auth::user()->getTotalOrders() }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="profile-about">
                                        <div class="row">
                                            <div class="col-xl-7">
                                                <div class="sidebar-title">
                                                    <div class="loader-line"></div>
                                                    <h5>Thông Tin Hồ Sơ</h5>
                                                </div>
                                                <ul class="profile-information">
                                                    <li>
                                                        <h6>Tên đăng nhập:</h6>
                                                        <p>{{ Auth::user()->username ?? 'Chưa cập nhật' }}
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <h6>Họ tên:</h6>
                                                        <p>{{ Auth::user()->full_name ? Auth::user()->full_name : 'Chưa cập nhật' }}
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <h6>Số điện thoại:</h6>
                                                        <p>{{ Auth::user()->phone ? Auth::user()->phone : 'Chưa cập nhật' }}
                                                        </p>
                                                    </li>
                                                </ul>
                                                <div class="sidebar-title">
                                                    <div class="loader-line"></div>
                                                    <h5>Chi Tiết Đăng Nhập</h5>
                                                </div>
                                                <ul class="profile-information mb-0">
                                                    <li>
                                                        <h6>Email:</h6>
                                                        <p>{{ Auth::user()->email }}</p>
                                                    </li>
                                                    <li>
                                                        <h6>Mật khẩu:</h6>
                                                        <p>●●●●●●<span data-bs-toggle="modal" data-bs-target="#edit-password" title="Edit Password" tabindex="0">Edit</span></p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-xl-5">
                                                <div class="profile-image d-none d-xl-block"> <img class="img-fluid" src="{{ asset('assets/images/other-img/dashboard.png') }}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End dashboard --}}

                        {{-- Notifications --}}
                        <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
                            <div class="dashboard-right-box">
                                <div class="notification-tab">
                                    <div class="sidebar-title">
                                        <div class="loader-line"></div>
                                        <h4>Thông báo</h4>
                                    </div>
                                    <ul class="notification-body">
                                        <li>
                                            <div class="user-img"> <img src="../assets/images/notification/1.jpg" alt=""></div>
                                            <div class="user-contant">
                                                <h6>Mint - is your budget ready for spring
                                                    spending?<span>2:14PM</span>
                                                </h6>
                                                <p>A quick weekend trip, a staycation in your own town, or a
                                                    weeklong
                                                    vacay with the family—it’s your choice if it’s in the budget. No
                                                    matter what you plan on doing during spring break, budget ahead
                                                    for
                                                    it.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-img"> <img src="../assets/images/notification/2.jpg" alt=""></div>
                                            <div class="user-contant">
                                                <h6>Flipkart - Confirmed order<span>2:14PM</span></h6>
                                                <p>Thanks for signing up for CodePen! We're happy you're here. Let's
                                                    get
                                                    your email address verified:</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- End notifications --}}

                        {{-- Whishlist --}}
                        <div class="tab-pane fade" id="wishlist" role="tabpanel" aria-labelledby="wishlist-tab">
                            <div class="dashboard-right-box">
                                <div class="wishlist-box ratio1_3">
                                    <div class="sidebar-title">
                                        <div class="loader-line"></div>
                                        <h4>Sản Phẩm Yêu Thích</h4>
                                    </div>
                                    <div class="row-cols-md-3 row-cols-2 grid-section view-option row gy-4 g-xl-4">
                                        <div class="col">
                                            <div class="product-box-3 product-wishlist">
                                                <div class="img-wrapper">
                                                    <div class="label-block"><a class="label-2 wishlist-icon delete-button" href="javascript:void(0)" title="Add to Wishlist" tabindex="0"><i
                                                                class="iconsax" data-icon="trash" aria-hidden="true"></i></a></div>
                                                    <div class="product-image"><a class="pro-first" href="product.html">
                                                            <img class="bg-img" src="../assets/images/product/product-3/11.jpg" alt="product"></a><a class="pro-sec" href="product.html"> <img
                                                                class="bg-img" src="../assets/images/product/product-3/14.jpg" alt="product"></a></div>
                                                    <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart" title="Add to cart" tabindex="0"><i
                                                                class="iconsax" data-icon="basket-2" aria-hidden="true"> </i></a><a href="compare.html" title="Compare" tabindex="0"><i
                                                                class="iconsax" data-icon="arrow-up-down" aria-hidden="true"></i></a><a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#quick-view" title="Quick View" tabindex="0"><i class="iconsax" data-icon="eye" aria-hidden="true"></i></a></div>
                                                </div>
                                                <div class="product-detail">
                                                    <ul class="rating">
                                                        <li><i class="fa-solid fa-star"></i></li>
                                                        <li><i class="fa-solid fa-star"></i></li>
                                                        <li><i class="fa-solid fa-star"></i></li>
                                                        <li><i class="fa-solid fa-star"></i></li>
                                                        <li><i class="fa-solid fa-star"></i></li>
                                                        <li>4.3</li>
                                                    </ul><a href="product.html">
                                                        <h6>Long Sleeve Rounded T-Shirt</h6>
                                                    </a>
                                                    <p>$120.30 <del>$140.00</del><span>-20% </span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End whishlist --}}

                        {{-- Order --}}
                        <div class="tab-pane fade" id="order" role="tabpanel" aria-labelledby="order-tab">
                            <div class="dashboard-right-box">
                                <div class="order">
                                    <div class="sidebar-title">
                                        <div class="loader-line"></div>
                                        <h4>Lịch Sử Đơn Hàng Của Tôi</h4>
                                    </div>
                                    <div class="dashboard-left-sidebar position-sticky top-0 z-3">
                                        <ul class="nav flex-row nav-pills order-dashboard-tab justify-content-between" role="tablist" aria-orientation="vertical">
                                            <li>
                                                <button class="order_menu nav-link active" id="order_all_tab" data-id="0" data-bs-toggle="pill" role="tab" aria-controls="order-all"
                                                    aria-selected="true" onclick="change_order_status(0)">
                                                    Tất cả
                                                </button>
                                            </li>
                                            <li>
                                                <button class="order_menu nav-link" id="order_to_pay_tab" data-id="1" data-bs-toggle="pill" role="tab" aria-controls="order-to-pay"
                                                    aria-selected="false" onclick="change_order_status(1)">
                                                    Chờ thanh toán
                                                </button>
                                            </li>
                                            <li>
                                                <button class="order_menu nav-link" id="order_to_confirmation_tab" data-id="2" data-bs-toggle="pill" role="tab"
                                                    aria-controls="order-to-confirmation" aria-selected="false" onclick="change_order_status(2)">
                                                    Chờ xác nhận
                                                </button>
                                            </li>
                                            <li>
                                                <button class="order_menu nav-link" id="order_to_receive_tab" data-id="3" data-bs-toggle="pill" role="tab" aria-controls="order-to-receive"
                                                    aria-selected="false" onclick="change_order_status(3)">
                                                    Đang giao hàng
                                                </button>
                                            </li>
                                            <li>
                                                <button class="order_menu nav-link" id="order_completed_tab" data-id="4" data-bs-toggle="pill" role="tab" aria-controls="order-completed"
                                                    aria-selected="false" onclick="change_order_status(4)">
                                                    Hoàn thành
                                                </button>
                                            </li>
                                            <li>
                                                <button class="order_menu nav-link" id="order_cancelled_tab" data-id="5" data-bs-toggle="pill" role="tab" aria-controls="order-cancelled"
                                                    aria-selected="false" onclick="change_order_status(5)">
                                                    Bị hủy
                                                </button>
                                            </li>
                                            <!-- <li>
                                                        <button class="order_menu nav-link" id="order_return_refund_tab"
                                                            data-id="6" data-bs-toggle="pill" role="tab"
                                                            aria-controls="order-return-refund" aria-selected="false"
                                                            onclick="change_order_status(6)">
                                                            Return/Refund
                                                        </button>
                                                    </li> -->
                                        </ul>
                                    </div>

                                    <div class="row gy-4 mt-1" id="list_orders">
                                        <!-- Order items -->
                                        <!-- Hiển thị danh sách đơn hàng ở đây -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Order --}}
                        {{-- Order Details --}}
                        <div class="tab-pane fade" id="order_details" role="tabpanel" aria-labelledby="order-details-tab">
                            <div class="dashboard-right-box">
                                <div class="notification-tab">
                                    <div class="mb-2 d-flex flex-row justify-content-between position-sticky top-0 z-3">
                                        <a class="btn btn-dark color-of-theme border" id="btn_back_to_list_orders">
                                            <i class="fas fa-arrow-left me-1 color-of-theme"></i>
                                            Quay lại
                                        </a>
                                        <div class="d-flex flex-row">
                                            <div>
                                                <span class="fs-6 text-dark">MÃ ĐƠN HÀNG:</span>
                                                <span class="fs-6 text-dark" id="span_order_code">123</span>
                                            </div>
                                            <span class="fs-6 ms-2 me-2">|</span>
                                            <span class="fs-6 text-danger" id="span_order_status">WAITING FOR
                                                PAYMENT</span>
                                        </div>
                                    </div>
                                    <div class="sidebar-title mt-4">
                                        <div class="loader-line"></div>
                                        <h4>Chi tiết đơn hàng</h4>
                                    </div>
                                    <ul class="notification-body">
                                        <!-- Content order details -->
                                        <div class="p-3">
                                            <div class="progress-container" id="progress-container">
                                                <div class="progress-step completed">
                                                    <div class="step-icon">📄</div>
                                                    <div class="step-text">Tạo Mới Đơn Hàng</div>
                                                    <span class="step-time no-wrap">23:13 22-05-2024</span>
                                                </div>
                                                <div class="progress-line bg-of-theme"></div>
                                                <div class="progress-step completed">
                                                    <div class="step-icon">💳</div>
                                                    <div class="step-text">Đã Xác Nhận TTTT & Đặt Hàng</div>
                                                    <span class="step-time no-wrap">03:13 23-05-2024</span>
                                                </div>
                                                <div class="progress-line bg-of-theme"></div>
                                                <div class="progress-step completed">
                                                    <div class="step-icon">✅</div>
                                                    <div class="step-text">Đã Kiểm Tra Đơn Hàng</div>
                                                    <div class="step-time no-wrap">08:51 29-05-2024</div>
                                                </div>
                                                <div class="progress-line bg-of-theme"></div>
                                                <div class="progress-step completed">
                                                    <div class="step-icon">🚚</div>
                                                    <div class="step-text">Đã Giao Cho DVC</div>
                                                    <span class="step-time no-wrap">13:34 23-05-2024</span>
                                                </div>
                                                <div class="progress-line bg-of-theme"></div>
                                                <div class="progress-step completed">
                                                    <div class="step-icon">🌟</div>
                                                    <div class="step-text">Đơn Hàng Đã Hoàn Thành</div>
                                                    <span class="step-time no-wrap">23:59 28-06-2024</span>
                                                </div>
                                                <div class="progress-line"></div>
                                                <div class="progress-step completed">
                                                    <div class="step-icon">❌</div>
                                                    <div class="step-text">Đã Hủy</div>
                                                    <span class="step-time no-wrap">23:59 28-06-2024</span>
                                                </div>
                                            </div>
                                            <div class="text-center border-top border-bottom mt-3 p-3 bg-of-theme d-flex flex-column align-items-center">
                                                <span class="text-white">Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi!</span>
                                            </div>

                                        </div>

                                        <section class="section-b-space">
                                            <div class="custom-container container order-success">
                                                <!-- <div class="row gy-4"> -->
                                                <div class="col-xl-12">
                                                    <div class="order-items sticky">
                                                        <h4>Thông tin đơn hàng </h4>
                                                        <p>Hóa đơn đặt hàng đã được gửi đến tài khoản email đã đăng ký của bạn. Kiểm tra lại thông tin chi tiết đơn hàng của bạn
                                                        </p>
                                                        <div class="order-table">
                                                            <div class="table-responsive theme-scrollbar list-product-scrollbar scroll-container" style="max-height:500px;">
                                                                <table class="table table-hover">
                                                                    <thead class="position-sticky top-0">
                                                                        <tr class="tr_of_list_products_in_order">
                                                                            <th># </th>
                                                                            <th>Sản phẩm</th>
                                                                            <th>Giá</th>
                                                                            <th>Số lượng</th>
                                                                            <th>Tổng tiền</th>
                                                                            <th>Đã áp dụng voucher</th>
                                                                            <th>Thao tác</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="body_of_list_product">
                                                                        <!-- Danh sách sản phẩm biến thể ở đây -->
                                                                    </tbody>
                                                                    <tfoot class="position-sticky bottom-0" id="tfoot_of_list_product">
                                                                        <!-- Đây là footer, hiển thị tổng tiền của các sản phẩm biến thể -->
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- </div> -->
                                                <div class="col-xl-12">
                                                    <div class="d-flex flex-column align-items-end me-3" style="margin-right:20px !important;">
                                                        <span class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#confirm-done-order-modal" id="btn_confirm_done_order_2">Đã nhận hàng</span>
                                                        <span class="btn btn-primary mt-2 w-25 btn_continue_payment_order no-select" id="btn_continue_payment_order_2" title="Tiếp tục thanh toán" data-id="" data-amount="" data-payment-method="">Tiếp tục thanh toán</span>
                                                        <span class="btn btn-danger btn-sm mt-2 w-25 btn_cancel_order no-select" id="btn_cancel_order_2" data-bs-toggle="modal" data-bs-target="#cancel-order-modal" title="Hủy" tabindex="0" data-id="">Hủy đơn hàng</span>
                                                    </div>
                                                    <div class="summery-box">
                                                        <div class="sidebar-title">
                                                            <div class="loader-line"></div>
                                                            <h4>Chi tiết đơn hàng phụ </h4>
                                                        </div>
                                                        <div class="summery-content">
                                                            <ul>
                                                                <li>
                                                                    <p class="fw-semibold">Tổng tiền của sản phẩm (<span id="sod_total_products"></span>)</p>
                                                                    <h6 id="sod_sub_total_payment">123 đ</h6>
                                                                </li>
                                                                <li>
                                                                    <p>Vận chuyển đến </p><span>vietnam</span>
                                                                </li>
                                                                <li>
                                                                    <p>Phương thức thanh toán </p><span id="sod_payment_method">vnpay</span>
                                                                </li>
                                                            </ul>
                                                            <ul>
                                                                <li>
                                                                    <p>Phí vận chuyển</p><span id="sod_shipping_costs">123 đ</span>
                                                                </li>
                                                                <li>
                                                                    <p>Thuế <span>(0,5% tổng giá trị đơn hàng)</span> </p>
                                                                    <span id="sod_tax">123 đ</span>
                                                                </li>
                                                                <li>
                                                                    <p>Mã giảm giá vận chuyển </p><span class="text-danger" id="sod_shipping_voucher">-123 đ</span>
                                                                </li>
                                                                <li>
                                                                    <p>Mã giảm giá từ cửa hàng </p><span class="text-danger" id="sod_voucher">-123 đ</span>
                                                                </li>
                                                            </ul>
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <h6>Tổng tiền (VND)</h6>
                                                                <h5 id="sod_total_payment">455555 đ</h5>
                                                            </div>
                                                            <!-- <div class="note-box">
                                                                <p>Tôi hy vọng cửa hàng có thể làm việc với tôi để giao hàng sớm nhất có thể vì tôi thực sự cần nó để tặng cho bạn tôi vào bữa tiệc tuần tới. Cảm ơn bạn rất nhiều.
                                                                </p>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                    <div class="summery-footer">
                                                        <div class="sidebar-title">
                                                            <div class="loader-line"></div>
                                                            <h4>Địa chỉ giao hàng</h4>
                                                        </div>
                                                        <ul>
                                                            <li class="d-flex flex-column">
                                                                <h6 id="sod_full_name">Phạm chình</h6>
                                                                <h6 id="sod_phone_number">0987654321 </h6>
                                                                <h6 id="sod_address">abc</h6>
                                                            </li>
                                                            <li>
                                                                <h5 id="sod_ordered_at">November</h5>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- End Order Details --}}
                        <!-- Form tiếp tục thanh toán -->
                        <form action="{{ route('checkout.vnpay_payment') }}" method="post" id="form_vnpay">
                            @csrf
                            <input type="hidden" name="order_id" class="order_id">
                            <input type="hidden" name="amount" class="amount">
                            <input type="hidden" name="redirect">
                        </form>
                        <form action="{{ route('checkout.momo_payment') }}" method="post" id="form_momo">
                            @csrf
                            <input type="hidden" name="order_id" class="order_id">
                            <input type="hidden" name="amount" class="amount">
                            <input type="hidden" name="payUrl">
                        </form>

                        {{-- Modal cancel order --}}
                        <div class="modal theme-modal fade confirmation-modal" id="cancel-order-modal" tabindex="-1" role="dialog" aria-modal="true">
                            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body"> <img class="img-fluid" src="../assets/images/gif/question.gif" alt="">
                                        <h4>Xác nhận!</h4>
                                        <p>Hủy đơn hàng này, bạn có chắc chắn không?</p>
                                        <div class="submit-button">
                                            <button class="btn" data-bs-dismiss="modal" aria-label="Close">No</button>
                                            <button class="btn" data-bs-dismiss="modal" aria-label="Close" id="btn_confirm_cancel_order">Yes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Modal confirm done order --}}
                        <div class="modal theme-modal fade confirmation-modal" id="confirm-done-order-modal" tabindex="-1" role="dialog" aria-modal="true">
                            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body"> <img class="img-fluid" src="../assets/images/gif/question.gif" alt="">
                                        <h4>Xác nhận!</h4>
                                        <p>Xác nhận đơn hàng này, bạn có chắc chắn không?</p>
                                        <div class="submit-button">
                                            <button class="btn" data-bs-dismiss="modal" aria-label="Close">No</button>
                                            <button class="btn" data-bs-dismiss="modal" aria-label="Close" id="btn_confirm_done_order">Yes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End modal --}}

                        {{-- My vouchers --}}
                        <div class="tab-pane fade" id="vouchers" role="tabpanel" aria-labelledby="vouchers-tab">
                            <div class="dashboard-right-box">
                                <div class="saved-card">
                                    <div class="sidebar-title">
                                        <div class="loader-line"></div>
                                        <h4>Mã Giảm Giá Của Tôi</h4>
                                    </div>
                                    @if (count(Auth::user()->user_vouchers) > 0)
                                    <div class="block-vouchers">
                                        <div class="voucher-items-lists">
                                            <div class="row">
                                                @foreach (Auth::user()->user_vouchers as $item)
                                                <div class="col-md-6">
                                                    <div class="voucher-item">
                                                        <div class="voucher-item-info">
                                                            <div class="voucher-item-detail">
                                                                <div class="voucher-item-des">
                                                                    <strong>

                                                                        <span style="color: #ba372a; font-size: 15pt;">{{ $item->voucher->name }}
                                                                        </span>
                                                                        <br>

                                                                    </strong>
                                                                </div>
                                                                <div class="voucher-item-des"><span style="font-size: 10pt; color:black">Nhập
                                                                        mã
                                                                        <strong><span style="font-size: 12pt; color:black">{{ $item->voucher->code }}</span></strong><span
                                                                            style="color: #e03e2d;"><strong><br></strong></span></span>
                                                                </div>
                                                                <div class="voucher-item-des"><span style="font-size: 10pt; color:black">
                                                                        @if ($item->voucher->amount < 100)
                                                                            <!-- Dưới 100 -->
                                                                            Giảm
                                                                            {{ number_format($item->voucher->amount) . '%' }}
                                                                            cho đơn hàng từ
                                                                            {{ number_format($item->voucher->minimum_order_value / 1000) . 'K' }}
                                                                            @else
                                                                            <!-- Bằng hoặc trên 100 -->
                                                                            Giảm
                                                                            {{ number_format($item->voucher->amount / 1000) . 'K' }}
                                                                            cho đơn hàng từ
                                                                            {{ number_format($item->voucher->minimum_order_value / 1000) . 'K' }}
                                                                            @endif
                                                                    </span>
                                                                </div>
                                                                <div class="voucher-item-date">
                                                                    <span class="expire" style="font-size: 10pt; color:#ba372a"
                                                                        data-end-date="{{ \Carbon\Carbon::parse($item->voucher->end_date)->toIso8601String() }}">
                                                                        Hạn sử dụng: <span class="countdown" style="font-size: 10pt; color:#ba372a"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="voucher-item-action">
                                                                <div class="action"><a href="{{ route('product') }}">
                                                                        <span class="copy-content" style="cursor: pointer; font-weight: bold; font-size: 10pt; color:#ba372a">Dùng
                                                                            ngay</span></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="text-center">
                                        <h5 class="text-center">Bạn không có mã giảm giá nào được lưu</h5>
                                        <div>
                                            <img class="img-fluid" src="{{ asset('assets/images/ticket/nullvoucher.png') }}" width="450px">
                                            <div class="text-center mt-3">
                                                <a href="{{ route('/') }}" class="btn btn_black rounded sm">Săn mã ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- End save card --}}

                        {{-- Address --}}
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                            <div class="dashboard-right-box">
                                <div class="address-tab">
                                    <div class="sidebar-title">
                                        <div class="loader-line"></div>
                                        <h4>Chi Tiết Địa Chỉ Của Tôi</h4>
                                    </div>
                                    <div class="row gy-3">
                                        @if (Auth::user()->user_shipping_addresses && Auth::user()->user_shipping_addresses->count() > 0)
                                        @foreach (Auth::user()->user_shipping_addresses as $shippingAddress)
                                        <div class="col-xxl-12 col-md-6">
                                            <div class="address-option">
                                                <label for="address-billing-0">
                                                    <div class="delivery-address-box d-flex" data-id="{{ $shippingAddress->id }}">
                                                        <div class="address-detail">
                                                            {{-- <span class="address">
                                                                        <span class="address-title">Home</span>
                                                                    </span> --}}
                                                            <span class="address">
                                                                <span class="address-home d-flex">
                                                                    <span class="address-title">{{ $shippingAddress->full_name }}</span>
                                                                    @if ($shippingAddress->is_active)
                                                                    <span class="ms-3 mt-1">
                                                                        <span class="custom-status-set-address">Default</span>
                                                                    </span>
                                                                    @endif
                                                                </span>
                                                            </span>
                                                            <span class="address">
                                                                <span class="address-home d-flex">
                                                                    <span class="address-tag-office">Địa
                                                                        chỉ:</span>
                                                                    <p>{{ $shippingAddress->address }}</p>
                                                                </span>
                                                            </span>
                                                            <span class="address"><span class="address-home d-flex">
                                                                    <span class="address-tag-office">Số điện
                                                                        thoại:</span>
                                                                    <p>{{ $shippingAddress->phone_number }}</p>
                                                                </span>
                                                            </span>
                                                        </div>
                                                        <div class="address-action">
                                                            <div>
                                                                <a class="btn_edit_address" href="#" data-id="{{ $shippingAddress->id }}"
                                                                    data-full_name="{{ $shippingAddress->full_name }}" data-phone_number="{{ $shippingAddress->phone_number }}"
                                                                    data-address="{{ $shippingAddress->address }}" data-bs-toggle="modal" data-bs-target="#edit-address"
                                                                    title="Edit Address" tabindex="0">Chỉnh
                                                                    sửa</a>
                                                            </div>
                                                            <div>
                                                                <a class="btn_delete_address" href="#" title="Delete" tabindex="0"
                                                                    onclick="event.preventDefault();document.getElementById('delete-address-form').action='{{ route('dashboard.deleteAddress', $shippingAddress->id) }}';$('#delete-address-modal').modal('show');">Xoá</a>
                                                            </div>
                                                            <div>
                                                                @if (!$shippingAddress->is_active)
                                                                <span class="">
                                                                    <form action="{{ route('dashboard.addresses.set.default', $shippingAddress->id) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <button type="submit" class="custom-set-address">Đặt
                                                                            làm mặc định</button>
                                                                    </form>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="text-center">
                                            <div class="col-xxl-12 col-md-6">
                                                <div class="address-option">
                                                    <label for="address-billing-0">
                                                        <h4 class="mt-2">Bạn chưa thêm địa chỉ</h4>
                                                        <div>
                                                            <img class="img-fluid" src="{{ asset('assets/images/user/empty-cart.jpg') }}" width="250">
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <button class="btn add-address" data-bs-toggle="modal" data-bs-target="#add-address" title="Quick View" tabindex="0">+ Thêm
                                        mới</button>
                                </div>
                            </div>
                        </div>
                        {{-- End address --}}

                        {{-- Privacy --}}
                        <div class="tab-pane fade" id="privacy" role="tabpanel" aria-labelledby="privacy-tab">
                            <div class="dashboard-right-box">
                                <div class="privacy-tab">
                                    <div class="sidebar-title">
                                        <div class="loader-line"></div>
                                        <h4>Privacy</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="privacy-title">
                                                <h5>Allows others to see my profile</h5>
                                                <p>Choose who can access your app and if users need to <a href="sign-up.html"> sign up.</a></p>
                                            </div><span class="short-title">access</span>
                                            <ul class="privacy-items">
                                                <li>
                                                    <div class="privacy-icon"> <i class="iconsax" data-icon="lock-2"></i></div>
                                                    <div class="privacy-contant">
                                                        <h6>Private</h6>
                                                        <p>Only users you choose can access</p>
                                                    </div><label class="switch"><input type="checkbox" checked=""><span class="slider round"></span></label>
                                                </li>
                                                <li>
                                                    <div class="privacy-icon"> <i class="iconsax" data-icon="globe"></i>
                                                    </div>
                                                    <div class="privacy-contant">
                                                        <h6>Public</h6>
                                                        <p>Anyone with the link can</p>
                                                    </div><label class="switch"><input type="checkbox"><span class="slider round"></span></label>
                                                </li>
                                            </ul><span class="short-title">Users</span>
                                            <ul class="privacy-items">
                                                <li>
                                                    <div class="privacy-icon"> <i class="iconsax" data-icon="package"></i></div>
                                                    <div class="privacy-contant">
                                                        <h6>Users in the users table </h6>
                                                        <p>Only users in the users table can sign in </p>
                                                    </div><label class="switch"><input type="checkbox" checked=""><span class="slider round"></span></label>
                                                </li>
                                                <li>
                                                    <div class="privacy-icon"> <i class="iconsax" data-icon="fingerprint-circle"></i></div>
                                                    <div class="privacy-contant">
                                                        <h6>ongoing production team </h6>
                                                        <p>only members of your team can sign in </p>
                                                    </div><label class="switch"><input type="checkbox"><span class="slider round"></span></label>
                                                </li>
                                                <li>
                                                    <div class="privacy-icon"> <i class="iconsax" data-icon="add-layer"></i></div>
                                                    <div class="privacy-contant">
                                                        <h6>anyone form domain(s)</h6>
                                                        <p>only users with your email domain </p>
                                                    </div><label class="switch"><input type="checkbox" checked=""><span class="slider round"></span></label>
                                                </li>
                                                <li>
                                                    <div class="privacy-icon"> <i class="iconsax" data-icon="mail"></i>
                                                    </div>
                                                    <div class="privacy-contant">
                                                        <h6>any email in table </h6>
                                                        <p>Anyone with email included in a table </p>
                                                    </div><label class="switch"><input type="checkbox"><span class="slider round"></span></label>
                                                </li>
                                            </ul><span class="short-title"> </span>
                                            <ul class="privacy-items">
                                                <li>
                                                    <div class="privacy-contant">
                                                        <h6>Publishing </h6>
                                                        <p>Your Project is Published</p>
                                                    </div>
                                                    <div class="publish-button"> <button class="btn">Unpublish</button>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Privacy --}}
                    </div>
                </div>
            </div>
    </section>
    {{-- Modal edit profile --}}
    <div class="reviews-modal modal theme-modal fade" id="edit-profile" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Chỉnh sửa hồ sơ</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <form id="edit-profile-form" class="row g-3" action="{{ route('dashboard.editProfile') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Họ tên</label>
                                <input id="full_name" class="form-control @error('full_name') is-invalid @enderror" type="text" name="full_name" value="{{ Auth::user()->full_name }}"
                                    placeholder="Nhập tên đầy đủ của bạn.">
                                <div class="invalid-feedback">
                                    @error('full_name')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Số điện thoại</label>
                                <input id="phone" class="form-control @error('phone') is-invalid @enderror" type="number" name="phone" value="{{ Auth::user()->phone }}"
                                    placeholder="Nhập số điện thoại của bạn.">
                                <div class="invalid-feedback">
                                    @error('phone')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ Auth::user()->email }}"
                                    placeholder="Nhập email của bạn." @if (Auth::user()->google_id) disabled @endif>
                                <div class="invalid-feedback">
                                    @error('email')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-submit" type="submit">Xác nhận</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End modal --}}

    {{-- Modal Edit address --}}
    <div class="reviews-modal modal theme-modal fade" id="edit-address" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Chỉnh sửa địa chỉ</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <form id="edit-address-form" class="row g-3" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Họ tên</label>
                                <input class="form-control @error('full_name') is-invalid @enderror" type="text" name="full_name" placeholder="Nhập tên đầy đủ của bạn."
                                    value="{{ old('full_name') }}">
                                @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Số điện thoại</label>
                                <input class="form-control @error('phone_number') is-invalid @enderror" type="number" name="phone_number" placeholder="Nhập số điện thoại của bạn."
                                    value="{{ old('phone_number') }}">
                                @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Địa chỉ</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" cols="30" rows="2" placeholder="Nhập địa chỉ của bạn..." name="address" value="{{ old('address') }}"></textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-submit" type="submit">Xác nhận</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End modal --}}

    {{-- Modal Add address --}}
    <div class="reviews-modal modal theme-modal fade" id="add-address" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Thêm mới địa chỉ</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <form id="add-address-form" class="row g-3" action="{{ route('dashboard.addAddress') }}" method="POST">
                        @csrf
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Họ tên</label>
                                <input class="form-control @error('full_name') is-invalid @enderror" type="text" name="full_name" placeholder="Nhập tên đầy đủ của bạn."
                                    value="{{ old('full_name') }}">
                                @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Số điện thoại</label>
                                <input class="form-control @error('phone_number') is-invalid @enderror" type="number" name="phone_number" placeholder="Nhập số điện thoại của bạn."
                                    value="{{ old('phone_number') }}">
                                @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Địa chỉ</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" cols="30" rows="2" placeholder="Nhập địa chỉ của bạn..." name="address">{{ old('address') }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-submit" type="submit">Xác nhận</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End modal --}}

    {{-- Modal edit pass --}}
    <div class="reviews-modal modal theme-modal fade" id="edit-password" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Chỉnh sửa mật khẩu</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <form id="edit-password-form" action="{{ route('dashboard.editPassword') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="from-group">
                                    <label class="form-label">Mật khẩu hiện tại</label>
                                    <input class="form-control @error('current_password') is-invalid @enderror" type="password" name="current_password" id="current_password"
                                        placeholder="Nhập mật khẩu hiện tại của bạn.">
                                    @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-12">
                                <div class="from-group">
                                    <label class="form-label">Mật khẩu mới</label>
                                    <input class="form-control @error('new_password') is-invalid @enderror" type="password" id="new_password" name="new_password"
                                        placeholder="Nhập mật khẩu mới.">
                                    @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="from-group">
                                    <label class="form-label">Xác nhận mật khẩu</label>
                                    <input class="form-control @error('new_password_confirmation') is-invalid @enderror" type="password" name="new_password_confirmation"
                                        id="new_password_confirmation" placeholder="Nhập xác nhận mật khẩu.">
                                    @error('new_password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><button class="btn btn-submit" type="submit">Xác nhận</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End modal --}}

    {{-- Modal delete address --}}
    <div class="modal theme-modal fade confirmation-modal" id="delete-address-modal" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body"> <img class="img-fluid" src="../assets/images/gif/question.gif" alt="">
                    <h4>Bạn có chắc không?</h4>
                    <p>Địa chỉ sẽ bị xóa vĩnh viễn. Bạn có chắc chắn muốn làm điều này không?</p>
                    <div class="submit-button">
                        <button class="btn" type="submit" data-bs-dismiss="modal" aria-label="Close">Không</button>
                        <form id="delete-address-form" action="" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn" type="submit" data-bs-dismiss="modal" aria-label="Close">Có</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End modal --}}

    {{-- Modal bank-card --}}
    <div class="modal theme-modal fade confirmation-modal" id="bank-card-modal" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body"> <img class="img-fluid" src="../assets/images/gif/question.gif" alt="">
                    <h4>Are You Sure ?</h4>
                    <p>The object will establish a new permission for this object, inheriting the permission for the
                        use/group, preview.</p>
                    <div class="submit-button"> <button class="btn" type="submit" data-bs-dismiss="modal" aria-label="Close">No</button><button class="btn" type="submit"
                            data-bs-dismiss="modal" aria-label="Close">Yes</button></div>
                </div>
            </div>
        </div>
    </div>
    {{-- End modal --}}

    {{-- Modal vote --}}
    <div class="reviews-modal modal theme-modal fade" id="vote-order-detail-modal" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Write A Review</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="reviews-product">
                                <div> <img id="product_variant_image_vote_order_detail_modal" src="../assets/images/notification/1.jpg" alt="">
                                    <div>
                                        <h5 class="mb-0" id="product_name_vote_order_detail_modal">Denim Skirts
                                            Corset Blazer</h5>
                                        <span id="product_variant_name_vote_order_detail_modal">Red-M</span>
                                        <p id="price_vote_order_detail_modal">100.000đ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <div id="vote_by_star">Hiển thị sao ở đây</div>
                        </div>
                        <div class="col-12">
                            <div class="from-group"> <label class="form-label">Review Content</label>
                                <textarea class="form-control" id="content_vote" cols="30" rows="5" placeholder="Write your comments here..."></textarea>
                            </div>
                        </div>
                        <button class="btn btn-submit" type="submit" id="btn_submit_vote_order_detail">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal review --}}
    <div class="reviews-modal modal theme-modal fade" id="review-vote-order-detail-modal" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Review your vote</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="reviews-product">
                                <div> <img id="review_product_variant_image_vote_order_detail_modal" src="../assets/images/notification/1.jpg" alt="">
                                    <div>
                                        <h5 class="mb-0" id="review_product_name_vote_order_detail_modal">Denim
                                            Skirts Corset Blazer</h5>
                                        <span id="review_product_variant_name_vote_order_detail_modal">Red-M</span>
                                        <p id="review_price_vote_order_detail_modal">100.000đ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <div id="review_vote_by_star_modal">Hiển thị sao ở đây</div>
                        </div>
                        <div class="col-12">
                            <div class="from-group"> <label class="form-label">Review Content</label>
                                <textarea class="form-control" id="review_content_vote_modal" cols="30" rows="5" placeholder="Write your comments here..." disabled></textarea>
                            </div>
                        </div>
                        <button class="btn btn-submit" type="submit" id="btn_edit_vote_order_detail">Edit</button>
                        <div class="d-flex flex-row hidden justify-content-center" id="div_btn_confirm_edit_done_and_btn_cancel_edit">
                            <button class="btn btn-danger" id="btn_cancel_edit_vote_order_detail">Cancel</button>
                            <button class="btn btn-success ms-2" type="submit" data-bs-dismiss="" id="btn_submit_edit_vote_order_detail">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal edit bank --}}
    <div class="reviews-modal modal theme-modal fade" id="edit-bank-card" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Edit Card</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="from-group"> <label class="form-label">Card Holder Name</label><input class="form-control" type="text" name="name" value="Josephin water">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="from-group"> <label class="form-label">Card Number</label><input class="form-control" type="number" name="name" value="6458502535450851">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="from-group"> <label class="form-label">Expiry Date</label><input class="form-control" type="date" name="date"></div>
                        </div>
                        <div class="col-6">
                            <div class="from-group"> <label class="form-label">Cv</label><input class="form-control" type="number" name="cv" value="456"></div>
                        </div><button class="btn btn-submit" type="submit" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal add bank --}}
    <div class="reviews-modal modal theme-modal fade" id="add-bank-card" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Add Bank Card</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="from-group"> <label class="form-label">Card Holder Name</label><input class="form-control" type="text" name="name"
                                    placeholder="Josephin water..">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="from-group"> <label class="form-label">Card Number</label><input class="form-control" type="number" name="name"
                                    placeholder="645850253545XXXX..">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="from-group"> <label class="form-label">Expiry Date</label><input class="form-control" type="date" name="date"></div>
                        </div>
                        <div class="col-6">
                            <div class="from-group"> <label class="form-label">Cv</label><input class="form-control" type="number" name="cv" placeholder="456"></div>
                        </div><button class="btn btn-submit" type="submit" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<!-- End container content -->
<div class="container-spinner position-fixed d-flex justify-content-center align-items-center w-100 h-100 hidden">
    <div class="overlay"></div>
    <div class="spinner-border text-primary" id="loadingSpinner" role="status">
    </div>
</div>
@endsection

@section('script-libs')
<script src="{{ asset('js/user/dashboard.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Lấy tất cả các tab
        const tabs = document.querySelectorAll('#v-pills-tab button');
        // Lấy tab hiện tại từ URL nếu có
        const currentTab = new URLSearchParams(window.location.search).get('tab');
        if (currentTab) {
            const activeTab = document.querySelector(`[data-bs-target="#${currentTab}"]`);
            if (activeTab) {
                // Bỏ 'active' khỏi tất cả các tab và kích hoạt tab hiện tại
                tabs.forEach(tab => tab.classList.remove('active'));
                activeTab.classList.add('active');
                const tabContent = document.querySelector(`#${currentTab}`);
                if (tabContent) {
                    document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show',
                        'active'));
                    tabContent.classList.add('show', 'active');
                }
            }
        }
        // Thêm sự kiện cho mỗi tab để cập nhật URL khi nhấp
        tabs.forEach(tab => {
            tab.addEventListener("click", function() {
                const target = this.getAttribute("data-bs-target").substring(
                    1); // Lấy id của tab
                const url = new URL(window.location);
                url.searchParams.set("tab", target);
                window.history.replaceState(null, "", url); // Cập nhật URL
            });
        });
    });
</script>
@endsection