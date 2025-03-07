@extends('user.layouts.master')

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
                        <h4>Bộ sản phẩm</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"> <a href="{{ route('home-shop') }}">Home</a></li>
                            <li class="breadcrumb-item active"> <a href="">Bộ sản phẩm</a></li>
                        </ul>
                    </div>
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
                            <div class="search-box">
                                <input type="search" id="search-input" name="text" placeholder="Tìm kiếm sản phẩm..."
                                    onkeyup="filterProducts()">
                                <i class="iconsax" data-icon="search-normal-2"></i>
                            </div>

                            <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseTwo">
                                <div class="accordion-body">
                                    <ul class="catagories-side theme-scrollbar">
                                        @foreach ($listCate as $category)
                                            <li style="list-style-type: none; display: flex; align-items: center;">
                                                <div style="margin-left: {{ $category->level * 20 }}px; flex-grow: 1;">
                                                    <!-- Lùi lại cho danh mục con -->
                                                    <input class="custom-checkbox" id="category{{ $category->id }}"
                                                        type="checkbox" name="categories[]" value="{{ $category->id }}"
                                                        data-parent="{{ $category->parent_category_id }}"
                                                        data-id="{{ $category->id }}"
                                                        onchange="toggleChildCategories({{ $category->id }})">
                                                    <label for="category{{ $category->id }}">{{ $category->name }}</label>
                                                </div>
                                                @if ($category->level === 1)
                                                    <!-- Nếu là danh mục cha -->
                                                    <span style="margin-left: 10px;"></span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>





                        </div>
                    </div>
                </div>

                <div class="col-xl-9">
                    <div class="sticky">
                        <div class="top-filter-menu">
                            <div>
                                <a class="filter-button btn">
                                    <h6> <i class="iconsax" data-icon="filter"></i>Filter Menu </h6>
                                </a>
                                <div class="category-dropdown">
                                    <label for="cars">Sort By :</label>
                                    <select class="form-select" id="cars" name="carlist">
                                        <option value="">Best selling</option>
                                        <option value="">Popularity</option>
                                        <option value="">Featured</option>
                                        <option value="">Alphabetically, Z-A</option>
                                        <option value="">High - Low Price</option>
                                        <option value="">% Off - Hight To Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="product-tab-content ratio1_3">
                            <div class="row-cols-lg-4 row-cols-md-3 row-cols-2 grid-section view-option row g-3 g-xl-4">
                                <!-- Sản phẩm sẽ được hiển thị ở đây -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/user/collection.js') }}"></script>
@endsection









