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
                <h6 class="m-0 font-weight-bold text-primary">Danh sách nhân viên</h6>
                <a href="{{ route('admin.staffs.create') }}" class="btn btn-success text-white text-decoration-none btn-sm"><i class="fas fa-plus mr-2"></i>Thêm nhân viên</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Họ tên</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Địa chỉ</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tfoot class="sticky-bottom">
                            <tr>
                                <th>#</th>
                                <th>Họ tên</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Địa chỉ</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($staffs as $key => $staff)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $staff->full_name ?? 'Đang cập nhật' }}</td>
                                    <td>{{ $staff->username }}</td>
                                    <td>{{ $staff->email }}</td>
                                    <td>{{ $staff->phone ?? 'Đang cập nhật' }}</td>
                                    <td>{{ $staff->address ?? 'Đang cập nhật' }}</td>
                                    <td>{!! $staff->status === 'active' ? '<span class="badge text-light bg-success">Hoạt động</span>' : '<span class="badge bg-danger text-light">Ngưng hoạt động</span>' !!}</td>

                                    <td>
                                        <a class="btn btn-warning btn-sm" href="{{ route('admin.staffs.edit', $staff->id) }}" title="Sửa"><i class="fas fa-pen-to-square fa-sm mr-1"></i>Sửa</a>
                                        <a class="btn btn-primary btn-sm" href="{{ route('admin.staffs.permission', $staff->id) }}" title="Phân quyền"><i class="fas fa-key fa-sm mr-1"></i>Phân quyền</a>
                                        <a class="btn btn-info btn-sm" href="{{ route('admin.staffs.history', $staff->id) }}" title="Lịch sử ban/unban"><i
                                                class="fas fa-history fa-sm mr-1"></i>Lịch sử</a>
                                        <div class="d-flex mt-1">
                                            @if ($staff->status === 'active')
                                                <!-- Nút Ban với mở modal -->
                                                <button class="btn btn-danger btn-sm mr-1" type="button" onclick="openBanModal('{{ route('admin.staffs.ban', $staff->id) }}')" title="Khoá"><i
                                                        class="fa-solid fa-ban fa-sm mr-1"></i>Khoá</button>
                                            @elseif ($staff->status === 'banned')
                                                <!-- Nút Unban -->
                                                <form action="{{ route('admin.staffs.unban', $staff->id) }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-success btn-sm mr-1" type="submit" title="Mở khoá"><i class="fas fa-user-check fa-sm mr-1"></i>Mở khoá</button>
                                                </form>
                                            @endif
                                            {{-- <form action="{{ route('admin.staffs.destroy', $staff->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure?')"><i class="fa-solid fa-trash fa-sm mr-1"></i>Xóa</button>
                                        </form> --}}
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ban-->
    <div class="modal fade" id="banModal" tabindex="-1" role="dialog" aria-labelledby="banModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="banModalLabel">Khoá nhân viên</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="banForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="banReason">Lý do ban</label>
                            <textarea class="form-control" id="banReason" name="reason" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger">Khoá</button>
                    </div>
                </form>
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
    <script>
        function openBanModal(banUrl) {
            // Cập nhật action của form
            document.getElementById('banForm').action = banUrl;
            // Hiển thị modal
            $('#banModal').modal('show');
        }
    </script>
@endsection
