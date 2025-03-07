<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Bees Fashion</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('assets/images/icons/dashboard.svg') }}" alt="img">
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>
    @if (Auth::user()->role === 'admin')
    <!-- Thống kê -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStatistics" aria-expanded="true" aria-controls="collapseStatistics">
            <img src="{{ asset('assets/images/icons/statistical.svg') }}" alt="img">
            <span>Thống kê</span>
        </a>
        <div id="collapseStatistics" class="collapse" aria-labelledby="headingStatistics" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng:</h6>
                <a class="collapse-item" href="{{ route('admin.statistics.revenueProduct') }}">Doanh thu sản phẩm</a>
                <a class="collapse-item" href="{{ route('admin.statistics.revenueBrand') }}">Doanh thu thương hiệu</a>
                <a class="collapse-item" href="{{ route('admin.statistics.revenueCustomer') }}">Doanh thu khách hàng</a>
                <a class="collapse-item" href="{{ route('admin.statistics.cart-statistics') }}">Sản phẩm giỏ hàng</a>
                <a class="collapse-item" href="{{ route('admin.statistics.product_views') }}">Lượt xem sản phẩm</a>
            </div>
        </div>
    </li>
    @endif
    <!-- Quản lý danh mục -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <img src="{{ asset('assets/images/icons/category.svg') }}" alt="img">
            <span>Quản lý danh mục</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng:</h6>
                <a class="collapse-item" href="{{ route('admin.categories.index') }}">Danh sách</a>
                <a class="collapse-item" href="{{ route('admin.categories.create') }}">Thêm</a>
            </div>
        </div>
    </li>

    <!-- Quản lý sản phẩm -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <img src="{{ asset('assets/images/icons/product.svg') }}" alt="img">
            <span>Quản lý sản phẩm</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng</h6>
                <a class="collapse-item" href="{{ route('admin.products.index') }}">Danh sách</a>
                <a class="collapse-item" href="{{ route('admin.products.create') }}">Thêm</a>
            </div>
        </div>
    </li>

    {{-- Quản lý vouchers --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVouchers" aria-expanded="true" aria-controls="collapseVouchers">
            <img src="{{ asset('assets/images/icons/vouchers.svg') }}" alt="img">
            <span>Quản lý vouchers</span>
        </a>
        <div id="collapseVouchers" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng</h6>
                <a class="collapse-item" href="{{ route('admin.vouchers.index') }}">Danh sách</a>
                {{-- <a class="collapse-item" href="{{ route('admin.banner.create') }}">Thêm</a> --}}
            </div>
        </div>
    </li>

    {{-- Quản lý đơn hàng --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrder" aria-expanded="true" aria-controls="collapseOrder">
            <img src="{{ asset('assets/images/icons/sales1.svg') }}" alt="img">
            <span>Quản lý đơn hàng</span>
        </a>
        <div id="collapseOrder" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng</h6>
                <a class="collapse-item" href="{{ route('admin.orders.index') }}">Đơn hàng</a>
                {{-- <a class="collapse-item" href="{{ route('admin.banner.create') }}">Thêm</a> --}}
            </div>
        </div>
    </li>

    {{-- Quản lý đánh giá --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRatings" aria-expanded="true" aria-controls="collapseRatings">
            <i class="fa-regular fa-comment-dots text-light fa-5xl"></i>
            <span>Quản lý đánh giá</span>
        </a>
        <div id="collapseRatings" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng</h6>
                <a class="collapse-item" href="{{ route('admin.ratings.index') }}">Danh sách</a>
            </div>
        </div>
    </li>

    {{-- Liên hệ --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseContacts" aria-expanded="true" aria-controls="collapseContacts">
            <i class="fa-solid fa-phone text-light fa-5xl"></i>
            <span>Liên hệ</span>
        </a>
        <div id="collapseContacts" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng</h6>
                <a class="collapse-item" href="{{ route('admin.contacts.index') }}">Danh sách</a>
            </div>
        </div>
    </li>

    {{-- Quản lý thuộc tính --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
            <img src="{{ asset('assets/images/icons/attribute.svg') }}" alt="img">
            <span>Quản lý thuộc tính</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng:</h6>
                {{-- <a class="collapse-item" href="{{ route('admin.attribute_values.show', $attributeIds->id) }}">Gía trị thuộc tính</a> --}}
                <a class="collapse-item" href="{{ route('admin.attributes.create') }}">Thuộc tính</a>
                <a class="collapse-item" href="{{ route('admin.attribute_types.create') }}">Loại thuộc tính</a>
                {{-- <a class="collapse-item" href="{{route('admin.attribute_values.create')}}">Thêm dl thuộc tính</a> --}}

            </div>
        </div>
    </li>

    {{-- Quản lý banner --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBanners" aria-expanded="true" aria-controls="collapseBanners">
            <img src="{{ asset('assets/images/icons/banner.svg') }}" alt="img">

            <span>Quản lý banner</span>
        </a>
        <div id="collapseBanners" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng</h6>
                <a class="collapse-item" href="{{ route('admin.banner.index') }}">Danh sách</a>
                <a class="collapse-item" href="{{ route('admin.banner.create') }}">Thêm</a>
            </div>
        </div>
    </li>

    {{-- quản lý thương hiệu(brand) --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBrands" aria-expanded="true" aria-controls="collapseBrands">
            <img src="{{ asset('assets/images/icons/brand.svg') }}" alt="img">
            <span>Quản lý thương hiệu</span>
        </a>
        <div id="collapseBrands" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng</h6>
                <a class="collapse-item" href="{{ route('admin.brands.index') }}">Danh sách</a>
                <a class="collapse-item" href="{{ route('admin.brands.create') }}">Thêm</a>
            </div>
        </div>
    </li>

    {{-- Quản lý khách hàng --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomers" aria-expanded="true" aria-controls="collapseCustomers">
            <img src="{{ asset('assets/images/icons/users1.svg') }}" alt="img">
            <span>Quản lý khách hàng</span>
        </a>
        <div id="collapseCustomers" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng</h6>
                <a class="collapse-item" href="{{ route('admin.customers.index') }}">Danh sách</a>
            </div>
        </div>
    </li>

    {{-- Kiểm tra nếu là admin --}}
    @if (Auth::user()->role === 'admin')
        {{-- Quản lý nhân viên --}}
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStaffs" aria-expanded="true" aria-controls="collapseStaffs">
                <img src="{{ asset('assets/images/icons/staff.svg') }}" alt="img">
                <span>Quản lý nhân viên</span>
            </a>
            <div id="collapseStaffs" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Danh sách chức năng</h6>
                    <a class="collapse-item" href="{{ route('admin.staffs.index') }}">Danh sách</a>
                    <a class="collapse-item" href="{{ route('admin.staffs.create') }}">Thêm</a>
                </div>
            </div>
        </li>

        {{-- Quản lý manager setting --}}
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseManagers" aria-expanded="true" aria-controls="collapseManagers">
                <img src="{{ asset('assets/images/icons/function.svg') }}" alt="img">
                <span>Quản lý chức năng</span>
            </a>
            <div id="collapseManagers" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Danh sách chức năng</h6>
                    <a class="collapse-item" href="{{ route('admin.managerSettings.index') }}">Danh sách</a>
                    <a class="collapse-item" href="{{ route('admin.managerSettings.create') }}">Thêm</a>
                </div>
            </div>
        </li>
    @endif

    {{-- Lịch sử nhập hàng --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHistory" aria-expanded="true" aria-controls="collapseHistory">
            <img src="{{ asset('assets/images/icons/import.svg') }}" alt="img">
            <span>Lịch sử nhập hàng</span>
        </a>
        <div id="collapseHistory" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng</h6>
                <a class="collapse-item" href="{{ route('admin.import_history.index') }}">Danh sách</a>
                {{-- <a class="collapse-item" href="{{ route('admin.banner.create') }}">Thêm</a> --}}
            </div>
        </div>
    </li>

    {{-- <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
           aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    {{-- <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="{{asset('theme/admin/img/undraw_rocket.svg')}}" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div> --}}

</ul>