{{-- @extends('user.layouts.master')



@section('content')
    <div class="tap-top">
        <div><i class="fa-solid fa-angle-up"></i></div>
    </div>
    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Bộ sản phẩm</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"><a href="{{ route('home-shop') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="">Bộ sản phẩm</a></li>
                        </ul>
                    </div>
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
                            <div class="search-box">
                                <input type="search" id="search-input" placeholder="Search here...">
                                <i class="iconsax" data-icon="search-normal-2" onclick="filterProducts()"></i>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header tags-header">
                                    <button class="accordion-button"><span>Applied Filters</span><span>view all</span></button>
                                </h2>
                                <div class="accordion-collapse collapse show" id="panelsStayOpen-collapse">
                                    <div class="accordion-body">
                                        <ul class="tags">
                                            <li><a href="#">T-Shirt <i class="iconsax" data-icon="add"></i></a></li>
                                            <li><a href="#">Handbags<i class="iconsax" data-icon="add"></i></a></li>
                                            <li><a href="#">Trends<i class="iconsax" data-icon="add"></i></a></li>
                                            <li><a href="#">Minimog<i class="iconsax" data-icon="add"></i></a></li>
                                            <li><a href="#">Denim<i class="iconsax" data-icon="add"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseEight">
                                        <span>Collections</span>
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseEight">
                                    <div class="accordion-body">
                                        <ul class="collection-list">
                                            <li>
                                                <input class="custom-checkbox" id="category10" type="checkbox" name="text" onclick="filterByCategory()">
                                                <label for="category10">All products</label>
                                            </li>
                                            <li>
                                                <input class="custom-checkbox" id="category11" type="checkbox" name="text" onclick="filterByCategory()">
                                                <label for="category11">Best sellers</label>
                                            </li>
                                            <li>
                                                <input class="custom-checkbox" id="category12" type="checkbox" name="text" onclick="filterByCategory()">
                                                <label for="category12">New arrivals</label>
                                            </li>
                                            <li>
                                                <input class="custom-checkbox" id="category13" type="checkbox" name="text" onclick="filterByCategory()">
                                                <label for="category13">Accessories</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo">
                                        <span>Categories</span>
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseTwo">
                                    <div class="accordion-body">
                                        <ul class="catagories-side theme-scrollbar">
                                             @foreach ($categories as $category)
                                                <li>
                                                    <input class="custom-checkbox" id="category{{ $category->id }}" type="checkbox" onclick="filterByCategory()">
                                                    <label for="category{{ $category->id }}">{{ $category->name }}</label>
                                                </li>
                                            @endforeach
</ul>
</div>
</div>
</div>
<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour">
            <span>Filter</span>
        </button>
    </h2>
    <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseFour">
        <div class="accordion-body">
            <div class="range-slider">
                <input class="range-slider-input" type="range" min="0" max="120000" step="1"
                    value="20000">
                <input class="range-slider-input" type="range" min="0" max="120000" step="1"
                    value="100000">
                <div class="range-slider-display"></div>
            </div>
        </div>
    </div>
</div>
<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne">
            <span>Color</span>
        </button>
    </h2>
    <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseOne">
        <div class="accordion-body">
            <div class="color-box">
                <ul class="color-variant">
                    <li class="bg-color-purple"></li>
                    <li class="bg-color-blue"></li>
                    <li class="bg-color-red"></li>
                    <li class="bg-color-yellow"></li>
                    <li class="bg-color-coffee"></li>
                    <li class="bg-color-chocolate"></li>
                    <li class="bg-color-brown"></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSix">
            <span>Availability</span>
        </button>
    </h2>
    <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseSix">
        <div class="accordion-body">
            <ul class="catagories-side">
                <li>
                    <input class="custom-radio" id="category9" type="radio" checked="checked" name="radio">
                    <label for="category9">In Stock(3)</label>
                </li>
                <li>
                    <input class="custom-radio" id="category14" type="radio" name="radio">
                    <label for="category14">Out Of Stock(1)</label>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="accordion-item">
    <h2 class="accordion-header tags-header">
        <button class="accordion-button"><span>Shipping & Delivery</span><span></span></button>
    </h2>
    <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseSeven">
        <div class="accordion-body">
            <ul class="widget-card">
                <li><i class="iconsax" data-icon="truck-fast"></i>
                    <div>
                        <h6>Free Shipping</h6>
                        <p>Free shipping for all US order</p>
                    </div>
                </li>
                <li><i class="iconsax" data-icon="headphones"></i>
                    <div>
                        <h6>Support 24/7</h6>
                        <p>Free shipping for all US order</p>
                    </div>
                </li>
                <li><i class="iconsax" data-icon="exchange"></i>
                    <div>
                        <h6>30 Days Return</h6>
                        <p>Free shipping for all US order</p>
                    </div> --}}
{{-- </li>
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
                <a class="filter-button btn">
                    <h6><i class="iconsax" data-icon="filter"></i>Filter Menu</h6>
                </a>
                <div class="category-dropdown">
                    <label for="cars">Sort By:</label>
                    <select class="form-select" id="sort-select" name="carlist" onchange="filterProducts()">
                        <option value="">Best selling</option>
                        <option value="">Popularity</option>
                        <option value="">Featured</option>
                        <option value="">Alphabetically, Z-A</option>
                        <option value="">High - Low Price</option>
                        <option value="">% Off - High To Low</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="product-list" class="product-tab-content ratio1_3">
            <div class="row-cols-lg-4 row-cols-md-3 row-cols-2 grid-section view-option row g-3 g-xl-4"> --}}
<!-- Sản phẩm sẽ được hiển thị ở đây -->
{{-- Sản phẩm sẽ được hiển thị bằng AJAX --}}
{{-- </div>
        </div>
    </div>
</div>
</div>
</div>
</section>
@endsection --}}

{{-- @section('script-libs')
<script src="{{ asset('js/user/collection.js') }}"></script>
@endsection  --}}
