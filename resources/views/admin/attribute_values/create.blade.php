@extends('admin.layouts.master')

@section('title')
    Tạo mới thuộc tính và giá trị thuộc tính
@endsection

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <div class="row m-3">

        <div class="col-md-4">
            <div class="card-body">
                <h2 class="h2 mt-3 text-center fw-bold" style="color: orange">Thêm giá trị thuộc tính</h2>
                <form action="{{ route('admin.attribute_values.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 mb-2">
                        <label for="value" class="form-label">Tên giá trị thuộc tính</label>
                        <input type="text" name="value" class="form-control " required>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">Tạo giá trị thuộc tính</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-body">
                <h3>Danh sách thuộc tính</h3>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 5%">STT</th>
                                <th style="width: 70%">Tên</th>
                                <th style="width: 5%">Loại</th>
                                <th style="width: 20%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listAttribute as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><a href="{{ route('admin.attributes.show', $item->id) }}">{{ $item->name }}</a></td>
                                    <td>{{ $item->attribute_type->type_name }}</td>
                                    <td>
                                        <a href="{{ route('admin.attributes.edit', $item->id) }}" class="btn btn-warning">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('admin.attributes.destroy', $item->id) }}" class="d-inline" method="POST" onsubmit="return confirm('Bạn có đồng ý xóa hay không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
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

@endsection
