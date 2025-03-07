@extends('admin.layouts.master')
@section('title')
    Danh sách danh mục
@endsection
@section('style-libs')
    <!-- Custom styles for this page -->
    <link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('script-libs')
    <!-- Page level plugins -->
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('theme/admin/js/demo/datatables-demo.js') }}"></script>
@endsection
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Lịch sử nhập hàng</h6>

                <button type="button" class="btn btn-success text-white text-decoration-none btn-sm" data-toggle="modal"
                    data-target="#exampleModal">
                    <i class="fas fa-plus"></i> Nhập hàng
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Tồn kho</th>
                                <th>Người nhập</th>
                                <th>Thời gian nhập</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($importHistories as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><img src="{{ $item->product_variant->image ? asset('uploads/products/images/' . $item->product_variant->image) : asset('assets/images/icons/noimage.png') }}"
                                            width="50px">
                                        {{ $item->product_variant->name }} / {{ $item->product_variant->product->name }}
                                    </td>
                                    <td>{{ number_format($item->import_price, 0, ',', '.') }}</td>
                                    <td>{{ number_format($item->quantity, 0, ',', '.') }}</td>
                                    <td @if ($item->product_variant->stock < 20) class="text-danger font-weight-bold" @endif>
                                        {{ number_format($item->product_variant->stock, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        {{ $item->user ? $item->user->username : 'Không có dữ liệu' }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d F Y, H:i:s') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
    @include('admin.import_history.create')
@endsection
