@extends('admin.layouts.master')

@section('title')
    Tạo mới thuộc tính
@endsection

@section('content')
    <div class="row">
        <!-- Phần form thêm mới -->
        <div class="card shadow col-md-4">
            <h1 class="h2 mt-3 text-center fw-bold">Tạo mới loại thuộc tính</h1>
            <div class="card-body">
                <form action="{{ route('admin.attribute_types.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Loại thuộc tính</label>
                        <input type="text" name="type_name"
                            class="form-control @error('type_name') is-invalid @enderror"value="{{ old('type_name') }}">
                        @error('type_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">Tạo thuộc tính</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Phần danh sách -->
        <div class=" card shadow  col-md-8">
            <div class="card-body">
                <h3>Danh sách</h3>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 5%">STT</th>
                                <th style="width: 75%">Tên</th>
                                <th style="width: 20%">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listAttributeTypes as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><a
                                            href="{{ route('admin.attribute_types.edit', $item->id) }}">{{ $item->type_name }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.attribute_types.edit', $item->id) }}"
                                            class="btn btn-warning"><i class="fa fa-pencil-alt"></i></a>
                                        <form action="{{ route('admin.attribute_types.destroy', $item->id) }}"
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
