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
                <h6 class="m-0 font-weight-bold text-primary">Danh sách banner</h6>
                <a href="{{ route('admin.banner.create') }}" class="btn btn-success text-white text-decoration-none btn-sm"><i
                        class="fas fa-plus mr-2"></i>Thêm mới</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên Banner</th>
                                <th>Hình ảnh</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Tên Banner</th>
                                <th>Hình ảnh</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($banners as $banner)
                                <tr>
                                    <td>{{ $banner->id }}</td>
                                    <td>{{ $banner->name }}</td>
                                    <td>

                                        @foreach ($banner->banner_images as $banner_image)
                                            <img src="{{ asset('uploads/banners/images/id_' . $banner->id . '/' . $banner_image->file_name) }}"
                                                alt="Banner Image" style="max-width: 100px;">
                                        @endforeach

                                    </td>
                                    <td>{{ $banner->is_active == 1 ? 'Hiển Thị' : 'Ẩn' }}</td>
                                    <td style="white-space: nowrap;">
                                        @if ($banner->is_active == 1)
                                            <a href="{{ route('admin.banner.offactive', $banner->id) }}" style="margin-right: 10px;"><i class="fa fa-power-off"></i></a>
                                        @else
                                            <a href="{{ route('admin.banner.onactive', $banner->id) }}" style="margin-right: 10px;"><i class="fa fa-power-off"></i></a>
                                        @endif
                                        <a href="{{ route('admin.banner.edit', $banner->id) }}" style="margin-right: 10px;"><img
                                            src="{{ asset('assets/images/icons/edit.svg') }}" alt="img"></a>
                                        <form action="{{ route('admin.banner.destroy', $banner->id) }}" method="POST"
                                            style="display: inline;"
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
@endsection
