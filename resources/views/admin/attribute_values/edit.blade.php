@extends('admin.layouts.master')
@section('title')
    Chỉnh sửa thuộc tính
@endsection
@section('content')
    <!-- Phần form thêm mới -->
    <div class="mb-2 ml-3">
        <a href="{{route('admin.attribute_values.show',$attribute->id)}}" class="btn btn-dark text-white text-decoration-none"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>
    <div class="card shadow col-md-7 ">
        {{-- <a href="{{ route('admin.attribute_values.show', $attribute_value->id) }}">Về trang thêm</a> --}}
        <h1 class="h3 mt-3 text-center fw-bold">Chỉnh sửa {{ $attribute->name }}</h1>
        <div class="card-body">
            <form action="{{ route('admin.attribute_values.update', $attribute_value->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Input cho Giá trị thuộc tính -->
                <div class="mt-3 mb-3 d-flex align-items-center">
                    <label for="name" class="form-label me-2">Tên giá trị thuộc tính</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $attribute_value->name) }}">
                    <!-- Sử dụng old() với giá trị từ $attribute_value -->
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kiểm tra và hiển thị input chọn màu nếu là thuộc tính "color" -->
                @if ($type_name === 'color')
                    <div class="mt-3 mb-2 d-flex align-items-center">
                        <label for="colorValue" class="form-label me-2">Giá trị thuộc tính</label>
                        <div class="input-group">
                            <input type="color"
                                class="form-control form-control-color @error('value') is-invalid @enderror" id="colorValue"
                                name="value" value="{{ old('value', $attribute_value->value) }}"
                                title="Chọn màu sản phẩm">
                            @error('value')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif

                <!-- Nút chỉnh sửa -->
                <div class="mt-3 text-center">
                    <button type="submit" class="btn btn-success">Chỉnh sửa {{ $attribute->name }}</button>
                </div>
            </form>
        </div>

    </div>
@endsection
