@extends('admin.layouts.master')
@section('title')
    Chỉnh sửa thuộc tính
@endsection
@section('content')
    <div class="row">
        <!-- Phần form thêm mới -->
        <div class="card shadow col-md-4">
            <h1 class="h3 mt-3 text-center fw-bold">Chỉnh sửa thuộc tính</h1>
            <div class="card-body">
                <form action="{{ route('admin.attributes.update', $AttributesID->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mt-3 mb-2">
                        <label for="name" class="form-label">Tên thuộc tính</label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"value="{{ $AttributesID->name }}">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mt-3 mb-3">
                        <label for="attribute_type_id" class="form-label">Loại</label>
                        <select name="attribute_type_id" id="attribute_type_id"
                            class="form-control form-control-sm mb-3 @error('attribute_type_id') is-invalid @enderror"
                            aria-label="small select example">
                            <option value="" disabled {{ old('attribute_type_id') ? '' : 'selected' }}>Chọn loại thuộc
                                tính</option>
                            @if ($listAttributeTypes->isEmpty())
                                <option value="" selected>Không có loại thuộc tính nào</option>
                            @else
                                @foreach ($listAttributeTypes as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('attribute_type_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->type_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>


                        {{-- <label for="attribute_type_id" class="form-label">Loại</label>
                        <select name="attribute_type_id" id="attribute_type_id" class="form-select form-select-sm mb-3"
                            aria-label="small select example"  >
                            @if ($listAttributeTypes->isEmpty())
                                <option value="">Không có loại thuộc tính nào</option>
                            @else
                                <option value="" >Chọn loại thuộc tính</option>
                                @foreach ($listAttributeTypes as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('attribute_type_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->type_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select> --}}
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">Chỉnh sửa thuộc tính</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Phần danh sách -->

        <div class=" card shadow col-md-8">
            <div class="card-body">
                <h3>Danh sách thuộc tính</h3>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
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
                                    <td>
                                        @if (!$item->attribute_type)
                                            <a href="javascript:void(0);"
                                                class="text-decoration-none font-weight-bold notification-trigger"
                                                data-item-id="{{ $item->id }}">
                                                {{ $item->name }}
                                            </a>
                                        @else
                                            <a class="text-decoration-none font-weight-bold"
                                                href="{{ route('admin.attribute_values.show', $item->id) }}">
                                                {{ $item->name }}
                                            </a>
                                        @endif
                                    </td>
                                    @if ($item->attribute_type)
                                        <td>{{ $item->attribute_type->type_name }}</td>
                                    @else
                                        <td class="text-center text-danger">Chưa có loại</td>
                                    @endif
                                    <td>
                                        <a href="{{ route('admin.attributes.edit', $item->id) }}"
                                            class="btn btn-warning"><i class="fa fa-pencil-alt"></i></a>
                                        <form action="{{ route('admin.attributes.destroy', $item->id) }}" class="d-inline"
                                            method="POST" onsubmit="return confirm('Bạn có đồng ý xóa hay không?')">
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
    <script>
        document.querySelectorAll('.notification-trigger').forEach(function(link) {
            link.addEventListener('click', function() {
                // Hiển thị thông báo nếu người dùng chưa chọn loại thuộc tính
                notification('warning', 'Vui lòng chọn loại thuộc tính!', 'Warning!', '2000');
            });
        });
    </script>
@endsection
