@extends('admin.layouts.master')
@section('title')
Danh sách sản phẩm
@endsection

@section('style-libs')
<!-- Custom styles for this page -->
<link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/admin/product/index.css')}}">
@endsection

@section('script-libs')
<!-- Page level plugins -->
<script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('theme/admin/js/demo/datatables-demo.js') }}"></script>
<script src="{{asset('js/admin/product/index.js')}}"></script>
@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <div class="d-flex flex-row align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>
                <a href="{{route('admin.products.index')}}">
                    <span class="ml-3 btn btn-outline-primary btn-sm" id="active">Đang hoạt động</span>
                </a>
                <a href="{{route('admin.products.index.inactive')}}">
                    <span class="ml-3 btn btn-outline-danger btn-sm" id="inactive">Ngừng hoạt động</span>
                </a>
            </div>
            <div class="mb-2 d-flex justify-content-end">
                <a href="{{route('admin.products.create')}}" class="btn btn-success text-white text-decoration-none btn-sm"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped rounded" id="dataTable" width="100%" cellspacing="0">
                    <thead class="position-sticky top-0">
                        <tr class="bg-primary">
                            <th class="fs-12 text-white">#</th>
                            <th class="fs-12 text-white">ID</th>
                            <th class="fs-12 text-white">Mã</th>
                            <th class="fs-12 text-white">Ảnh</th>
                            <th class="fs-12 text-white">Tên</th>
                            <th class="fs-12 text-white">Lượt xem</th>
                            <th class="fs-12 text-white">Tổng số biến thể</th>
                            <th class="fs-12 text-white">Lượt mua</th>
                            <th class="fs-12 text-white">Trạng thái</th>
                            <th class="fs-12 text-white">Ngày tạo</th>
                            <th class="fs-12 text-white">Ngày cập nhật</th>
                            <th class="fs-12 text-white">Thao tác</th>
                        </tr>
                    </thead>
                    <tfoot class="sticky-bottom">
                        <tr>
                            <th class="fs-12">#</th>
                            <th class="fs-12">Product ID</th>
                            <th class="fs-12">SKU</th>
                            <th class="fs-12">Image</th>
                            <th class="fs-12">Name</th>
                            <th class="fs-12">Views</th>
                            <th class="fs-12">Total variations</th>
                            <th class="fs-12">Purchases</th>
                            <th class="fs-12">Status</th>
                            <th class="fs-12">Created at</th>
                            <th class="fs-12">Updated at</th>
                            <th class="fs-12">Control</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if ($listProducts!='')
                        @foreach ($listProducts as $key => $product)
                        <tr class="small">
                            <td>{{$key+1}}</td>
                            <td>{{$product->id}}</td>
                            <td>{{$product->SKU}}</td>
                            <td>
                                <img src="{{asset('uploads/products/images/'.$product->mainImage)}}" alt="" width="100" height="100">
                            </td>
                            <td>
                                <a class="cspt" href="{{route('admin.products.show',$product->id)}}">{{Str::limit($product->name,30,'...')}}</a>
                            </td>
                            <td>{{$product->view}}</td>
                            <td>{{$product->product_variants_count}}</td>
                            <td>{{$product->total_sold}}</td>
                            <td>
                                @if($product->is_active==1)
                                <span class="text-white badge badge-success">Đang hoạt động</span>
                                @else
                                <span class="text-white badge badge-danger">Ngừng bán</span>
                                @endif
                            </td>
                            <td>{{$product->created_at}}</td>
                            <td>{{$product->updated_at}}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <div class="d-flex flex-row justify-content-center">
                                        <a href="{{route('admin.products.show',$product->id)}}" class="btn btn-secondary btn-sm d-flex align-items-center mr-1"><i class="fas fa-eye fa-sm p-2"></i></a>
                                        @if($product->is_active==1)
                                        <a href="{{route('admin.products.index.changestatus',$product->id)}}" class="btn btn-danger btn-sm d-flex align-items-center"><i class="fas fa-lock fa-sm p-2"></i></a>
                                        @else
                                        <a href="{{route('admin.products.index.changestatus',$product->id)}}" class="btn btn-success btn-sm d-flex align-items-center"><i class="fas fa-lock-open fa-sm p-2"></i></a>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-row justify-content-center mt-2">
                                        <a href="{{route('admin.products.edit',$product->id)}}" class="btn btn-warning btn-sm d-flex align-items-center mr-1"><i class="fas fa-pen-to-square fa-sm p-2"></i></a>
                                        <!-- <a href="" class="btn btn-primary btn-sm d-flex align-items-center mr-1"><i class="fas fa-file-export fa-sm mr-1"></i>Export</a> -->
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="9" align="center">Không có sản phẩm nào có sẵn!</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection