@extends('user.layouts.master')

@section('content')
<!-- Container content -->
<main>
    <section class="section-b-space py-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 px-0">
                    <div class="order-box-1"><img src="{{asset('assets/images/gif/failed.png')}}" width="100px" alt="">
                        <h4>Đặt hàng không thành công</h4>
                        <p>Thanh toán không thành công</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space">
        <div class="custom-container container order-success">
            <div class="row gy-4">
                <div class="col-xl-8">
                    <div class="order-items sticky">
                        <h4>Thông tin đặt hàng </h4>
                        <p>
                            Hóa đơn đặt hàng đã được gửi đến tài khoản email đã đăng ký của bạn. kiểm tra kỹ chi tiết đơn hàng của bạn
                        </p>
                        <div class="order-table">
                            <div class="table-responsive theme-scrollbar">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm </th>
                                            <th>Giá </th>
                                            <th>Số lượng</th>
                                            <th>Tổng cộng</th>
                                            <th>Giảm giá áp dụng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($get_order))
                                        @foreach ($get_order->order_details as $order_detail)
                                        <tr>
                                            <td style="white-space: normal; word-wrap: break-word; max-width: 310px;">
                                                <div class="cart-box">
                                                    <a href="{{route('product.detail',$order_detail->product_variant->product->id)}}">
                                                        @if ($order_detail->product_variant->image)
                                                        <img src="{{asset('uploads/products/images/'.$order_detail->product_variant->image)}}" alt="" width="100px" height="110px">
                                                        @else
                                                        <img src="https://via.placeholder.com/300x200" alt="">
                                                        @endif
                                                    </a>
                                                    <div class="d-flex flex-column">
                                                        <a href="{{route('product.detail',$order_detail->product_variant->product->id)}}">
                                                            <h5 class="text-truncate mb-1" style="max-width: 100%; white-space: normal;">{{Str::limit($order_detail->product_variant->product->name,30,'...')}}</h5>
                                                        </a>
                                                        <span>{{$order_detail->value_variants}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span>{{number_format($order_detail->original_price,0,'.',',')}} đ</span>
                                            </td>
                                            <td>{{$order_detail->quantity}}</td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-end">
                                                    <span>{{number_format($order_detail->original_price*$order_detail->quantity,0,'.',',')}} đ</span>
                                                    @if ($order_detail->amount_reduced!=0)
                                                    <span class="text-danger">-{{number_format($order_detail->amount_reduced,0,'.',',')}} đ</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="fw-bold text-success">{{number_format(($order_detail->original_price*$order_detail->quantity)-$order_detail->amount_reduced,0,'.',',')}} đ</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="4">
                                                <span class="text-danger">Không có dữ liệu sản phẩm</span>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="total fw-bold">
                                                Tổng cộng :
                                            </td>
                                            <td class="total fw-bold">
                                                <div class="d-flex flex-column align-items-end">
                                                    <span class="fs-5 text-dark {{$get_order->voucher!=0?"text-decoration-line-through":"fw-bold"}}">{{number_format($get_order->total_cost+$get_order->voucher,0,'.',',')}} đ</span>
                                                    @if ($get_order->voucher!=0)
                                                    <span class="fs-5 text-success fw-bold">{{number_format($get_order->total_cost,0,'.',',')}} đ</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="summery-box">
                        <div class="sidebar-title">
                            <div class="loader-line"></div>
                            <h4>Chi tiết đặt hàng </h4>
                        </div>
                        <div class="summery-content">
                            <ul>
                                <li>
                                    <p class="fw-semibold">Tổng sản phẩm ({{count($get_order->order_details)}})</p>
                                    <h6>{{number_format($get_order->total_cost+$get_order->voucher,0,'.',',')}} đ</h6>
                                </li>
                                <li>
                                    <p>Vận chuyển đến </p><span>Vietnam</span>
                                </li>
                                <li>
                                    <p>Phương thức thanh toán </p><span>{{$get_order->payment_method}}</span>
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <p>Phí vận chuyển</p><span>{{number_format($get_order->shipping_price,0,'.',',')}} đ</span>
                                </li>
                                <li>
                                    <p>Thuế <span>(0,5% tổng giá trị đơn hàng)</span> </p><span>{{number_format($get_order->tax,0,'.',',')}} đ</span>
                                </li>
                                <li>
                                    <p>Giảm giá vận chuyển</p><span class="text-danger">-{{number_format($get_order->shipping_voucher,0,'.',',')}} đ</span>
                                </li>
                                <li>
                                    <p>Giảm giá</p><span class="text-danger">-{{number_format($get_order->voucher,0,'.',',')}} đ</span>
                                </li>
                            </ul>
                            <div class="d-flex align-items-center justify-content-between">
                                <h6>Tổng cộng (VND)</h6>
                                <h5>{{number_format($get_order->total_payment,0,'.',',')}} đ</h5>
                            </div>
                            {{-- <div class="note-box">
                                <p>Mình rất mong cửa hàng có thể làm việc với mình để giao hàng trong thời gian sớm nhất
                                    bởi vì tôi thực sự cần nó để tặng cho bạn tôi trong bữa tiệc vào tuần tới. Cảm ơn rất nhiều!
                                </p>
                            </div> --}}
                        </div>
                    </div>
                    <div class="summery-footer">
                        <div class="sidebar-title">
                            <div class="loader-line"></div>
                            <h4>Địa chỉ giao hàng</h4>
                        </div>
                        <ul>
                            <li>
                                <h6>Họ tên: {{$get_order->full_name}}</h6>
                                <h6>Số điện thoại: {{$get_order->phone_number}}</h6>
                                <h6>Địa chỉ:{{$get_order->address}}</h6>
                            </li>
                            <li>
                                <h6>Ngày dự kiến giao hàng: <a href="{{env('APP_URL')}}/dashboard?tab=order"><span>Theo dõi đơn hàng</span></a></h6>
                            </li>
                            <li>
                                <h5>{{$get_order->created_at->format('M d, Y')}}</h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End container content -->
@endsection
