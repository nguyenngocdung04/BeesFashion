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
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Thêm mới danh mục</h6>

            </div>


            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Tên danh mục</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Ảnh</label>
                        <input type="file" name="image" class="form-control" value="{{ old('image') }}">
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Mô tả</label>
                        <textarea name="description" id="" cols="40" rows="4" class="form-control"
                            value="{{ old('description') }}"></textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Phân loại</label>
                        <select name="fixed" class="form-control">
                            <option value="1" selected>Danh mục thường</option>
                            <option value="0">Danh mục tùy chỉnh</option>
                        </select>
                    </div>
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Thuộc danh mục</label>
                        <select name="parent_category_id" class="form-control">
                            <option value="" selected>Danh mục cha</option>
                            {!! $htmlOption !!}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Kích Hoạt</label>
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                            {{ old('is_active') ? 'checked' : '' }} checked>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
