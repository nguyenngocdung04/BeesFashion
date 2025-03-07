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

        <div class="mb-2 ml-3">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-dark text-white text-decoration-none"><i
                    class="fas fa-arrow-left"></i> Quay lại</a>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>

                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal">
                    <i
                    class="fas fa-plus mr-2"></i>
                    Thêm sản phẩm
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên sản phẩm</th>
                                <th>Mô tả</th>
                                <th>Số đơn ảo</th>
                                <th>Tạo đơn ảo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($bestSellingProducts as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <img src="{{ $item->product_files[0]->file_name ? asset('uploads/products/images/' .  $item->product_files[0]->file_name) : asset('assets/images/icons/noimage.png') }}" 
                                             width="50px" >
                                        {{ \Illuminate\Support\Str::limit($item->name, 30) }}  
                                    </td>
                                    <td>{!! \Illuminate\Support\Str::limit(strip_tags($item->description), 25) !!}</td>
                                    <td>{{ $item->fake_sales ?? 'Dữ liệu trống' }}</td>
                                    <td>
                                        <form action="{{ route('admin.categories.fake_sales', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Bạn có muốn thay đổi không?')">
                                            @csrf
                                            <input type="number" name="fake_sales"
                                                class="form-control form-control-sm d-inline-block w-50"
                                                placeholder="Số lượng" min="1">
                                            <button type="submit" class="btn btn-success btn-sm d-inline-block w-25">Xác
                                                nhận</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.categories.remove', ['categoryId' => $currentCategory->id, 'productId' => $item->id]) }}" method="POST" 
                                            onsubmit="return confirm('Bạn có đồng ý xóa hay không?')">
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
    @include('admin.categories.add')
@endsection
