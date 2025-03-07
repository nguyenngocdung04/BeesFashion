@extends('admin.layouts.master')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-fluid px-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Doanh thu theo khách hàng</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <!-- Filter Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form id="revenueFilterForm">
                    <div class="btn-group d-flex">
                        <button type="button" class="btn btn-outline-primary active" data-value="daily">
                            Hôm nay
                        </button>
                        <button type="button" class="btn btn-outline-primary" data-value="monthly">
                            Tháng này
                        </button>
                        <button type="button" class="btn btn-outline-primary" data-value="yearly">
                            Năm này
                        </button>
                        <button type="button" class="btn btn-outline-primary" data-value="all">
                            Tất cả
                        </button>
                    </div>
                    <input type="hidden" name="time_type" value="daily">
                </form>
            </div>
        </div>

        <!-- Chi tiết khách hàng -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="font-weight-bold text-primary mb-0">
                    <i class="fas fa-users mr-1"></i>
                    Chi tiết khách hàng
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="customersTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Khách hàng</th>
                                <th>Email</th>
                                <th>Hạng</th>
                                <th>Số đơn hàng</th>
                                <th>Chi tiêu</th>
                                <th>Giá trị đơn TB</th>
                                <th>Đơn đầu tiên</th>
                                <th>Đơn gần nhất</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Chi tiết doanh thu theo thời gian -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="font-weight-bold text-primary mb-0">
                    <i class="fas fa-table mr-1"></i>
                    Chi tiết doanh thu theo thời gian
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="revenueTable">
                        <thead>
                            <tr>
                                <th>Thời gian</th>
                                <th>Số khách hàng</th>
                                <th>Số đơn hàng</th>
                                <th>Tổng doanh thu</th>
                                <th>Giá trị đơn trung bình</th>
                                <th>Chi tiêu trung bình/khách</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style-libs')
    <link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        .btn-group {
            width: 100%;
        }

        .btn-group .btn {
            flex: 1;
        }

        @media (max-width: 768px) {
            .btn-group {
                flex-direction: column;
            }

            .btn-group .btn {
                border-radius: 0;
                margin: -1px 0;
            }

            .btn-group .btn:first-child {
                border-radius: 0.25rem 0.25rem 0 0;
            }

            .btn-group .btn:last-child {
                border-radius: 0 0 0.25rem 0.25rem;
            }
        }
    </style>
@endsection

@section('script-libs')
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/admin/charts/getRenvenueCustomer.js') }}"></script>
@endsection
