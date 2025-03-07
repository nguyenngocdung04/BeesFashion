@extends('admin.layouts.master')
@section('title')
    Dashboard
@endsection

@section('content')
    <!-- Main Content -->
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Shop</h6>
            </div>
            <div class="row mx-2 mt-4">
                <!-- Tổng sản phẩm của shop -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 ">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Tổng sản phẩm
                                    </div>
                                    <div class="h5 mb-1 font-weight-bold text-gray-800" id="totalProducts">{{ $totalProducts ?? 0 }}</div>
                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.products.index') }}">Xem chi tiết<i class="fas fa-arrow-right ml-1 fa-sm"></i></a>
                                </div>
                                <div class=" fa-2x text-primary">
                                    <i class="fa-solid fa-shirt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tổng lượt xem -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 ">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Tổng lượt xem
                                    </div>
                                    <div class="h5 mb-1 font-weight-bold text-gray-800" id="totalView">{{ $totalView ?? 0 }}</div>
                                    <a class="btn btn-outline-info btn-sm" href="{{ route('admin.statistics.product_views') }}">Xem chi tiết<i class="fas fa-arrow-right ml-1 fa-sm"></i></a>
                                </div>
                                <div class=" fa-2x text-info">
                                    <i class="fa-regular fa-eye"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tổng đơn hàng đã hoàn thành -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card card-new border-left-success shadow h-100 ">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Tổng đơn hàng
                                    </div>
                                    <div class="h5 mb-1 font-weight-bold text-gray-800" id="totalOrders">{{ $totalOrders ?? 0 }}</div>
                                    <a class="btn btn-outline-success btn-sm" href="{{ route('admin.orders.index') }}">Xem chi tiết<i class="fas fa-arrow-right ml-1 fa-sm"></i></a>
                                </div>
                                <div class="fa-2x text-success">
                                    <i class="fas fa-shopping-basket"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tổng người dùng -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 ">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Tổng người dùng
                                    </div>
                                    <div class="h5 mb-1 font-weight-bold text-gray-800" id="totalUsers">{{ $totalUsers ?? 0 }}</div>
                                    <a class="btn btn-outline-warning btn-sm" href="{{ route('admin.customers.index') }}">Xem chi tiết<i class="fas fa-arrow-right ml-1 fa-sm"></i></a>
                                </div>
                                <div class="fa-2x text-warning">
                                    <i class="fa-solid fa-user-plus"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-end">
                    <form id="filterForm" class="col-md-10">
                        <div class="row g-3 align-items-end">
                            <!-- Ngày bắt đầu -->
                            <div class="col-md-5">
                                <label for="startDate" class="form-label">Từ ngày:</label>
                                <input type="date" id="startDate" name="start_date" class="form-control" required>
                            </div>
                            <!-- Ngày kết thúc -->
                            <div class="col-md-5">
                                <label for="endDate" class="form-label">Đến ngày:</label>
                                <input type="date" id="endDate" name="end_date" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary w-100" onclick="applyCustomFilter()">
                                    <i class="fas fa-filter mr-1"></i>Lọc</button>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-2">
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle btn btn-outline-secondary w-100" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                Khoảng thời gian
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Thời gian mẫu:</div>
                                <button class="dropdown-item" onclick="fetchChartData('today')">Hôm nay</button>
                                <button class="dropdown-item" onclick="fetchChartData('this_week')">Tuần này</button>
                                <button class="dropdown-item" onclick="fetchChartData('this_month')">Tháng này</button>
                                <button class="dropdown-item" onclick="fetchChartData('this_quarter')">Quý này</button>
                                <button class="dropdown-item" onclick="fetchChartData('this_year')">Năm nay</button>
                                <button class="dropdown-item" onclick="fetchChartData('last_week')">Tuần trước</button>
                                <button class="dropdown-item" onclick="fetchChartData('last_month')">Tháng trước</button>
                                <button class="dropdown-item" onclick="fetchChartData('last_year')">Năm trước</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <!-- Số lượng order -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-secondary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    Đơn hàng
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_orders"></div>
                            </div>
                            <div class="fa-2x text-secondary">
                                <i class="fas fa-shopping-basket"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tổng doanh thu -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Tổng doanh thu
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_revenue"></div>
                            </div>
                            <div class="fa-2x text-primary">
                                <i class="fa-solid fa-money-bill-wheat"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Chi phí nhập -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Tổng chi phí
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_cost"></div>
                            </div>
                            <div class="fa-2x text-warning">
                                <i class="fas fa-coins"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Lợi nhuận -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Tổng lợi nhuận
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="profit"></div>
                            </div>
                            <div class="fa-2x text-success">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4 h-100">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-chart-bar me-1"></i>
                            Doanh thu BeesFashion
                        </h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <canvas id="myBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Main Content -->
@endsection

@section('script-libs')
    <script src="{{ asset('js/admin/charts/getRevenueShop.js') }}"></script>
@endsection
