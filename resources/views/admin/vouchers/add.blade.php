<!-- Modal thêm sản phẩm -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Danh sách sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <form action="{{ route('admin.vouchers.addProductVoucher') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <input type="hidden" name="id" value="{{ $getVoucher->id }}">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Mô tả</th>
                                    <th>Chọn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allProducts as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><img src="{{ $item->product_files[0]->file_name ? asset('uploads/products/images/' .  $item->product_files[0]->file_name) : asset('assets/images/icons/noimage.png') }}" 
                                            width="50px" ></td>
                                            <td>{{ \Illuminate\Support\Str::limit($item->name, 25) }} </td>
                                            <td>{!! \Illuminate\Support\Str::limit(strip_tags($item->description), 25) !!}</td>
                                        <td>
                                            @if (in_array($item->id, $showProductVoucherIds))
                                            <i class="fa-solid fa-x text-danger"></i>
                                        @else
                                            <input type="checkbox" name="product_ids[]" value="{{ $item->id }}">
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
            </div>
        </div>
    </div>

