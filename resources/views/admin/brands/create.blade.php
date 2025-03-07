@extends('admin.layouts.master')

@section('title')
    Tạo mới thương hiệu sản phẩm
@endsection

@section('content')
    <div class="card shadow mb-4">
        <h1 class="h2 mt-3 text-center text-gray-800 fw-bold">Tạo mới thương hiệu </h1>
        <div class="card-body">
            <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Tên thương hiệu</label>
                    <input type="text" name="name"
                        class="form-control @error('name') is-invalid @enderror"value="{{ old('name') }}">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
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
                    <label for="" class="form-label">Trạng thái</label>
                    <select name="is_active"
                        class="form-control @error('is_active') is-invalid @enderror"value="{{ old('is_active') }}">
                        <option value="1" selected>Hiển Thị</option>
                        <option value="0">Ẩn</option>

                    </select>
                    @error('is_active')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Tạo mới</button>
                </div>
            </form>
        </div>
    </div>
@endsection
