@extends('admin.layouts.master')
@section('title')
    Cập nhật vouchers
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
        <div class="mb-2 ml-3">
            <a href="{{ route('admin.vouchers.index') }}" class="btn btn-dark text-white text-decoration-none"><i
                    class="fas fa-arrow-left"></i> Quay lại</a>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Cập nhật vouchers</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.vouchers.update', $vouchers->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Tên Voucher</label>
                            <input type="text" class="form-control form-control-sm" name="name" id="name"
                                value="{{ $vouchers->name }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="code" class="form-label">Mã Voucher</label>
                            <input type="text" class="form-control form-control-sm" name="code" id="code"
                                value="{{ $vouchers->code }}">
                            @error('code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="amount" class="form-label">Giá Trị Giảm</label>
                            <input type="number" class="form-control form-control-sm" name="amount" id="amount"
                                value="{{ $vouchers->amount }}">
                            @error('amount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Số Lượng</label>
                            <input type="number" class="form-control form-control-sm" name="quantity" id="quantity"
                                value="{{ $vouchers->amount }}">
                            @error('quantity')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Ảnh Voucher</label>
                        <input type="file" class="form-control form-control-sm" name="image" id="image">
                        <img src="{{ asset('uploads/vouchers/images/' . $vouchers->image) }}" width="100px"
                            alt="">
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="type" class="form-label">Loại Voucher</label>
                            <select class="form-control form-control-sm" name="type" id="type">
                                <option value="fixed" {{ $vouchers->type == 'fixed' ? 'selected' : '' }}>Cố định</option>
                                <option value="percent" {{ $vouchers->type == 'percent' ? 'selected' : '' }}>Phần trăm
                                </option>
                                <option value="free_ship" {{ $vouchers->type == 'free_ship' ? 'selected' : '' }}>Miễn phí
                                    vận chuyển</option>
                            </select>
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Ngày Bắt Đầu</label>
                            <input type="date" class="form-control form-control-sm" name="start_date" id="start_date"
                                value="{{ $vouchers->start_date }}">
                            @error('start_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="minimum_order_value" class="form-label">Giá Tối Thiểu Đơn Hàng</label>
                            <input type="number" class="form-control form-control-sm" name="minimum_order_value"
                                id="minimum_order_value" value="{{ $vouchers->minimum_order_value }}">
                            @error('minimum_order_value')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">Ngày Hết Hạn</label>
                            <input type="date" class="form-control form-control-sm" name="end_date" id="end_date"
                                value="{{ $vouchers->end_date }}">
                            @error('end_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="maximum_reduction" class="form-label">Giá tiền giảm tối đa</label>
                            <input type="number" class="form-control form-control-sm" name="maximum_reduction"
                                id="maximum_reduction" value="{{ $vouchers->maximum_reduction }}">
                            @error('maximum_reduction')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="is_public" class="form-label">Áp dụng cho tất cả người dùng</label>
                        <input type="checkbox" name="is_public" id="is_public" value="1"
                        {{ $vouchers->is_public ? 'checked' : '' }}>
                    </div>
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Kích Hoạt</label>
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                            {{ $vouchers->is_active ? 'checked' : '' }}>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>
@endsection
