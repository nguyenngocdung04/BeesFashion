@extends('admin.layouts.master')

@section('content')
    <div class="card shadow mb-4">
        <h1 class="h2 mt-3 text-center text-gray-800 fw-bold">Sửa chức năng</h1>
        <div class="card-body">
            <form action="{{ route('admin.managerSettings.update', $managerSetting->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class=" mb-3">
                    <label for="manager_name" class="form-label">Tên chức năng</label>
                    <input type="text" name="manager_name" value="{{ $managerSetting->manager_name }}" class="form-control @error('manager_name') is-invalid @enderror" value="{{ old('manager_name') }}"
                        placeholder="Nhập tên chức năng">
                    @error('manager_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3 mb-3">
                    <label for="parent_manager_setting_id" class="form-label">Chức năng cha</label>
                    <select name="parent_manager_setting_id" class="form-control">
                        <option value="">Không có</option>
                        @foreach ($parentSettings as $parentSetting)
                            <option value="{{ $parentSetting->id }}" {{ $managerSetting->parent_manager_setting_id == $parentSetting->id ? 'selected' : '' }}>
                                {{ $parentSetting->manager_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.managerSettings.index') }}" class="btn btn-secondary text-white text-decoration-none"><i class="fa-solid fa-arrow-left mr-1"></i>Back</a>
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                </div>
            </form>

        </div>
    </div>
@endsection
