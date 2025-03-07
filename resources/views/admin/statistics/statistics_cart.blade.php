@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Sản phẩm có trong giỏ hàng</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table mr-1"></i>
                    Danh sách sản phẩm trong giỏ hàng
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên sản phẩm</th>
                                <th>Mã sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Tổng giá trị</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalQuantity = 0;
                                $totalValue = 0;
                            @endphp
                            @foreach ($products as $parentKey => $product)
                                @php
                                    $totalQuantity += $product['total_quantity'];
                                    $totalValue += $product['total_value'];
                                @endphp
                                <!-- Dòng sản phẩm -->
                                <tr class="table-primary">
                                    <td>{{ $parentKey + 1 }}</td>
                                    <td>{{ $product['product_name'] }}</td>
                                    <td>{{ $product['product_sku'] }}</td>
                                    <td>{{ $product['total_quantity'] }}</td>
                                    <td>
                                        {{ number_format($product['min_price'], 0, ',', '.') }} đ
                                        @if ($product['min_price'] !== $product['max_price'])
                                            - {{ number_format($product['max_price'], 0, ',', '.') }} đ
                                        @endif
                                    </td>
                                    <td>{{ number_format($product['total_value'], 0, ',', '.') }} đ</td>
                                </tr>

                                <!-- Dòng biến thể -->
                                @foreach ($product['variants'] as $childKey => $variant)
                                    <tr>
                                        <td>{{ $parentKey + 1 }}.{{ $childKey + 1 }}</td>
                                        <td style="padding-left: 30px;">- {{ $variant['variant_name'] }}</td>
                                        <td>{{ $variant['variant_sku'] }}</td>
                                        <td>{{ $variant['quantity'] }}</td>
                                        <td>{{ number_format($variant['price'], 0, ',', '.') }} đ</td>
                                        <td>{{ number_format($variant['total_value'], 0, ',', '.') }} đ</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-info font-weight-bold ">
                                <td colspan="3" class="text-center">Tổng cộng</td>
                                <td>{{ $totalQuantity }}</td>
                                <td></td>
                                <td>{{ number_format($totalValue, 0, ',', '.') }} đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-libs')
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('theme/admin/js/demo/datatables-demo.js') }}"></script>
@endsection

@section('style-libs')
    <link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
