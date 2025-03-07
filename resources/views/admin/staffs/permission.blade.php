@extends('admin.layouts.master')
@section('style-libs')
    <!-- Custom styles for this page -->
    <link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        <h1 class="h2 mt-3 mb-4 text-center text-gray-800 fw-bold">Phân quyền cho nhân viên: {{ $user->full_name }}</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách chức năng phân quyền</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên chức năng</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($allPermissions as $parentKey => $parentPermission)
                                <!-- Hiển thị chức năng cha -->
                                <tr>
                                    <td>{{ $parentKey + 1 }}</td>
                                    <td><strong>{{ $parentPermission->manager_name }}</strong></td>
                                    <td>
                                        @if (in_array($parentPermission->id, $userPermissions))
                                            <span class="badge bg-success badge-success">Đã cấp quyền</span>
                                        @else
                                            <span class="badge bg-danger badge-danger">Chưa cấp quyền</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.staffs.permissions.toggle', [$user->id, $parentPermission->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-{{ in_array($parentPermission->id, $userPermissions) ? 'danger' : 'success' }} btn-sm">
                                                {{ in_array($parentPermission->id, $userPermissions) ? 'Xoá quyền' : 'Cấp quyền' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Hiển thị các chức năng con (nếu có) -->
                                @foreach ($parentPermission->children_manager_setting as $childKey => $childPermission)
                                    <tr>
                                        <td>{{ $parentKey + 1 }}.{{ $childKey + 1 }}</td>
                                        <td style="padding-left: 30px;">- {{ $childPermission->manager_name }}</td>
                                        <td>
                                            @if (in_array($childPermission->id, $userPermissions))
                                                <span class="badge bg-success badge-success">Đã cấp quyền</span>
                                            @else
                                                <span class="badge bg-danger badge-danger">Chưa cấp quyền</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.staffs.permissions.toggle', [$user->id, $childPermission->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-{{ in_array($childPermission->id, $userPermissions) ? 'danger' : 'success' }} btn-sm">
                                                    {{ in_array($childPermission->id, $userPermissions) ? 'Xoá quyền' : 'Cấp quyền' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <div>
                    <a href="{{ route('admin.staffs.index') }}" class="btn btn-secondary text-white text-decoration-none"><i class="fa-solid fa-arrow-left mr-1"></i>Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script-libs')
    <!-- Page level plugins -->
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('theme/admin/js/demo/datatables-demo.js') }}"></script>
@endsection
