@extends('admin.layouts.master')
@section('title')
    Quản lý đánh giá
@endsection
@section('style-libs')
    <!-- Custom styles for this page -->
    <link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4 ">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm được đánh giá</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Người dùng</th>
                                <th>Sản phẩm</th>
                                <th>Mã biến thể</th>
                                <th>Đánh giá</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tfoot class="sticky-bottom">
                            <tr>
                                <th>#</th>
                                <th>Người dùng</th>
                                <th>Sản phẩm</th>
                                <th>Mã biến thể</th>
                                <th>Đánh giá</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($votes as $key => $vote)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $vote->user->full_name }}</td>
                                    <td style="white-space: normal; word-wrap: break-word; max-width: 200px;">{{ $vote->product_variant->product->name }}</td>
                                    <td><img class="mr-2" src="{{ asset('uploads/products/images/' . $vote->product_variant->image) }}"
                                        alt="Product Image" width="50" height="50">{{ $vote->product_variant->SKU }}</td>

                                    <td style="white-space: normal; word-wrap: break-word; max-width: 200px;">{{ $vote->star }}<i class="fa-solid fa-star fa-sm text-warning ml-1"></i> - {{ $vote->content }}</td>
                                    <td>
                                        @if($vote->is_active)
                                            <span class="badge bg-success badge-success">Hiển thị</span>
                                        @else
                                            <span class="badge bg-danger badge-danger">Ẩn</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.ratings.toggleVisibility', $vote->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm
                                @if($vote->is_active == 1) btn-danger @else btn-success @endif">
                                <!-- Thêm icon và đổi văn bản dựa trên trạng thái -->
                                @if($vote->is_active == 1)
                                    <i class="fas fa-eye-slash"></i> Ẩn
                                @else
                                    <i class="fas fa-eye"></i> Hiện
                                @endif
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
@endsection
@section('script-libs')
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('theme/admin/js/demo/datatables-demo.js') }}"></script>

@endsection
