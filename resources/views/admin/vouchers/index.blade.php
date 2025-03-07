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
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách vouchers</h6>

                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal">
                    <i
                    class="fas fa-plus mr-2"></i>Thêm vouchers
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên Voucher</th>
                                <th>Mã Voucher</th>
                                <th>Giá Trị Giảm</th>
                                <th>Số Lượng</th>
                                <th>Loại Voucher</th>
                                <th>Giá Tối Thiểu</th>
                                <th>Ngày Bắt Đầu</th>
                                <th>Ngày Hết Hạn</th>
                                <th>Mã được áp dụng</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($listVouchers as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td> <img
                                            src="{{ $item->image ? asset('uploads/vouchers/images/' . $item->image) : asset('assets/images/icons/noimage.png') }}"
                                            width="50px">
                                        {{ $item->name }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ number_format($item->amount, 0, ',', '.') }}</td>
                                    <td>{{ number_format($item->quantity, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($item->type === 'fixed')
                                            Cố định
                                        @elseif ($item->type === 'percent')
                                            Phần trăm
                                        @elseif ($item->type === 'free_ship')
                                            Miễn phí vận chuyển
                                        @else
                                            Không xác định
                                        @endif
                                    </td>
                                    <td>{{ number_format($item->minimum_order_value, 0, ',', '.') }} đ</td>
                                    <td>{{ $item->start_date }}</td>
                                    <td>{{ $item->end_date }}</td>
                                    <td>{{ $item->is_public == 1 ? 'Tất cả' : 'Tùy chỉnh' }}</td>
                                    <td>{{ $item->is_active == 1 ? 'Hiển Thị' : 'Ẩn' }}</td>
                                    <td style="white-space: nowrap;">
                                        <a href="{{ route($item->is_active ? 'admin.vouchers.offactive' : 'admin.vouchers.onactive', $item->id) }}"
                                            style="margin-right: 10px; text-decoration: none; color: {{ $item->is_active ? 'red' : 'green' }};">
                                            <i class="fa fa-power-off"></i>
                                        </a>
                                        <a href="{{ route('admin.vouchers.show', $item->id) }}"
                                            style="margin-right: 10px;"> <img
                                                src="{{ asset('assets/images/icons/eye.svg') }}" alt="img"></a>

                                        <a href="{{ route('admin.vouchers.edit', $item->id) }}"
                                            style="margin-right: 10px;"><img
                                                src="{{ asset('assets/images/icons/edit.svg') }}" alt="img"></a>
                                        <form action="{{ route('admin.vouchers.destroy', $item->id) }}" class="d-inline"
                                            method="POST" onsubmit="return confirm('Bạn có đồng ý xóa hay không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="all: unset; cursor: pointer;">
                                                <img src="{{ asset('assets/images/icons/delete.svg') }}" alt="Delete">
                                            </button>
                                        </form>
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
    @include('admin.vouchers.create')
@endsection
