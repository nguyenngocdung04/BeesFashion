{{-- @extends('admin.layouts.master')
@section('title')
    Danh sách khách hàng
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

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">List customers</h1>
        <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                    For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                        DataTables documentation</a>.</p> -->
        <p class="mb-2">Below is a list of customers</p>
        <!-- DataTales Example -->
        <div class="card shadow mb-4 ">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data of all customers</h6>

            </div>
            <div class="card-body">
                <h1>Thông tin chi tiết khách hàng</h1>
                <p>Username: {{ $customer->username }}</p>
                <p>Email: {{ $customer->email }}</p>
                <p>Tên: {{ $customer->defaultShippingAddress->full_name }}</p>
                <p>Điện thoại: {{ $customer->defaultShippingAddress->phone_number }}</p>
                <p>Địa chỉ: {{ $customer->defaultShippingAddress->address }}</p>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection --}}
