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
            <a href="{{ route('admin.banner.index') }}" class="btn btn-dark text-white text-decoration-none"><i
                    class="fas fa-arrow-left"></i> Quay lại</a>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Cập nhật banner</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.banner.update', $Ban->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Tên Banner</label>
                        <input type="text" name="name" id="name" value="{{ $Ban->name }}"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="" class="form-label">Album ảnh:</label>
                            <a id="add-row"><i class="fa fa-plus text-muted fs-18 rounded-2 border ms-3"
                                    style="cursor: pointer;"></i></a>
                            <table class="table align-middle table-nowrap mb-0">
                                <tbody id="image-table-body">
                                    @foreach ($Ban->banner_images as $index => $image)
                                        <tr>
                                            <td class="d-flex align-items-center">
                                                <img class="me-3" id="preview_{{ $index }}"
                                                    src="{{ asset('uploads/banners/images/id_' . $Ban->id . '/' . $image->file_name) }}"
                                                    alt="Hình ảnh sản phẩm" style="width: 50px;">
                                                <input type="file" id="hinh_anh" class="form-control"
                                                    name="file_name[{{ $image->id }}]"
                                                    onchange="previewImage(this, {{ $index }})">
                                                <input type="hidden" name="file_name[{{ $image->id }}]"
                                                    value="{{ $image->id }}">
                                            </td>
                                            <td>
                                                <i class="fa fa-trash-alt" style="color: red; cursor: pointer;"
                                                    onclick="removeRow(this)"></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Kích Hoạt</label>
                        <input type="checkbox" name="is_active" value="1" {{ $Ban->is_active ? 'checked' : '' }}>

                    </div>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </form>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var rowCount = 1;


            document.getElementById('add-row').addEventListener('click', function() {
                // alert('ấn rồi'); // Alert message when the button is clicked

                var tableBody = document.getElementById('image-table-body');
                var newRow = document.createElement('tr');

                newRow.innerHTML = `
                    <td class="d-flex align-items-center">
                        <img class="me-3" id="preview_${rowCount}"src="data:image/png;base64,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"
                        alt="Hình ảnh sản phẩm" style="width: 50px;">
                        <input type="file" class="form-control" 
                            name="file_name[id_${rowCount}]"
                            onchange="previewImage(this, ${rowCount})">
                    </td>
                    <td>
                        <i class="fa fa-trash-alt" style="color: red; cursor: pointer;" onclick="removeRow(this)"></i>
                    </td>`;

                tableBody.appendChild(newRow);
                rowCount++;
            });
        });

        function previewImage(input, rowIndex) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById(`preview_${rowIndex}`).setAttribute('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeRow(item) {
            var row = item.closest('tr');
            row.remove();
        }
        // console.log($product);
    </script>
@endsection
