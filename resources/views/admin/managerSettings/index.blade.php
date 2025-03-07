@extends('admin.layouts.master')
@section('title')
    Quản lý nhân viên
@endsection
@section('style-libs')
    <!-- Custom styles for this page -->
    <link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4 ">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách chức năng phân quyền</h6>
                <a href="{{ route('admin.managerSettings.create') }}"
                    class="btn btn-success text-white text-decoration-none btn-sm"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên chức năng</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($managerSettings as $parentKey  => $parentSetting)
                                <!-- Hiển thị chức năng cha -->
                                <tr>
                                    <td><strong>{{ $parentKey  + 1 }}</strong></td>
                                    <td><strong>{{ $parentSetting->manager_name }}</strong></td>
                                    <td>
                                        <a href="{{ route('admin.managerSettings.edit', $parentSetting->id) }}"
                                            class="btn btn-warning btn-sm" title="Sửa"><i class="fas fa-pen-to-square fa-sm mr-1"></i>Sửa</a>
                                        <form action="{{ route('admin.managerSettings.destroy', $parentSetting->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa chức năng này?')"><i class="fa-solid fa-trash fa-sm mr-1"></i>Xoá</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Hiển thị chức năng con (nếu có) -->
                                @foreach ($parentSetting->children_manager_setting as $childKey  => $childSetting)
                                    <tr>
                                        <td>{{ $parentKey + 1 }}.{{ $childKey + 1 }}</td>
                                        <td style="padding-left: 30px;">- {{ $childSetting->manager_name }}</td>
                                        <td>
                                            <a href="{{ route('admin.managerSettings.edit', $childSetting->id) }}"
                                                class="btn btn-warning btn-sm" title="Sửa"><i class="fas fa-pen-to-square fa-sm mr-1"></i>Sửa</a>
                                            <form action="{{ route('admin.managerSettings.destroy', $childSetting->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa chức năng này?')"><i class="fa-solid fa-trash fa-sm mr-1"></i>Xoá</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
@section('script-libs')
    <!-- Page level plugins -->
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('theme/admin/js/demo/datatables-demo.js') }}"></script>
@endsection
