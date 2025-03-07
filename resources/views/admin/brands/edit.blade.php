@extends('admin.layouts.master')

@section('title')
    Chỉnh sửa danh mục
@endsection

@section('content')
    <div class="card shadow mb-4">
        <h1 class="h2 mt-3 text-center text-gray-800 fw-bold"> Chỉnh sửa thương hiệu </h1>

        <div class="card-body">
            <form action="{{ route('admin.brands.update', $brandID->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mt-3 mb-3">
                    <label for="name" class="form-label">Tên thương hiệu</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                        value="{{ old('name', $brandID->name) }}">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Ảnh -->
                <div class="mt-3 mb-3">
                    <label for="image" class="form-label">Ảnh</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                    
                    <!-- Hiển thị ảnh cũ nếu có -->
                    @if ($brandID->image)
                        <div class="mt-2">
                            <img src="{{ asset('uploads/brands/images/' .$brandID->image) }}" width="150px" alt="Brand Image">
                        </div>
                    @endif
                    
                    @error('image')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Trạng thái -->
                <div class="mt-3 mb-3">
                    <label for="is_active" class="form-label">Trạng thái</label>
                    <select name="is_active" id="is_active" class="form-control @error('is_active') is-invalid @enderror">
                        <option value="1" {{ old('is_active', $brandID->is_active) == 1 ? 'selected' : '' }}>Hiển Thị</option>
                        <option value="0" {{ old('is_active', $brandID->is_active) == 0 ? 'selected' : '' }}>Ẩn</option>
                    </select>
                    @error('is_active')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Nút Submit -->
                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Chỉnh sửa</button>
                </div>
            </form>
            
        </div>
    </div>
@endsection
