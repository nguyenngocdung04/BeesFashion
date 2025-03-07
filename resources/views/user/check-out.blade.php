@extends('user.layouts.master')
@section('css-libs')
<link rel="stylesheet" href="{{ asset('css/user/check-out.css') }}">
@endsection
@section('script-libs')
<script src="{{ asset('js/user/check-out.js') }}"></script>
@endsection
@section('content')
<!-- Container content -->
<main>
    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Đặt hàng</h4>
                    </div>
                    {{-- <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">Check Out</a></li>
                            </ul>
                        </div> --}}
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="row">
                <div class="col-xxl-9 col-lg-8">
                    <div class="left-sidebar-checkout sticky">
                        <div class="address-option">
                            <div class="address-title">
                                <h4>Địa chỉ giao hàng</h4><a href="#" data-bs-toggle="modal"
                                    data-bs-target="#create-address-modal" title="Add new address" tabindex="0">+ Thêm địa chỉ</a>
                            </div>
                            <div class="swiper address-checkout-slide">
                                <div class="swiper-wrapper" id="listAddresses">
                                    <!-- Hiển thị danh sách địa chỉ nhận hàng ở đây -->
                                </div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                        <div class="payment-options">
                            <h4 class="mb-3">Phương thức thanh toán</h4>
                            <input type="hidden" id="status_cart" value="{{ $check_out_data['is_cart'] }}">
                            <div class="row gy-3">
                                <div class="col-sm-6">
                                    <label class="payment-box" for="cod">
                                        <input class="custom-radio me-2" id="cod" type="radio"
                                            name="radioPayment">
                                        <form method="GET" id="form_cod">
                                        </form>
                                        <label class="no-select" for="cod">Thanh toán khi nhận hàng (COD)</label>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <label class="payment-box" for="vnpay">
                                        <input class="custom-radio me-2" id="vnpay" type="radio"
                                            name="radioPayment">
                                        <form action="{{ route('checkout.vnpay_payment') }}" method="post"
                                            id="form_vnpay">
                                            @csrf
                                            <input type="hidden" name="order_id" class="order_id">
                                            <input type="hidden" name="amount" class="amount">
                                            <!-- <input type="hidden" name="redirect"> -->
                                        </form>
                                        <label class="no-select" for="vnpay">Thanh toán bằng VNPAY</label>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <label class="payment-box" for="momo">
                                        <input class="custom-radio me-2" id="momo" type="radio"
                                            name="radioPayment">
                                        <form action="{{ route('checkout.momo_payment') }}" method="post"
                                            id="form_momo">
                                            @csrf
                                            <input type="hidden" name="order_id" class="order_id">
                                            <input type="hidden" name="amount" class="amount">
                                            <input type="hidden" name="payUrl">
                                        </form>
                                        <label class="no-select" for="momo">Thanh toán bằng MOMO</label>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4">
                    <div class="right-sidebar-checkout">
                        <h4>Đơn hàng</h4>
                        <div class="cart-listing">
                            <ul>
                                @if (!empty($check_out_data) && isset($check_out_data['product_variant_data']))
                                <div class="scroll-container">
                                    <div class="content">
                                        @foreach ($check_out_data['product_variant_data'] as $item)
                                        <li class="position-relative variant_item justify-content-between">
                                            <input type="hidden" class="variant_id" value="{{ $item['id'] }}">
                                            <input type="hidden" class="variant_values"
                                                value="{{ $item['variant_values'] }}">
                                            <input type="hidden" class="variant_quantity"
                                                value="{{ $item['quantity'] }}">
                                            <input type="hidden" class="variant_price" value="{{ $item['price'] }}">
                                            <input type="hidden" class="variant_total_price"
                                                value="{{ $item['quantity'] * $item['price'] }}">
                                            <div class="d-flex flex-row align-items-center">
                                                <img src="{{ asset('uploads/products/images/' . $item['image']) }}"
                                                    width="60px" height="64px" alt="">
                                                <div class="ms-2">
                                                    <h6>{{ Str::limit($item['name'], 20, '...') }}</h6>
                                                    <span>{{ Str::limit($item['variant_values'], 20, '...') }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column align-items-end">
                                                <p class="text-nowrap" style="font-size: 14px;">
                                                    {{ number_format($item['price'], 0, '.', '.') }}đ
                                                </p>
                                                <p class="text-nowrap p_value_reduced hidden"
                                                    style="font-size: 13px;">-<span
                                                        class="value_reduced text-success">{{ number_format($item['price'], 0, '.', '.') }}đ</span>
                                                </p>
                                            </div>
                                            <span
                                                class="position-absolute top-0 end-0 rounded-start ps-1 pe-1 text-white"
                                                style="background-color:#cca270">x{{ $item['quantity'] }}</span>
                                        </li>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </ul>
                            <div class="summary-total">
                                <ul>
                                    <span class="mb-2 d-block">Phí cơ bản</span>
                                    <li class="li_sub_total">
                                        <p>Tổng cộng</p>
                                        <div class="d-flex flex-column align-items-end">
                                            <span
                                                id="sub_total">{{ number_format($check_out_data['sub_total'], 0, '.', '.') }}đ</span>
                                            <span class="hidden text-danger fw-bold"
                                                id="new_sub_total">{{ number_format($check_out_data['sub_total'], 0, '.', '.') }}đ</span>
                                        </div>
                                        <input id="base_sub_total" type="hidden"
                                            value="{{ $check_out_data['sub_total'] }}">
                                    </li>
                                    <li>
                                        <p>Phí vận chuyển</p>
                                        <span>{{ number_format($check_out_data['shipping_fee'], 0, '.', '.') }}đ</span>
                                        <input type="hidden" id="shipping_price"
                                            value="{{ $check_out_data['shipping_fee'] }}">
                                    </li>
                                    <li>
                                        <p>Thuế <span class="color-of-theme" style="font-size:10px;">(0,5% tổng giá trị
                                                đơn hàng)</span></p>
                                        <span>{{ number_format($check_out_data['tax'], 0, '.', '.') }}đ</span>
                                        <input id="base_tax" type="hidden" value="{{ $check_out_data['tax'] }}">
                                    </li>

                                    <span
                                        class="mt-2 mb-2 d-block {{ $check_out_data['free_ship'] != 'true' ? 'hidden' : '' }}"
                                        id="titleAppliedDiscounts">Giảm giá áp dụng</span>

                                    <li id="liShippingVoucher"
                                        class="{{ $check_out_data['free_ship'] != 'true' ? 'hidden' : '' }}">
                                        <p>Giảm giá vận chuyển</p>
                                        <input type="hidden" id="free_ship_status"
                                            value="{{ $check_out_data['free_ship'] }}">
                                        <span class="color-of-theme">
                                            -
                                            <span class="color-of-theme"
                                                id="shipping_voucher">{{ number_format($check_out_data['minimum_payment_for_free_ship'] > $check_out_data['sub_total'] ? 0 : $check_out_data['shipping_fee'], 0, '.', '.') }}đ</span>
                                        </span>
                                    </li>
                                    <li id="liVoucher" class="hidden">
                                        <p>Giảm giá</p>
                                        <span class="color-of-theme">
                                            -
                                            <span class="color-of-theme"
                                                id="voucher">{{ number_format($check_out_data['shipping_fee'], 0, '.', '.') }}đ</span>
                                        </span>
                                    </li>

                                </ul>
                                <div class="coupon-code">
                                    <div class="position-relative divInputVoucher">
                                        <input type="text" placeholder="Nhập mã giảm giá" id="inputApplyVoucher">
                                        <div class="position-absolute w-100 h-100 bg-dark-subtle top-0 d-flex flex-row justify-content-between align-items-center hidden"
                                            id="showVoucher">
                                            <label class="ms-3 m-0" id="voucherCode">giam100k</label>
                                            <span class="me-3">
                                                <i class="fas fa-xmark cspt fa-2xl color-of-theme"
                                                    id="cancelVoucher"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <button class="btn" id="btnApplyVoucher">Apply</button>
                                </div>
                                @if (isset($check_out_data['product_variant_data']) && $check_out_data['product_variant_data'])
                                @if ($check_out_data['free_ship'] != true)
                                <div>
                                    <p style="font-size: 12px;" class="text-danger">
                                        <i class="fa-solid fa-circle-exclamation color-of-theme"></i>
                                        Mua thêm
                                        {{ number_format($check_out_data['minimum_payment_for_free_ship'] - $check_out_data['sub_total'], '0', '.', ',') }}đ
                                        để nhận ngay <b>Ưu đãi miễn phí vận chuyển.</b>!
                                    </p>
                                </div>
                                @else
                                <div>
                                    <p style="font-size: 12px;" class="text-success">
                                        <i class="fa-solid fa-circle-exclamation color-of-theme"></i>
                                        Bạn đã nhận được <b>Ưu đãi miễn phí vận chuyển</b> với đơn hàng trị giá
                                        trên
                                        {{ number_format($check_out_data['minimum_payment_for_free_ship'], '0', '.', ',') }}đ!
                                    </p>
                                </div>
                                @endif
                                @else
                                <div>
                                    <p style="font-size: 12px;" class="text-danger">
                                        <i class="fa-solid fa-circle-exclamation color-of-theme"></i>
                                        Vui lòng quay lại trang chủ để mua sản phẩm!
                                    </p>
                                </div>
                                @endif
                            </div>
                            <div class="total">
                                <h6>Tổng cộng:</h6>
                                <input type="hidden" id="inputPaymentTotal" value="{{ $check_out_data['total'] }}">
                                <div class="total m-0 mb-3 d-flex flex-column align-items-end">
                                    <h6 class="" id="paymentTotal">
                                        {{ number_format($check_out_data['total'], 0, '.', '.') }}đ
                                    </h6>
                                    <h6 class="text-danger fw-bold hidden" id="newPaymentTotal">
                                        {{ number_format($check_out_data['total'], 0, '.', '.') }}đ
                                    </h6>
                                </div>
                            </div>
                            <div class="order-button">
                                <a class="btn btn_black sm w-100 rounded" href="javascript:void(0)"
                                    id="place_order">Đặt Hàng</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Form create new address  -->
    <div class="modal theme-modal fade address-modal" id="create-address-modal" tabindex="-1" role="dialog"
        aria-modal="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Thêm địa chỉ</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <form id="add-address-form" class="row g-3" action="{{ route('checkout.addAddress') }}"
                        method="POST">
                        @csrf
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Họ tên</label>
                                <input class="form-control @error('full_name') is-invalid @enderror" type="text"
                                    name="full_name" placeholder="Enter your name." value="{{ old('full_name') }}">
                                @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Số điện thoại</label>
                                <input class="form-control @error('phone_number') is-invalid @enderror" type="number"
                                    name="phone_number" placeholder="Enter your Number."
                                    value="{{ old('phone_number') }}">
                                @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Địa chỉ</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" cols="30" rows="2"
                                    placeholder="Write your Address..." name="address">{{ old('address') }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-success" type="submit">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Form edit address  -->
    <div class="modal theme-modal fade address-modal" id="edit-address-modal" tabindex="-1" role="dialog"
        aria-modal="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Chỉnh sửa địa chỉ</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <form id="edit-address-form" class="row g-3" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Họ tên</label>
                                <input class="form-control @error('full_name') is-invalid @enderror" type="text"
                                    name="full_name" placeholder="Enter your name." value="{{ old('full_name') }}">
                                @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Số điện thoại</label>
                                <input class="form-control @error('phone_number') is-invalid @enderror" type="number"
                                    name="phone_number" placeholder="Enter your Number."
                                    value="{{ old('phone_number') }}">
                                @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Địa chỉ</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" cols="30" rows="2"
                                    placeholder="Write your Address..." name="address" value="{{ old('address') }}"></textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-success" type="submit">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Form edit default address  -->
    <div class="modal theme-modal fade address-modal" id="edit-default-address-modal" tabindex="-1" role="dialog"
        aria-modal="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Chỉnh sửa địa chỉ</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <form id="edit-default-address-form" class="row g-3" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Họ tên</label>
                                <input class="form-control @error('full_name') is-invalid @enderror" type="text"
                                    name="full_name" placeholder="Enter your name." value="{{ old('full_name') }}">
                                @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Số điện thoại</label>
                                <input class="form-control @error('phone') is-invalid @enderror" type="number"
                                    name="phone" placeholder="Enter your Number." value="{{ old('phone') }}">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Địa chỉ</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" cols="30" rows="2"
                                    placeholder="Write your Address..." name="address" value="{{ old('address') }}"></textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-success" type="submit">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal delete address --}}
    <div class="modal theme-modal fade confirmation-modal" id="delete-address-modal" tabindex="-1" role="dialog"
        aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body"> <img class="img-fluid" src="../assets/images/gif/question.gif"
                        alt="">
                    <h4>Bạn có chắc không?</h4>
                    <p>Địa chỉ sẽ bị xóa vĩnh viễn. Bạn có chắc chắn muốn làm điều này không?</p>
                    <div class="submit-button">
                        <button class="btn" type="submit" data-bs-dismiss="modal" aria-label="Close">Không</button>
                        <form id="delete-address-form" action="" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn" type="submit" data-bs-dismiss="modal"
                                aria-label="Close">Có</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    {{-- End modal --}}
</main>
<!-- End container content -->
<div class="container-spinner position-fixed d-flex justify-content-center align-items-center w-100 h-100 hidden">
    <div class="overlay"></div>
    <div class="spinner-border text-of-theme" id="loadingSpinner" role="status">
    </div>
</div>
@endsection