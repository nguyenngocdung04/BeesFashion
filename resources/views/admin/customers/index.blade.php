@extends('admin.layouts.master')
@section('title')
    Danh sách khách hàng
@endsection
@section('style-libs')
    <!-- Custom styles for this page -->
    <link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <!--<h1 class="h3 mb-2 text-gray-800">Danh sách khách hàng</h1>
         <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                                            For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                                                DataTables documentation</a>.</p>
        <p class="mb-2">Dưới đây là danh sách khách hàng</p>-->
        <!-- DataTales Example -->
        <div class="card shadow mb-2 ">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách khách hàng</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên đầy đủ</th>
                                <th>Tên người dùng</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Số đơn hàng đã đặt</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tfoot class="sticky-bottom">
                            <tr>
                                <th>STT</th>
                                <th>Tên đầy đủ</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Số đơn hàng đã đặt</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($customers as $key => $customer)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $customer->full_name ?? 'Đang cập nhật' }}</td>
                                    <td>{{ $customer->username }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone ?? 'Đang cập nhật' }}</td>
                                    <td>{{ $customer->address ?? 'Đang cập nhật' }}</td>
                                    <td>{{ $customer->successful_orders_count ?? 'Chưa có đơn hàng nào' }}</td>
                                    <td>
                                        @if ($customer->status === 'active')
                                            <span class="badge badge-success">Hoạt động</span>
                                        @elseif ($customer->status === 'banned')
                                            <span class="badge badge-danger">Bị khóa</span>
                                        @else
                                            <span class="badge badge-secondary">Không rõ</span>
                                        @endif
                                    </td>

                                    {{-- <td>
                                        <a class="btn btn-info btn-sm"
                                            href="{{ route('admin.customers.show', $customer->id) }}">Show</a>
                                        <a class="btn btn-warning btn-sm"
                                            href="{{ route('admin.customers.edit', $customer->id) }}">Edit</a>
                                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td> --}}
                                    <td>
                                        {{-- <a class="btn btn-warning btn-sm mt-1"
                                            href="{{ route('admin.customers.edit', $customer->id) }}" title="Sửa"><i
                                                class="fas fa-pen-to-square fa-sm mr-1"></i>Sửa</a> --}}
                                        <a class="btn btn-info btn-sm mt-1"
                                            href="{{ route('admin.customers.history', $customer->id) }}"
                                            title="Lịch sử ban/unban"><i class="fas fa-history fa-sm mr-1"></i>Lịch sử</a>
                                        <div class="d-flex mt-1">
                                            @if ($customer->status === 'active')
                                                <!-- Nút Ban -->
                                                <button class="btn btn-danger btn-sm mr-1" type="button"
                                                    onclick="openBanModal('{{ route('admin.customers.ban', $customer->id) }}')"
                                                    title="Ban">
                                                    <i class="fa-solid fa-ban fa-sm mr-1"></i>Khóa
                                                </button>
                                            @elseif ($customer->status === 'banned')
                                                <!-- Nút Unban -->
                                                <form action="{{ route('admin.customers.unban', $customer->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button class="btn btn-success btn-sm mr-1" type="submit"
                                                        title="Unban">
                                                        <i class="fas fa-user-check fa-sm mr-1"></i>Mở khóa
                                                    </button>
                                                </form>
                                            @endif
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

    <div class="modal fade" id="banModal" tabindex="-1" role="dialog" aria-labelledby="banModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="banForm" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="banModalLabel">Khóa tài khoản</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="reason">Lý do khóa:</label>
                        <textarea name="reason" id="reason" class="form-control" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Khóa</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openBanModal(url) {
            $('#banForm').attr('action', url);
            $('#banModal').modal('show');
        }
    </script>
@endsection
@section('script-libs')
    <!-- Page level plugins -->
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('theme/admin/js/demo/datatables-demo.js') }}"></script>
@endsection
