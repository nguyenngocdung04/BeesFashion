@extends('admin.layouts.master')
@section('style-libs')
    <style>
        th,
        td {
            text-align: center;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Doanh thu theo sản phẩm</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>
        <!-- Filter Section -->
        <div class="card mb-4">
            <div class="card-body">
                <form id="statisticsForm" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label">Thống kê theo</label>
                        <select class="form-control" name="type" id="periodType">
                            <option value="day" {{ $type === 'day' ? 'selected' : '' }}>Ngày</option>
                            <option value="month" {{ $type === 'month' ? 'selected' : '' }}>Tháng</option>
                            <option value="year" {{ $type === 'year' ? 'selected' : '' }}>Năm</option>
                        </select>
                    </div>

                    <div class="col-md-5" id="periodInputContainer">
                        <!-- Dynamic input will be inserted here -->
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter mr-1"></i>Lọc
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-left-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tổng doanh thu</div>
                                <div class="h5 mb-0 font-weight-bold total-revenue">{{ number_format($statistics['totals']['total_revenue']) }} đ</div>
                            </div>
                            <div class="fa-2x text-primary">
                                <i class="fa-solid fa-money-bill-wheat"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-left-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Tổng chi phí</div>
                                <div class="h5 mb-0 font-weight-bold total-cost">{{ number_format($statistics['totals']['total_cost']) }} đ</div>
                            </div>
                            <div class="fa-2x text-warning">
                                <i class="fas fa-coins"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-left-success h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tổng lợi nhuận</div>
                                <div class="h5 mb-0 font-weight-bold total-profit">{{ number_format($statistics['totals']['total_profit']) }} đ</div>
                            </div>
                            <div class="fa-2x text-success">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-left-info h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Số lượng bán</div>
                                <div class="h5 mb-0 font-weight-bold total-quantity">{{ number_format($statistics['totals']['total_quantity']) }}</div>
                            </div>
                            <div class="fa-2x text-info">
                                <i class="fas fa-box"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row mb-4">
            <div class="col-xl-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Doanh thu sản phẩm
                        </h6>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Lợi nhuận sản phẩm
                        </h6>
                    </div>
                    <div class="card-body">
                        <canvas id="profitChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table mr-1"></i>
                    Dữ liệu doanh thu chi tiết
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="revenueTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên sản phẩm</th>
                                <th class="text-end">Số lượng</th>
                                <th class="text-end">Doanh thu</th>
                                <th class="text-end">Chi phí</th>
                                <th class="text-end">Lợi nhuận</th>
                                <th class="text-end">Lợi nhuận theo %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statistics['data'] as $key => $product)
                                <tr @if ($product['name'] === 'Others')  @endif>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $product['name'] }}</td>
                                    <td class="text-end">{{ number_format($product['total_quantity']) }}</td>
                                    <td class="text-end">{{ number_format($product['total_revenue']) }} đ</td>
                                    <td class="text-end">{{ number_format($product['total_cost']) }} đ</td>
                                    <td class="text-end">{{ number_format($product['profit']) }} đ</td>
                                    <td class="text-end">
                                        @if ($product['total_revenue'] > 0)
                                            {{ number_format(($product['profit'] / $product['total_revenue']) * 100, 1) }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @php
                                $totals = [
                                    'totalQuantity' => array_sum(array_column($statistics['data'], 'total_quantity')),
                                    'totalRevenue' => array_sum(array_column($statistics['data'], 'total_revenue')),
                                    'totalCost' => array_sum(array_column($statistics['data'], 'total_cost')),
                                    'totalProfit' => array_sum(array_column($statistics['data'], 'profit')),
                                ];

                                $totalProfitMargin = $totals['totalRevenue'] > 0 ? number_format(($totals['totalProfit'] / $totals['totalRevenue']) * 100, 1) : 0;
                            @endphp

                            <tr class="table-success">
                                <td class="text-dark font-weight-bold" colspan="2">Tổng cộng</td>
                                <td class="text-end">{{ number_format($totals['totalQuantity']) }}</td>
                                <td class="text-end">{{ number_format($totals['totalRevenue']) }} đ</td>
                                <td class="text-end">{{ number_format($totals['totalCost']) }} đ</td>
                                <td class="text-end">{{ number_format($totals['totalProfit']) }} đ</td>
                                <td class="text-end">{{ $totalProfitMargin }}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-libs')
    <script>
        // Pass initial data to JavaScript
        window.initialData = @json($statistics);
    </script>
    <script src="{{ asset('js/admin/charts/getRevenueProduct.js') }}"></script>
@endsection
