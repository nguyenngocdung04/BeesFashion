@extends('user.layouts.master')

@section('css-libs')
    <link rel="stylesheet" href="{{ asset('css/user/filterProduct.css') }}">
@endsection

@section('content')
    <div class="tap-top">
        <div><i class="fa-solid fa-angle-up"></i></div>
    </div>
    <span class="cursor">
        <span class="cursor-move-inner">
            <span class="cursor-inner"></span>
        </span>
        <span class="cursor-move-outer">
            <span class="cursor-outer"></span>
        </span>
    </span>

    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Bộ sưu tập</h4>
                    </div>
                    {{-- <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"> <a href="{{ route('/') }}">Home</a></li>
                            <li class="breadcrumb-item active"> <a href="{{ route('/') }}">Bộ sản phẩm</a></li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>

    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="row">
                <div class="col-3">
                    <div class="custom-accordion theme-scrollbar left-box">
                        <div class="left-accordion">
                            <h5>Back </h5><i class="back-button fa-solid fa-xmark"></i>
                        </div>
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            {{-- Hiển thị những phần đã chọn bên dưới --}}
                            <div class="div_selected_items d-flex flex-column">
                                <div id="title_selected">

                                </div>
                                <div id="selected_items" class="row ps-2 pe-2 mb-3 ">

                                </div>
                            </div>
                            {{-- tìm kiếm sản phẩm theo tên --}}
                            <div class="search-box">
                                <input type="search" id="search-input" name="text" placeholder="Tìm kiếm sản phẩm...">
                                <i class="iconsax" data-icon="search-normal-2"></i>
                            </div>
                            {{-- lọc theo khoảng giá --}}

                            {{-- <div class="accordion-item">
                                <h2 class="accordion-header"><button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseFour"><span>Sắp xếp khoảng
                                            giá</span></button></h2>
                                <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseFour">
                                    <div class="accordion-body">
                                        <div class="range-slider">
                                            <input class="range-slider-input" type="range" min="0"
                                                max="{{ $maxPriceProduct }}" step="1" value="0">
                                            <input class="range-slider-input" type="range" min="0"
                                                max="{{ $maxPriceProduct }}" step="1" value="{{ $maxPriceProduct }}">
                                            <div class="range-slider-display"></div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- Lọc theo danh mục --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsCateOpen-collapseEight">
                                        <span>Danh mục</span>
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse show" id="panelsCateOpen-collapseTwo">
                                    <div class="accordion-body">
                                        <ul class="catagories-side theme-scrollbar">
                                            @foreach ($listCategory as $parentCategory)
                                                <li style="list-style-type: none; display: flex; align-items: center;">
                                                    <div style="margin-left: 0px; flex-grow: 1;" id="category_checkbox">
                                                        <!-- Hiển thị danh mục cha -->
                                                        <input class="category-checkbox custom-checkbox"
                                                            id="category{{ $parentCategory->id }}" type="checkbox"
                                                            name="categories[]" value="{{ $parentCategory->id }}"
                                                            data-parent="{{ $parentCategory->parent_category_id }}"
                                                            data-id="{{ $parentCategory->id }}"
                                                            onchange="toggleChildCategories({{ $parentCategory->id }})">
                                                        <label
                                                            for="category{{ $parentCategory->id }}">{{ $parentCategory->name }}</label>
                                                    </div>
                                                </li>

                                                <!-- Hiển thị danh mục con của danh mục cha hiện tại -->
                                                @if ($parentCategory->categoryChildrent)
                                                    @foreach ($parentCategory->categoryChildrent as $childCategory)
                                                        <li
                                                            style="list-style-type: none; display: flex; align-items: center;">
                                                            <div style="margin-left: 20px; flex-grow: 1;"
                                                                id="category_checkbox">
                                                                <!-- Lùi lại cho danh mục con -->
                                                                <input class="category-checkbox custom-checkbox"
                                                                    id="category{{ $childCategory->id }}" type="checkbox"
                                                                    name="categories[]" value="{{ $childCategory->id }}"
                                                                    data-parent="{{ $childCategory->parent_category_id }}"
                                                                    data-id="{{ $childCategory->id }}"
                                                                    onchange="toggleChildCategories({{ $childCategory->id }})">
                                                                <label
                                                                    for="category{{ $childCategory->id }}">{{ $childCategory->name }}</label>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>


                            <!-- Phần lọc theo thương hiệu -->

                            <div class="accordion-item">
                                <h2 class="accordion-header"><button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsBrandOpen-collapseTwo"><span>Thương hiệu</span></button>
                                </h2>
                                <div class="accordion-collapse collapse show" id="panelsBrandOpen-collapseTwo">
                                    <div class="accordion-body">
                                        <ul class="theme-scrollbar">
                                            @foreach ($listBrand as $value)
                                                <li style="list-style-type: none; display: flex; align-items: center;">
                                                    <input class="brand-checkbox custom-checkbox"
                                                        id="brand{{ $value->id }}" type="checkbox" name="brands[]"
                                                        value="{{ $value->id }}"data-id="{{ $value->id }}">
                                                    <label for="brand{{ $value->id }}"
                                                        style="margin-left: 8px; display: flex; align-items: center; height: 100%;">
                                                        {{ $value->name }}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- màu --}}
                            {{-- <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseOne">
                                        <span>Màu</span>
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseOne">
                                    <div class="accordion-body">
                                        <div class="color-box">
                                            <ul class="color-variant">
                                                @foreach ($listColor as $value)
                                                    @if ($value->value != '')
                                                        <!-- Kiểm tra nếu giá trị màu không trống -->
                                                        <li class="color-option" data-color="{{ $value->value }}"
                                                            style="background-color: {{ $value->value }};">
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}


                            {{-- <div class="accordion-item">
                                <h2 class="accordion-header"><button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseSix"><span>Availability</span></button>
                                </h2>
                                <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseSix">
                                    <div class="accordion-body">
                                        <ul class="catagories-side">
                                            <li> <input class="custom-radio" id="category9" type="radio"
                                                    checked="checked" name="radio"><label for="category9">In
                                                    Stock(3)</label></li>
                                            <li> <input class="custom-radio" id="category14" type="radio"
                                                    name="radio"><label for="category14">Out Of Stock(1)</label></li>
                                        </ul>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="accordion-item">
                                <h2 class="accordion-header tags-header"><button class="accordion-button"><span>Vận chuyển
                                            & Giao hàng</span><span></span></button></h2>
                                <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseSeven">
                                    <div class="accordion-body">
                                        <ul class="widget-card">
                                            <li><i class="iconsax" data-icon="truck-fast"></i>
                                                <div>
                                                    <h6>Miễn phí vận chuyển</h6>
                                                    <p>Miễn phí vận chuyển cho tất cả các đơn hàng tại Việt Nam</p>
                                                </div>
                                            </li>
                                            <li><i class="iconsax" data-icon="headphones"></i>
                                                <div>
                                                    <h6>Hỗ trợ 24/7</h6>
                                                    <p>Miễn phí vận chuyển cho tất cả các đơn hàng tại Việt Nam</p>
                                                </div>
                                            </li>
                                            <li><i class="iconsax" data-icon="exchange"></i>
                                                <div>
                                                    <h6>30 ngày hoàn trả</h6>
                                                    <p>Miễn phí vận chuyển cho tất cả các đơn hàng tại Việt Nam</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9">
                    <div class="sticky">
                        <div class="top-filter-menu">
                            <div>
                                <!-- Các ô sắp xếp theo tiêu chí -->
                                <label class="m-2" for="priceSort">Sắp xếp theo :</label>
                                <div class="d-flex">
                                    <div class="filter-option m-3">
                                        <button class="btn btn-outline-secondary " id="filterBestSelling">Bán chạy
                                            nhất</button>
                                    </div>
                                    <div class="filter-option m-3">
                                        <button class="btn btn-outline-secondary" id="filterNewArrivals">Mới nhất</button>
                                    </div>
                                </div>
                                <!-- Dropdown select cho sắp xếp theo giá -->
                                {{-- <div class="category-dropdown m-3">
                                    <select class="form-select" id="priceSort" name="priceSort" style="width: 200px;">
                                        <option value="price_default">Giá</option>
                                        <option id="price_asc" value="price_asc">Giá : Thấp - Cao</option>
                                        <option id="price_desc" value="price_desc">Giá : Cao - Thấp</option>
                                    </select>
                                </div> --}}
                            </div>
                        </div>
                        <div class="product-tab-content ratio1_3">
                            <div
                                class="row-cols-lg-4 row-cols-md-3 row-cols-2 grid-section view-option row g-3 g-xl-4 align-items-center">
                                {{-- Sản phẩm sẽ được hiển thị ở đây --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal add-to-cart  --}}
    <div class="modal theme-modal fade" id="addtocart" tabindex="-1" role="dialog" aria-modal="true"
            data-product-id="" data-variant-id="">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"
                            id="close_modal"></button>
                        <div class="row">
                            <div class="col-lg-5 col-xs-12">
                                <div class="quick-view-img">
                                    <div class="swiper modal-slide-1">
                                        <div class="swiper-wrapper ratio_square-2">
                                            <div class="swiper-slide">
                                                <img class="img-fluid" id="product-image" src=""
                                                    alt="Product Image">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper modal-slide-2">
                                        <div class="swiper-wrapper ratio3_4">
                                            <!-- Dữ liệu các ảnh khác sẽ được cập nhật qua JS -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 rtl-text">
                                <div class="product-right">
                                    <h4 id="product-name"></h4>
                                    <p id="product-sku"></p>
                                    <h4 id="product-price" style="color: #ba372a"></h4>
                                    <div class="selected-variant d-flex">
                                        <p id="total-stock" class="me-1" style="color: rgb(0, 181, 120)"></p> sản phẩm có sẵn
                                    </div>

                                    <!-- Hiển thị danh sách thuộc tính -->
                                    <div class="blink-border attributes-container" id="attributes-container">
                                        <!-- Các thuộc tính sẽ được cập nhật qua JS -->
                                    </div>
                                    <div class="border-product">

                                    </div>
                                    <div class="product-description">
                                        <h6 class="product-title">Số lượng</h6>
                                        <div class="quantity">
                                            <button class="reduce" type="button"><i
                                                    class="fa-solid fa-minus"></i></button>
                                            <input type="number" id="quantity" value="1" min="1"
                                                max="10">
                                            <button class="increment" type="button"><i
                                                    class="fa-solid fa-plus"></i></button>
                                           
                                        </div>
                                    </div>

                                    <div class="product-buttons">
                                        <a class="btn btn-solid" href="#" id="add-to-cart-btn">Thêm vào giỏ
                                            hàng</a>
                                        <a class="btn btn-solid" href="#"
                                            id="btn_view_detail_of_quick_view_product">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- End model add-to-cart  --}}
@endsection

@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/user/filterProduct.js') }}"></script>
@endsection
