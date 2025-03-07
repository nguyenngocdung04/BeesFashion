@extends('admin.layouts.master')
@section('title')
Danh sách danh mục
@endsection
@section('style-libs')
<!-- Custom styles for this page -->
<link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin/order/index.css') }}">
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
<div class="page-wrapper cardhead">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <a href="{{ route('admin.orders.index') }}"><i class="fa fa-angle-left"></i> Quản lý đơn hàng</a>
                    <div class="flex justify-between">
                        <div class="index__card-title--rzIx0 font-semibold">
                            <div class="flex items-center"><span
                                    class="mr-2">#{{ $getInfo->id }}</span></div>
                        </div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="flex justify-between">
                                    <div class="index__card-title--rzIx0 font-semibold">
                                        <div class="flex items-center"><span class="mr-2">
                                                {{
                                                    $latestStatus 
                                                    ? ($latestStatus->status->name == 'Processing' ? 'Chờ xử lý' : 
                                                       ($latestStatus->status->name == 'Pending' ? 'Chờ xác nhận' : 
                                                       ($latestStatus->status->name == 'Shipping' ? 'Đang vận chuyển' : 
                                                       ($latestStatus->status->name == 'Completed' ? 'Đã hoàn thành' : 
                                                       ($latestStatus->status->name == 'Cancelled' ? 'Đã hủy' : 
                                                       ($latestStatus->status->name == 'Returned' ? 'Hoàn trả' : $latestStatus->status->name)))))) 
                                                    : 'Chưa có trạng thái' 
                                                }}

                                                <br>
                                            </span></div>
                                    </div>
                                    <div></div>
                                </div>
                                <div class="completed-box">
                                    <div class="KeyValuePair">
                                        <div class="text-header">
                                            <div class="truncate">Vị trí</div>
                                        </div>
                                        <div class="text-footer">Việt Nam</div>
                                    </div>
                                    <div class="KeyValuePair">
                                        <div class="text-header">
                                            <div class="truncate">Thời gian tạo</div>
                                        </div>
                                        <div class="text-footer">{{ $getInfo->created_at->format('d/m/Y H:i:s') }}
                                        </div>
                                    </div>
                                    <div class="KeyValuePair">
                                        <div class="text-header">
                                            <div class="truncate">Phương thức thanh toán</div>
                                        </div>
                                        <div class="text-footer">
                                            @if ($getInfo->payment_method === 'cod')
                                            Thanh toán khi nhận hàng
                                            @else
                                            Thanh toán online
                                            @endif
                                        </div>
                                    </div>
                                    <div class="KeyValuePair">
                                        <div class="text-header">
                                            <div class="truncate">Tên người đặt</div>
                                        </div>
                                        <div class="text-footer">{{ $getInfo->full_name }}</div>
                                    </div>
                                    <div class="KeyValuePair">
                                        <div class="text-header">
                                            <div class="truncate">Địa chỉ</div>
                                        </div>
                                        <div class="text-footer">{{ $getInfo->address }}</div>
                                    </div>
                                    <div class="KeyValuePair">
                                        <div class="text-header">
                                            <div class="truncate">Thông tin liên hệ</div>
                                        </div>
                                        <div class="text-footer">{{ $getInfo->phone_number }}</div>
                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="flex justify-between">
                                    <div class="index__card-title--rzIx0 font-semibold">
                                        <div class="flex items-center"><span class="mr-2">Đơn hàng hiện tại</span>
                                        </div>
                                    </div>
                                    <div></div>
                                </div>
                                @foreach ($getInfo->order_details as $detail)
                                <div class="card-header">
                                    <p class="card-title">ID SKU : {{ $detail->product_variant->SKU }}</p>
                                    <div class="product-info">
                                        <div class="info-image">

                                            <img src="{{ asset('uploads/products/images/' . $detail->product_variant->image) }}"
                                                alt="Product Image" width="60" height="60" style="border-radius:8px"><br>

                                        </div>
                                        <div class="info-des">
                                            <div class="des-header">{{ $detail->product_variant->product->name }}
                                            </div>
                                            <div class="des-footer">{{ $detail->value_variants }}</div>
                                        </div>
                                        <div class="info-price">
                                            <div class="price">
                                                {{ number_format($detail->original_price, 0, ',', '.') }}₫ x
                                                {{ $detail->quantity }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="flex justify-between">
                                    <div class="index__card-title--rzIx0 font-semibold">
                                        <div class="flex items-center"><span class="mr-2">Lịch sử đơn hàng</span>
                                        </div>
                                    </div>
                                    <div></div>
                                </div>
                            </div>
                            <div class="list-history">
                                <!-- Luôn hiển thị trạng thái đầu tiên -->
                              
                            
                                <!-- Hiển thị các trạng thái còn lại -->
                                @foreach ($statusOrders->reverse() as $status)
                                    <div class="listitem">
                                        <div class="theme-arco-timeline-item-dot-wrapper">
                                            <div class="theme-arco-timeline-item-dot-line theme-arco-timeline-item-dot-line-is-vertical" style="border-left-style: dashed;"></div>
                                            <div class="theme-arco-timeline-item-dot-content">
                                                <div class="theme-arco-timeline-item-dot-custom
                                                @if ($status->status_id == 1) active @endif
                                                    @if ($status->status_id == 2) active @endif
                                                    @if ($status->status_id == 3) active @endif
                                                    @if ($status->status_id == 4) active @endif
                                                    @if ($status->status_id == 5) active @endif
                                                    @if ($status->status_id == 6) active @endif
                                                ">
                                                    <div class="theme-arco-timeline-item-parent-dot theme-arco-timeline-item-status-finished theme-arco-timeline-item-dotType-hollow-finished"></div>
                                                </div>
                                            </div>
                                        </div>
                            
                                        <div class="theme-arco-timeline-item-dot-wrapper">
                                            <div class="theme-arco-timeline-item-dot-content">
                                                @if ($status->status_id == 2)
                                                    <div class="sc-jeGSBP">Đơn hàng đang chờ xác nhận</div>
                                                    <div class="text-sm font-regular text-gray-3">
                                                        {{ $status->created_at->format('d/m/Y H:i:s') }}
                                                    </div>
                                                @elseif($status->status_id == 3)
                                                    <div class="sc-jeGSBP">Đơn hàng đã đang được vận chuyển</div>
                                                    <div class="text-sm font-regular text-gray-3">
                                                        {{ $status->created_at->format('d/m/Y H:i:s') }}
                                                    </div>
                                                @elseif($status->status_id == 4)
                                                    <div class="sc-jeGSBP">Đơn đặt hàng đã hoàn thành</div>
                                                    <div class="text-sm font-regular text-gray-3">
                                                        {{ $status->created_at->format('d/m/Y H:i:s') }}
                                                    </div>
                                                    @elseif($status->status_id == 1)
                                                    <div class="sc-jeGSBP">Đơn hàng đang chờ xử lý</div>
                                                    <div class="text-sm font-regular text-gray-3">
                                                        {{ $status->created_at->format('d/m/Y H:i:s') }}
                                                    </div>
                                                @elseif($status->status_id == 5)
                                                    <div class="sc-jeGSBP">Đơn hàng đã bị hủy bởi khách hàng</div>
                                                    <div class="text-sm font-regular text-gray-3">
                                                        {{ $status->created_at->format('d/m/Y H:i:s') }}
                                                    </div>
                                                @elseif($status->status_id == 6)
                                                    <div class="sc-jeGSBP">Đơn hàng giao không thành công</div>
                                                    <div class="text-sm font-regular text-gray-3">
                                                        {{ $status->created_at->format('d/m/Y H:i:s') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="listitem">
                                    <div class="theme-arco-timeline-item-dot-wrapper">
                                        <div class="theme-arco-timeline-item-dot-line theme-arco-timeline-item-dot-line-is-vertical" style="border-left-style: dashed;"></div>
                                        <div class="theme-arco-timeline-item-dot-content">
                                            <div class="theme-arco-timeline-item-dot-custom active">
                                                <div class="theme-arco-timeline-item-parent-dot theme-arco-timeline-item-status-finished theme-arco-timeline-item-dotType-hollow-finished"></div>
                                            </div>
                                        </div>
                                    </div>
                            
                                    <div class="theme-arco-timeline-item-dot-wrapper">
                                        <div class="theme-arco-timeline-item-dot-content">
                                            <div class="sc-jeGSBP">Đơn hàng do khách hàng tạo</div>
                                            <div class="text-sm font-regular text-gray-3">
                                                {{ $statusOrders->first()->created_at->format('d/m/Y H:i:s') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="flex justify-between">
                                    <div class="index__card-title--rzIx0 font-semibold">
                                        <div class="flex items-center">
                                            <span class="mr-2"> Những gì khách hàng của bạn đã thanh toán</span>
                                        </div>
                                    </div>
                                    <div></div>
                                </div>
                                <div class="flex justify-between">
                                    <div class="font-regular text-base text-gray-2">Phương thức thanh toán</div>
                                    <div class="font-regular text-base text-gray-2 flex">
                                        <div class="ml-4">
                                            @if ($getInfo->payment_method === 'cod')
                                            <strong>Thanh toán khi nhận hàng</strong>
                                            @else
                                            <strong>Thanh toán online</strong>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full h-1 my-24 bg-gray-line"></div>
                                <div class="space-y-12">
                                    <div class="PriceCard__SubsContainer-sc-mbai84-1 iKmkmn space-y-12">
                                        <div class="space-y-8">
                                            <div
                                                class="PriceCard__SubTotal-sc-mbai84-3 bXIVTv flex justify-between text-p3-semibold  text-neutral-text2">
                                                <div class="PriceCard__RowLeft-sc-mbai84-5 fgzImO">
                                                    <span>Giá tiền của từng đơn hàng</span>
                                                </div>
                                                <div>
                                                    @foreach ($getInfo->order_details as $detail)
                                                    <div class="PriceCard__RowRight-sc-mbai84-6 gzTJaq">
                                                        {{ number_format($detail->original_price*$detail->quantity, 0, ',', '.') }}₫
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="space-y-8">
                                            <div
                                                class="PriceCard__SubTotal-sc-mbai84-3 bXIVTv flex justify-between text-p3-semibold  text-neutral-text2">

                                                <div class="PriceCard__RowLeft-sc-mbai84-5 fgzImO"><span>Phí vận
                                                        chuyển</span></div>
                                                <div class="PriceCard__RowRight-sc-mbai84-6 gzTJaq">
                                                    {{ number_format($getInfo->shipping_price, 0, ',', '.') }}₫
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-y-8">
                                            <div
                                                class="PriceCard__SubTotal-sc-mbai84-3 bXIVTv flex justify-between text-p3-semibold  text-neutral-text2">

                                                <div class="PriceCard__RowLeft-sc-mbai84-5 fgzImO"><span>Phí vận
                                                        chuyển được giảm</span></div>
                                                <div class="PriceCard__RowRight-sc-mbai84-6 gzTJaq">-
                                                    {{ number_format($getInfo->shipping_voucher, 0, ',', '.') }}₫
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-y-8">
                                            <div
                                                class="PriceCard__SubTotal-sc-mbai84-3 bXIVTv flex justify-between text-p3-semibold  text-neutral-text2">
                                                <div class="PriceCard__RowLeft-sc-mbai84-5 fgzImO">
                                                    <span>Thuế</span>
                                                </div>
                                                <div class="PriceCard__RowRight-sc-mbai84-6 gzTJaq">
                                                    {{ number_format($getInfo->tax, 0, ',', '.') }}₫
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="PriceCard__Total-sc-mbai84-2 dtbnPi flex justify-between text-lg font-bold text-neutral-text1">
                                        <div class="PriceCard__RowLeft-sc-mbai84-5 fgzImO">Tổng cộng</div>
                                        <div class="PriceCard__RowRight-sc-mbai84-6 gzTJaq">
                                            {{ number_format($getInfo->total_payment, 0, ',', '.') }}₫
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="flex justify-between">
                                    <div class="index__card-title--rzIx0 font-semibold">Thông tin khách hàng</div>
                                    <div></div>
                                </div>

                                <div class="w-full h-1 my-24 bg-gray-line"></div>
                                <div>
                                    <div class="flex flex-col">
                                        <div class="font-regular text-gray-3 text-base">Địa chỉ vận chuyển</div>
                                    </div>
                                    <div class="ShippingAddress__AddressCard-sc-j8zs8s-0 dEiFbK mt-12">
                                        <div class="flex text-base font-regular text-gray-1 break-words">
                                            <div class="text-base font-regular text-gray-1 break-words">
                                                Tên: {{ $getInfo->full_name }}</div><span class="sc-fHYxKZ"></span>
                                        </div>
                                        <div class="flex text-base font-regular text-gray-1 break-words">
                                            <div class="text-base font-regular text-gray-1 break-words">
                                                Số điện thoại: {{ $getInfo->phone_number }}</div><span
                                                class="sc-fHYxKZ"><span class="sc-fHYxKZ"></span></span>
                                        </div>
                                        <div
                                            class="ShippingAddress__AddressDetailContainer-sc-j8zs8s-1 dXiFPh text-base font-regular text-gray-1 break-words">
                                            <div class="text-base font-regular text-gray-1 break-words">
                                                Địa chỉ: {{ $getInfo->address }}</div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection