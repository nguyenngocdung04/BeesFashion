@extends('admin.layouts.master')

@section('title')
    Chi tiết thuộc tính
@endsection

@section('content')
<div class="mb-2 ml-3">
    <a href="{{route('admin.attributes.create')}}" class="btn btn-dark text-white text-decoration-none"><i class="fas fa-arrow-left"></i> Quay lại</a>
</div>
    <div class="row">
        <!-- Phần form thêm mới -->
        <div class="card shadow col-md-4">
            <h1 class="h3 mt-3 text-center fw-bold">Thêm mới {{ $attribute->name }}</h1>
            <div class="card-body">
                <form action="{{ route('admin.attribute_values.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 mb-3">
                        <label for="value" class="form-label">Giá trị thuộc tính</label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"value="{{ old('name') }}">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <input type="hidden" name="attribute_id" value="{{ $attribute->id }}">
                    @if ($type_name === 'color')
                        <div class="mt-3 mb-2">
                            <label for="value" class="form-label">Chọn màu</label>
                            <div class="input-group">
                                <input type="color"
                                    class="form-control form-control-color @error('value') is-invalid @enderror"value="{{ old('value') }}"
                                    id="colorValue" name="value" value="#000000" title="Chọn màu sản phẩm">
                                @error('value')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    @else
                    @endif
                    <div class="mt-3 text-center">
                        <button type="submit" class="btn btn-success ">Thêm mới {{ $attribute->name }}</button>
                    </div>
                </form>

            </div>
        </div>

        <!-- Phần danh sách -->
        <div class="card shadow col-md-8">
            <div class="card-body">
                <h3>Danh sách</h3>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 5%">STT</th>
                                <th style="width: 75%">Tên</th>
                                @if ($type_name === 'color')
                                    <th style="">Màu</th>
                                @endif
                                <th style="width: 20%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attribute->attribute_values as $index => $value)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td> <a
                                            href="{{ route('admin.attribute_values.edit', $value->id) }}">{{ $value->name }}</a>
                                    </td>
                                    @if ($type_name === 'color')
                                        <td>
                                            <span class="d-block w-100 p-3 my-2 text-center rounded"
                                                style="background-color: {{ $value->value }};">
                                            </span>
                                        </td>
                                    @endif
                                    <td class="text-center">
                                        <a href="{{ route('admin.attribute_values.edit', $value->id) }}"
                                            class="btn btn-warning"><i class="fa fa-pencil-alt"></i></a>
                                        <form action="{{ route('admin.attribute_values.destroy', $value->id) }}"
                                            class="d-inline" method="POST"
                                            onsubmit="return confirm('Bạn có đồng ý xóa hay không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="fa fa-trash"></i></button>
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
@endsection
