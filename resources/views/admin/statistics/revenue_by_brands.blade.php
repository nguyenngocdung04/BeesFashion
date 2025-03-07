@extends('admin.layouts.master')

@section('style-libs')
    <style>
        .statistics-card {
            transition: all 0.3s ease;
        }

        .statistics-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .metric-card {
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
        }

        .brand-toggle,
        .product-toggle {
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .brand-toggle.collapsed .toggle-icon,
        .product-toggle.collapsed .toggle-icon {
            transform: rotate(0deg);
        }

        .brand-toggle .toggle-icon,
        .product-toggle .toggle-icon {
            transform: rotate(180deg);
            transition: transform 0.3s ease;
        }

        .products-section {
            animation: slideDown 0.3s ease-out;
        }

        .products-section.show {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .brand-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .metrics-row {
            transition: all 0.3s ease;
        }

        .card-metrics {
            transition: transform 0.3s ease;
        }

        .card-metrics:hover {
            transform: translateY(-5px);
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Doanh thu theo thương hiệu</h1>

            <!-- Time Range Filter -->
            <div class="d-flex align-items-center">
                <form action="{{ route('admin.statistics.revenueBrand') }}" method="GET" class="mr-3">
                    <select name="time_range" class="form-control" onchange="this.form.submit()">
                        @foreach ($timeRanges as $key => $range)
                            <option value="{{ $key }}" {{ request('time_range', 'this_month') === $key ? 'selected' : '' }}>
                                {{ $range['label'] }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
                </a>
            </div>
        </div>

        <!-- Hiển thị thông tin thời gian đang xem -->
        <div class="alert alert-info mb-4">
            <i class="fas fa-calendar-alt mr-2"></i>
            Thống kê từ: {{ $currentRange['start']->format('d/m/Y H:i') }}
            đến: {{ $currentRange['end']->format('d/m/Y H:i') }}
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($statisticBrand)
                            @foreach ($statisticBrand as $brandStat)
                                <div class="statistics-card card mb-4">
                                    <div class="card-header bg-primary text-white">
                                        <div class="brand-header brand-toggle collapsed" data-toggle="collapse" data-target="#brand{{ $loop->index }}">
                                            <h4 class="mb-0 font-weight-bold">{{ $brandStat['brand_name'] }} ({{ $brandStat['total_orders'] }} đơn)</h4>
                                            <i class="fas fa-chevron-down toggle-icon"></i>
                                        </div>
                                    </div>
                                    <div class="collapse" id="brand{{ $loop->index }}">
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col-md-4 col-lg-3 mb-3">
                                                    <div class="card border-left-primary h-100 card-metrics">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tổng sản phẩm bán</div>
                                                                    <div class="h5 mb-0 font-weight-bold">{{ number_format($brandStat['total_products_sold']) }}</div>
                                                                </div>
                                                                <div class="fa-2x text-primary">
                                                                    <i class="fa-solid fa-shirt"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 mb-3">
                                                    <div class="card border-left-success h-100 card-metrics">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Doanh thu</div>
                                                                    <div class="h5 mb-0 font-weight-bold">{{ number_format($brandStat['total_revenue']) }} đ</div>
                                                                </div>
                                                                <div class="fa-2x text-success">
                                                                    <i class="fa-solid fa-money-bill-wheat"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 mb-3">
                                                    <div class="card border-left-warning h-100 card-metrics">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Chi phí</div>
                                                                    <div class="h5 mb-0 font-weight-bold">{{ number_format($brandStat['total_cost']) }} đ</div>
                                                                </div>
                                                                <div class="fa-2x text-warning">
                                                                    <i class="fas fa-coins"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-3 mb-3">
                                                    <div class="card border-left-danger h-100 card-metrics">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Lợi nhuận</div>
                                                                    <div class="h5 mb-0 font-weight-bold">{{ number_format($brandStat['total_profit']) }} đ</div>
                                                                </div>
                                                                <div class="fa-2x text-danger">
                                                                    <i class="fas fa-chart-line"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="products-section mt-4">
                                                <h5 class="mb-3 font-weight-bold">Chi tiết sản phẩm</h5>
                                                @foreach ($brandStat['products'] as $product)
                                                    <div class="product-card card mb-3">
                                                        <div class="card-header bg-light">
                                                            <div class="d-flex justify-content-between align-items-center product-toggle collapsed" data-toggle="collapse"
                                                                data-target="#product{{ $loop->parent->index }}{{ $loop->index }}">
                                                                <h6 class="mb-0">{{ $product['product_name'] }} ({{ $product['total_orders'] }} đơn)</h6>
                                                                <i class="fas fa-chevron-down toggle-icon"></i>
                                                            </div>
                                                        </div>
                                                        <div class="collapse" id="product{{ $loop->parent->index }}{{ $loop->index }}">
                                                            <div class="card-body">
                                                                <div class="row mb-2">
                                                                    <div class="col-md-4 col-lg-3 mb-3">
                                                                        <div class="card border-left-primary h-100 card-metrics">
                                                                            <div class="card-body">
                                                                                <div class="d-flex justify-content-between align-items-center">
                                                                                    <div>
                                                                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Số lượng bán</div>
                                                                                        <div class="h5 mb-0 font-weight-bold">{{ number_format($product['total_products_sold']) }}</div>
                                                                                    </div>
                                                                                    <div class="fa-2x text-primary">
                                                                                        <i class="fa-solid fa-shirt"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-lg-3 mb-3">
                                                                        <div class="card border-left-success h-100 card-metrics">
                                                                            <div class="card-body">
                                                                                <div class="d-flex justify-content-between align-items-center">
                                                                                    <div>
                                                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Doanh thu</div>
                                                                                        <div class="h5 mb-0 font-weight-bold">{{ number_format($product['total_revenue']) }} đ</div>
                                                                                    </div>
                                                                                    <div class="fa-2x text-success">
                                                                                        <i class="fa-solid fa-money-bill-wheat"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-lg-3 mb-3">
                                                                        <div class="card border-left-warning h-100 card-metrics">
                                                                            <div class="card-body">
                                                                                <div class="d-flex justify-content-between align-items-center">
                                                                                    <div>
                                                                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Chi phí</div>
                                                                                        <div class="h5 mb-0 font-weight-bold">{{ number_format($product['total_cost']) }} đ</div>
                                                                                    </div>
                                                                                    <div class="fa-2x text-warning">
                                                                                        <i class="fas fa-coins"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-lg-3 mb-3">
                                                                        <div class="card border-left-danger h-100 card-metrics">
                                                                            <div class="card-body">
                                                                                <div class="d-flex justify-content-between align-items-center">
                                                                                    <div>
                                                                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Lợi nhuận</div>
                                                                                        <div class="h5 mb-0 font-weight-bold">{{ number_format($product['total_profit']) }} đ</div>
                                                                                    </div>
                                                                                    <div class="fa-2x text-danger">
                                                                                        <i class="fas fa-chart-line"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                @if (isset($product['variants']) && count($product['variants']) > 0)
                                                                    <div class="variants-section mt-4">
                                                                        <h6 class="mb-2 font-weight-bold">Chi tiết biến thể</h6>
                                                                        <div class="table-responsive">
                                                                            <table class="table table-sm table-bordered">
                                                                                <thead class="bg-light">
                                                                                    <tr>
                                                                                        <th>Tên biến thể</th>
                                                                                        <th>Đơn hàng</th>
                                                                                        <th>Số lượng</th>
                                                                                        <th>Doanh thu</th>
                                                                                        <th>Chi phí</th>
                                                                                        <th>Lợi nhuận</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach ($product['variants'] as $variant)
                                                                                        <tr>
                                                                                            <td>{{ $variant['variant_name'] }}</td>
                                                                                            <td>{{ number_format($variant['orders']) }}</td>
                                                                                            <td>{{ number_format($variant['quantity_sold']) }}</td>
                                                                                            <td>{{ number_format($variant['revenue']) }} đ</td>
                                                                                            <td>{{ number_format($variant['cost']) }} đ</td>
                                                                                            <td>{{ number_format($variant['profit']) }} đ</td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h5 class="text-center">Chưa có doanh thu cho các thương hiệu</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý sự kiện click cho brand toggle
            const brandToggles = document.querySelectorAll('.brand-toggle');

            brandToggles.forEach(toggle => {
                const target = document.querySelector(toggle.getAttribute('data-target'));

                // Đồng bộ trạng thái ban đầu
                if (target.classList.contains('show')) {
                    toggle.classList.remove('collapsed'); // Nếu mục đang mở, bỏ lớp 'collapsed'
                } else {
                    toggle.classList.add('collapsed'); // Nếu mục đang đóng, thêm lớp 'collapsed'
                }

                // Xử lý sự kiện click
                toggle.addEventListener('click', function() {
                    // Toggle trạng thái collapse
                    target.classList.toggle('show');

                    // Toggle lớp "collapsed" cho chính toggle
                    this.classList.toggle('collapsed');
                });
            });

            // Xử lý sự kiện click cho product toggle
            const productToggles = document.querySelectorAll('.product-toggle');
            productToggles.forEach(toggle => {
                const target = document.querySelector(toggle.getAttribute('data-target'));

                // Đồng bộ trạng thái ban đầu
                if (target.classList.contains('show')) {
                    toggle.classList.remove('collapsed'); // Nếu mục đang mở, bỏ lớp 'collapsed'
                } else {
                    toggle.classList.add('collapsed'); // Nếu mục đang đóng, thêm lớp 'collapsed'
                }

                // Xử lý sự kiện click
                toggle.addEventListener('click', function() {
                    // Toggle trạng thái collapse
                    target.classList.toggle('show');

                    // Toggle lớp "collapsed" cho chính toggle
                    this.classList.toggle('collapsed');
                });
            });
        });
    </script>
@endsection
