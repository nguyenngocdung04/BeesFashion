<!-- Start header -->
<header>
    {{-- <div class="top_header">
        <p>Free Coupe Code: Summer Sale On Selected items Use:<span>NEW 26</span><a href="{{ route('product') }}">SHOP
                NOW</a></p>
    </div> --}}
    <div class="box-header">
        <div class="custom-container container header-1">
            <div class="row">
                <!-- Reponsive mobile -->
                <div class="col-12 p-0">
                    <div class="mobile-fix-option">
                        <ul>
                            <li> <a href="{{ route('/') }}"><i class="iconsax" data-icon="home-1"></i>Home</a>
                            </li>
                            <li><a href="#"><i class="iconsax" data-icon="search-normal-2"></i>Search</a></li>
                            <li class="shopping-cart"> <a href="#"><i class="iconsax"
                                        data-icon="shopping-cart"></i>Cart</a></li>
                            <li><a href="#"><i class="iconsax" data-icon="heart"></i>My Wish</a></li>
                            <li> <a href="#"><i class="iconsax" data-icon="user-2"></i>Account</a></li>
                        </ul>
                    </div>

                    <div class="offcanvas offcanvas-start" id="staticBackdrop" data-bs-backdrop="static" tabindex="-1"
                        aria-labelledby="staticBackdropLabel">
                        <div class="offcanvas-header">
                            <h3 class="offcanvas-title" id="staticBackdropLabel">Offcanvas</h3>
                            <button class="btn-close" type="button" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div></div>
                            I will not close if you click outside of me.
                        </div>
                    </div>
                </div>
                <!-- End reponsive mobile -->

                <!-- Dektop -->
                <div class="col-12">
                    <div class="main-menu">
                        <a class="brand-logo" href="{{ route('/') }}"> <img class="img-fluid for-light"
                                src="{{ asset('assets/images/logo/logo-Bee.png') }}" alt="logo"><img
                                class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo-Bee.png') }}"
                                alt="logo"></a>

                        <nav id="main-nav">

                            <ul class="nav-menu sm-horizontal theme-scrollbar" id="sm-horizontal">
                                <li class="mobile-back" id="mobile-back">Back<i class="fa-solid fa-angle-right ps-2"
                                        aria-hidden="true"></i></li>
                                <li>
                                    <a class="nav-link fw-semibold" href="{{ route('/') }}">Trang chủ</a>
                                </li>
                                {{-- <li>
                                    <a class="nav-link" href="product-select.html">{{ $cate->name }}</a>
                                    </li> --}}
                                <li>
                                    <a class="nav-link fw-semibold" href="{{ route('product') }}">Bộ sưu tập</a>
                                    <ul class="nav-submenu">
                                        @foreach ($categoryLimit as $parentCategory)
                                            <li class="has-submenu">
                                                <a href="{{ route('product', ['category' => $parentCategory->id]) }}">{{ $parentCategory->name }}
                                                </a>
                                                <ul class="nav-childmenu">
                                                    @include('user.layouts.child_menu', [
                                                        'parentCategory' => $parentCategory,
                                                    ])
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li>
                                    <a class="nav-link fw-semibold" href="{{ route('blog') }}">Bài viết</a>
                                </li>
                                <li>
                                    <a class="nav-link fw-semibold" href="{{ route('about-us') }}">Về chúng tôi</a>
                                </li>
                                <li>
                                    <a class="nav-link fw-semibold" href="{{ route('contact') }}">Liên hệ</a>
                                </li>

                                {{-- <li>
                                    <a class="nav-link" href="product-detail.html">Product <span> <i
                                                class="fa-solid fa-angle-down"></i></span></a>
                                    </li>
                                <li>
                                        <a class="nav-link" href="#">Page <span> <i
                                                    class="fa-solid fa-angle-down"></i></span></a>
                                        <ul class="nav-submenu">
                                            <li> <a href="search.html">Search</a></li>
                                            <li> <a href="wishlist.html">Wishlist</a></li>
                                            <li> <a href="faq.html">Faq</a></li>
                                            <li> <a href="dashboard.html">My Dashboard <span
                                                        class="badge-sm theme-default">new</span></a></li>
                                            <li> <a href="order-success.html">Order Success</a></li>
                                            <li> <a href="order-tracking.html">Order Tracking</a></li>

                                    </li>
                                <li> <a href="check-out.html">Check Out</a></li>
                                    <li> <a href="about-us.html">About Us</a></li>
                                    <li> <a href="404.html">404 </a></li>
                                    <li> <a href="cart.html">cart </a></li>
                                    <li> <a href="login.html"> Login <span class="badge-sm danger-color animated">Hot
                                            </span></a></li> --}}
                                {{-- <li> <a href="forget-password.html"> Forgot Password </a></li>
                                    <li> <a href="sign-up.html"> Sign Up </a></li> --}}
                                {{-- </ul>
                                    </li> --}}
                                {{-- <li>
                                    <a class="nav-link" href="blog.html">Blog<span> <i
                                                class="fa-solid fa-angle-down"></i></span></a>
                                </li>
                                <li> <a class="nav-link" href="contact.html">Contact </a></li> --}}
                            </ul>

                        </nav>

                        <div class="sub_header">
                            <div class="toggle-nav" id="toggle-nav"><i
                                    class="fa-solid fa-bars-staggered sidebar-bar"></i>
                            </div>
                            <ul class="justify-content-end">
                                <li> <button href="" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop"
                                        aria-controls="offcanvasTop"><i class="iconsax"
                                            data-icon="search-normal-2"></i></button></li>
                                <li> <a href="{{ route('wishlist') }}"><i class="iconsax wishlist"
                                            data-icon="heart"></i><span
                                            class="cart_qty_cls">{{ $wishCount ?? 0 }}</span></a></li>
                                @guest
                                    <li class="onhover-div">
                                        <a href="#"><i class="iconsax" data-icon="user-2"></i></a>
                                        <div class="login-register-box">
                                            <h2>CHÀO MỪNG QUÝ KHÁCH<br>ĐẾN VỚI BEESFASHION</h2>
                                            <p class="title-login">Đăng nhập tài khoản của Quý Khách</p>
                                            @if (Route::has('login'))
                                                <a class="btn-login" href="{{ route('login') }}">ĐĂNG NHẬP</a>
                                            @endif
                                            <hr>
                                            <h5 class="title-register mt-3">ĐĂNG KÍ THÀNH VIÊN</h5>
                                            @if (Route::has('register'))
                                                <a class="btn-register" href="{{ route('register') }}">ĐĂNG KÝ</a>
                                            @endif
                                        </div>
                                    </li>
                                @else
                                    <li class="onhover-div">
                                        <a href="{{ route('dashboard') }}"><i class="iconsax" data-icon="user-2"></i></a>
                                        <div class="user-box">
                                            <div class="user-info">
                                                <img src="{{ asset('assets/images/user/user-icon.jpg') }}" alt="Avatar"
                                                    class="user-avatar" />
                                                <h3>{{ Auth::user()->full_name ? Auth::user()->full_name : Auth::user()->username }}
                                                </h3>
                                            </div>
                                            <hr>
                                            <div class="user-actions">
                                                <div>
                                                    <a class="act-dash" href="{{ route('dashboard') }}"><i
                                                            class="fa-solid fa-house-user"></i>Tài khoản của tôi</a>
                                                </div>
                                                <div>
                                                    <a class="act-logout" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modal-logout" title="Logout" tabindex="0">
                                                        <i class="fa-solid fa-right-from-bracket"></i>Đăng xuất</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endguest

                                <li class="onhover-div shopping-cart">
                                    <a class="p-0" href="{{ route('cart') }}">
                                        <div class="shoping-prize position-relative">
                                            <i class="iconsax pe-2" data-icon="basket-2"></i>
                                            <span class="cart-count">{{ $cartCount ?? 0 }}</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End header -->
<script>
    // Lắng nghe sự kiện nhấn Enter trên ô input tìm kiếm
    document.getElementById('search-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });

    // Lắng nghe sự kiện click vào biểu tượng tìm kiếm
    document.getElementById('search-icon').addEventListener('click', function() {
        performSearch();
    });

    // Hàm thực hiện tìm kiếm và chuyển hướng tới trang sản phẩm
    function performSearch() {
        const searchValue = document.getElementById('search-input-of-header').value.trim(); // Lấy giá trị từ ô input
        console.log(searchValue);

        if (searchValue) {
            var current_url = new URL(window.location.href);
            var search_param = current_url.searchParams.has('search');
            if (search_param) {
                current_url.searchParams.delete('search');
                window.history.replaceState({}, '', current_url);
            }


            // Chuyển hướng đến trang product và thêm query string 'name' với từ khóa tìm kiếm
            window.location.href = '/product?search=' + encodeURIComponent(searchValue);
        }
    }
</script>
