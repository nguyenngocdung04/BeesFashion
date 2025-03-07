<!-- Modal thêm sản phẩm -->
<form action="{{ route('admin.categories.updateBestSelling', $currentCategory->id) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Danh sách sản phẩm - Danh mục:
                        {{ $currentCategory->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($allProducts->isEmpty())
                        <p class="text-center">Không có sản phẩm nào để hiển thị.</p>
                    @else
                        <div id="productTable" class="table-responsive">
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
                                            <td><img src="{{ isset($item->product_files[0]) ? asset('uploads/products/images/' . $item->product_files[0]->file_name) : asset('assets/images/icons/noimage.png') }}"
                                                    width="50px">
                                            </td>
                                            <td>{{ \Illuminate\Support\Str::limit($item->name, 25) }} </td>
                                            <td>{!! \Illuminate\Support\Str::limit(strip_tags($item->description), 25) !!}</td>
                                            </td>

                                            <td>
                                                @if (in_array($item->id, $bestSellingProductIds))
                                                    <i class="fa-solid fa-x text-danger"></i>
                                                @else
                                                    <input type="checkbox" name="product_ids[]"
                                                        value="{{ $item->id }}">
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#productTable').DataTable();
    });
</script>