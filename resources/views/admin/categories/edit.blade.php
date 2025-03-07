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
                <h6 class="m-0 font-weight-bold text-primary">Cập nhật danh mục</h6>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.categories.update', $Cate->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
            
                    <!-- Tên danh mục -->
                    <div class="mt-3 mb-3">
                        <label for="name" class="form-label">Tên danh mục</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $Cate->name) }}">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
            
                    <!-- Ảnh -->
                    <div class="mt-3 mb-3">
                        <label for="image" class="form-label">Ảnh</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if($Cate->image)
                        <img src="{{ asset('uploads/categories/images/' . $Cate->image) }}" width="150px" alt="Ảnh danh mục">
                        @endif
                        @error('image')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
            
                    <!-- Mô tả -->
                    <div class="mt-3 mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea name="description" id="description" cols="40" rows="4" class="form-control">{{ old('description', $Cate->description) }}</textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
            
                    <!-- Thuộc danh mục -->
                    <div class="mt-3 mb-3">
                        <label for="parent_category_id" class="form-label">Thuộc danh mục</label>
                        <select name="parent_category_id" id="parent_category_id" class="form-control">
                            <option value="" {{ old('parent_category_id', $Cate->parent_category_id) == '' ? 'selected' : '' }}>Danh mục cha</option>
                            {!! $htmlOption !!}
                        </select>
                    </div>
            
                    <!-- Trạng thái -->
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Kích Hoạt</label>
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $Cate->is_active) ? 'checked' : '' }}>
                       
                    </div>
            
                    <!-- Nút hành động -->
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
