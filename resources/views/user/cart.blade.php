@extends('user.layouts.master')
@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/user/cart.js') }}"></script>
@endsection



@section('content')
    <!-- Container content -->
    <style>
        #variantBox {
            display: none;
            /* Ẩn mặc định */
            position: absolute;
            z-index: 1000;
            background-color: white;
            border: 1px solid #ccc;
            padding: 20px;
            /* Tăng khoảng cách trong hộp */
            width: 400px;
            /* Điều chỉnh chiều rộng của hộp */
            max-width: 80%;
            /* Đảm bảo hộp không vượt quá chiều rộng màn hình */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow-y: auto;
            /* Thêm thanh cuộn dọc nếu nội dung quá dài */
        }

        #variantBox.active {
            display: block;
            /* Hiển thị khi có lớp active */
        }

        /* Căn chỉnh các thuộc tính sát bên trái */
        .attribute h6 {
            margin: 0;
            /* Loại bỏ margin mặc định */
            padding-left: 0;
            /* Đảm bảo không có padding trái */
            font-size: 16px;
            /* Tăng kích thước chữ nếu cần */
            font-weight: bold;
            /* Làm đậm chữ */
            text-align: left;
            /* Căn chỉnh chữ về bên trái */
        }

        /* Căn chỉnh các giá trị thuộc tính */
        .attribute-values {
            list-style: none;
            /* Loại bỏ dấu chấm */
            padding-left: 0;
            /* Xóa padding mặc định */
            display: flex;
            flex-wrap: wrap;
            /* Cho phép các giá trị thuộc tính xuống dòng nếu không đủ chỗ */
            gap: 10px;
            /* Khoảng cách giữa các giá trị thuộc tính */
        }

        .attribute-values li {
            margin-bottom: 10px;
            /* Khoảng cách giữa các giá trị thuộc tính */
        }

        .attribute-values button {
            padding: 8px 15px;
            font-size: 14px;
            cursor: pointer;
            border: 1px solid #ccc;
            background-color: #f5f5f5;
            border-radius: 5px;
        }

        .attribute-values button:hover {
            background-color: #e0e0e0;
        }

        /* Căn chỉnh các nút xác nhận và trở lại */
        #variantBox .buttons-container {
            display: flex;
            justify-content: flex-end;
            /* Căn chỉnh các nút về phía bên phải */
            gap: 10px;
            /* Khoảng cách giữa các nút */
            margin-top: 15px;
            /* Khoảng cách từ nội dung đến các nút */
        }

        #variantBox .buttons-container button {
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        #variantBox .buttons-container .back-button {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
        }

        #variantBox .buttons-container .confirm-button {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .attribute_item.selected {
            position: relative;
            border: 3px solid #ff0000;
            transform: scale(1.3);
            background-color: rgba(255, 0, 0, 0.1);
        }

        .attribute_item.selected::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            border: 2px solid #ffffff;
        }

        .attribute_item.able.selected {
            border: 3px solid #ff0000;
        }

        .btn-variant.selected {
            background-color: #ffcccc;
            color: #ff0000;
            border: 2px solid #ff0000;
            position: relative;
            transform: scale(1.05);
        }

        .attribute_item:hover {
            cursor: pointer;
            opacity: 0.8;
        }

        .attribute_item,
        .btn-variant {
            transition: all 0.3s ease;
        }


        .attribute_item:hover {
            opacity: 1;
        }

        .attribute_item.disabled {
            opacity: 0.5;
            pointer-events: none;
        }

        .btn-variant.disabled {
            opacity: 0.5;
            pointer-events: none;
        }

        .attribute_item.disabled:hover {
            cursor: not-allowed;
        }

        .disabled {
            pointer-events: none;
            opacity: 0.5;
        }
    </style>
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>Giỏ hàng</h4>
                        </div>
                        {{-- <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">Cart</a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0">
            <div class="custom-container container">
                <div class="row g-4">
                    @if (count($cart_list) > 0)
                        {{-- <div class="col-12">
                            <div class="cart-countdown"><img src="../assets/images/gif/fire-2.gif" alt="">
                                <h6>Please, hurry! Someone has placed an order on one of the items you have in the cart.
                                    We'll keep it for you for<span id="countdown"></span>minutes.</h6>
                            </div>
                        </div> --}}
                        <div class="col-xxl-9 col-xl-8">
                            <div class="cart-table">
                                <div class="table-title">
                                    <h5>Giỏ hàng <span id="cartTitle">({{ count($cart_list) }} Sản phẩm)</span></h5>
                                    <form action="{{ route('cart.clearAll') }}" method="POST" id="clearAllForm">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-clear" id="clearAllButton">Xóa tất cả</button>
                                    </form>

                                </div>
                                <div class="table-responsive theme-scrollbar">
                                    <table class="table" id="cart-table">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selectAllCheckbox"></th>
                                                <th>Sản phẩm </th>
                                                <th>Giá </th>
                                                <th>Số lượng</th>
                                                <th>Tổng tiền</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart_list as $item_cart)
                                                <tr data-cart-id="{{ $item_cart['id_cart'] }}"
                                                    data-variant-id="{{ $item_cart['variant_id'] }}"
                                                    data-product-id="{{ $item_cart['product_id'] }}"
                                                    data-regular-price="{{ $item_cart['regular_price'] }}"
                                                    data-sale-price="{{ $item_cart['sale_price'] }}"
                                                    data-stock="{{ $item_cart['stock'] }}" class="cart_item">
                                                    <td>
                                                        <input type="checkbox" class="product_checkbox"
                                                            data-cart-id="{{ $item_cart['id_cart'] }}">
                                                    </td>
                                                    <td>
                                                        <div class="cart-box">
                                                            <a href="{{ route('product.detail', $item_cart['sku']) }}">
                                                                <img src="{{ asset('uploads/products/images/' . $item_cart['image']) }}"
                                                                    alt="{{ $item_cart['product_name'] }}"
                                                                    class="product-image text-start"></a>
                                                            <div class="cart-box-variant">
                                                                <a href="{{ route('product.detail', $item_cart['sku']) }}">
                                                                    <h5 class="text-wrap text-start">{{ $item_cart['product_name'] }}
                                                                    </h5>
                                                                </a>

                                                                <div class="box-edit-variant mb-2 variant-selector">
                                                                    <button type="button" id="variantButton"
                                                                        class="variant-button text-start">
                                                                        Chọn phân loại <span class="ms-lg-5"><i
                                                                                class="fa-solid fa-chevron-down"></i></span>
                                                                    </button>

                                                                    <div id="variantBox" class="variant-box" data-product-id="" data-variant-id="">
                                                                        <div id="attributes-container"></div>
                                                                        <div class="buttons-container">
                                                                            <button type="button" class="back-button"
                                                                                id="backButton">Trở lại</button>
                                                                            <button type="button" class="confirm-button"
                                                                                id="confirmButton">Xác nhận</button>
                                                                        </div>
                                                                    </div>
                                                                </div>



                                                                <div
                                                                    class="variant-details d-flex align-items-start flex-column">
                                                                    @foreach ($item_cart['attribute_values'] as $attribute)
                                                                        <h6 class="attribute-item">
                                                                            {{ $attribute['attribute_name'] }}:
                                                                            <span
                                                                                class="attribute-value">{{ $attribute['value_name'] }}</span>
                                                                        </h6>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p
                                                            style="color: rgba(var(--theme-font-color), 1); font-size: calc(13.4px + .1875vw); font-weight: 500;">
                                                            {{ number_format($item_cart['sale_price'] ?? $item_cart['regular_price'], 0, ',', '.') }}đ
                                                            @if ($item_cart['sale_price'])
                                                                <del class="ms-2"
                                                                    style="color:rgba(var(--light-color), 1); font-weight: normal">
                                                                    {{ number_format($item_cart['regular_price'], 0, ',', '.') }}đ
                                                                </del>
                                                            @endif
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <div class="quantity">
                                                            <button class="quantity_btn_minus " type="button"><i
                                                                    class="fa-solid fa-minus"></i></button>
                                                            <input class="quantity-input" type="number"
                                                                value="{{ $item_cart['quantity'] }}" min="1"
                                                                max="{{ $item_cart['stock'] }}"
                                                                data-price="{{ $item_cart['sale_price'] ?? $item_cart['regular_price'] }}"
                                                                data-stock="{{ $item_cart['stock'] }}">
                                                            <button class="quantity_btn_plus " type="button"><i
                                                                    class="fa-solid fa-plus"></i></button>
                                                        </div>
                                                    </td>
                                                    <td class="total-price"
                                                        data-price="{{ $item_cart['sale_price'] ?? $item_cart['regular_price'] }}">
                                                        {{ number_format(($item_cart['sale_price'] ?? $item_cart['regular_price']) * $item_cart['quantity'], 0, ',', '.') }}đ
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('cart.remove', $item_cart['id_cart']) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class=" deleteButton"
                                                                style="border: none;background: transparent; color: rgba(var(--danger-color), 1);">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="no-data" id="data-show"><img src="../assets/images/cart/1.gif" alt="">
                                    <h4>You have nothing in your shopping cart!</h4>
                                    <p>Today is a great day to purchase the things you have been holding onto! or
                                        <span>Carry on
                                            Buying</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-4">
                            <div class="cart-items">
                                <div class="cart-progress">
                                    <h6>Chi tiết giá <span>(0 Sản phẩm)</span></h6>
                                </div>
                                <div class="cart-body">
                                    <ul>
                                        <li>
                                            <p>Tổng tiền hàng</p>
                                            <span id="total-payment" class="total-payment"></span>
                                        </li>
                                        <li>
                                            <p>Giảm giá sản phẩm</p>
                                            <span id="total-discount" class="total-discount"></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="cart-bottom mb-2">
                                    <h6>Tổng số tiền
                                        <span id="total-price"></span> <!-- Hiển thị tổng sau khi giảm giá -->
                                    </h6>
                                    <p>Sử dụng <span>BeesFashion's</span> mã giảm giá ở bước tiếp theo</p>
                                </div>
                                <form id="form_post_data_to_check_out" action="{{ route('checkout') }}" method="POST">
                                    @csrf
                                    @method('GET')
                                    <input type="hidden" name="cart_ids" id="input_post_data_to_check_out">
                                    <input type="hidden" name="status_cart" id="is_cart">
                                </form>
                                <a class="btn btn_black w-100 rounded sm" id="check_out">Thanh toán</a>

                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <h5 class="text-center">Giỏ hàng của bạn đang trống!</h5>
                            <div>
                                <img class="img-fluid" src="{{ asset('assets/images/user/empty-cart.jpg') }}"
                                    width="190">
                            </div>
                            <div class="text-center mt-3">
                                <a href="{{ route('/') }}" class="btn btn_black rounded sm">Tiếp tục mua sắm</a>
                            </div>
                        </div>
                    @endif

                    {{-- <div class="col-12">
                        <div class="cart-slider">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <h6>For a trendy and modern twist, especially during transitional seasons.</h6>
                                    <p> <img class="me-2" src="../assets/images/gif/discount.gif" alt="">You
                                        will get
                                        10%
                                        OFF on each product</p>
                                </div><a class="btn btn_outline sm rounded" href="product-detail.html">View All<svg>
                                    </svg></a>
                            </div>
                            <div class="swiper cart-slider-box">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                         <div class="cart-box"> <a href="product-detail.html"> <img
                                                    src="../assets/images/user/4.jpg" alt=""></a> 
                                        <div> <a href="product-detail.html">
                                                <h5>Polo-neck Body Dress</h5>
                                            </a>
                                            <h6>Sold By: <span>Brown Shop</span></h6>
                                            <div class="category-dropdown"><select class="form-select" name="carlist">
                                                    <option value="">Best color</option>
                                                    <option value="">White</option>
                                                    <option value="">Black</option>
                                                    <option value="">Green</option>
                                                </select></div>
                                            <p>$19.90 <span> <del>$14.90 </del></span></p><a class="btn"
                                                href="#">Add</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                     <div class="cart-box"> <a href="product-detail.html"> <img
                                                    src="../assets/images/user/5.jpg" alt=""></a> 
                                    <div> <a href="product-detail.html">
                                            <h5>Short Sleeve Sweater</h5>
                                        </a>
                                        <h6>Sold By: <span>Brown Shop</span></h6>
                                        <div class="category-dropdown"><select class="form-select" name="carlist">
                                                <option value="">Best color</option>
                                                <option value="">White</option>
                                                <option value="">Black</option>
                                                <option value="">Green</option>
                                            </select></div>
                                        <p>$22.90 <span> <del>$24.90 </del></span></p><a class="btn"
                                            href="#">Add</a>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="cart-box"> <a href="product-detail.html"> <img
                                                    src="../assets/images/user/6.jpg" alt=""></a>
                                <div> <a href="product-detail.html">
                                        <h5>Oversized Cotton Short</h5>
                                    </a>
                                    <h6>Sold By: <span>Brown Shop</span></h6>
                                    <div class="category-dropdown"><select class="form-select" name="carlist">
                                            <option value="">Best color</option>
                                            <option value="">White</option>
                                            <option value="">Black</option>
                                            <option value="">Green</option>
                                        </select></div>
                                    <p>$10.90 <span> <del>$18.90 </del></span></p><a class="btn" href="#">Add</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                                        <div class="cart-box"> <a href="product-detail.html"> <img
                                                    src="../assets/images/user/7.jpg" alt=""></a>
                        <div> <a href="product-detail.html">
                                <h5>Oversized Women Shirt</h5>
                            </a>
                            <h6>Sold By: <span>Brown Shop</span></h6>
                            <div class="category-dropdown"><select class="form-select" name="carlist">
                                    <option value="">Best color</option>
                                    <option value="">White</option>
                                    <option value="">Black</option>
                                    <option value="">Green</option>
                                </select></div>
                            <p>$15.90 <span> <del>$20.90 </del></span></p><a class="btn" href="#">Add</a>
                        </div>
                    </div> --}}
                </div>
            </div>

            <!-- Box Chọn Biến Thể -->
            {{-- <div id="variantBox" class="box-variant">
                <div class="variant-container">
                    <div class="variant-content">
                        <!-- Kiểm tra xem có thuộc tính cho sản phẩm hay không -->
                        @if (count($item_cart['attribute_values']) > 0)
                            @foreach ($item_cart['attribute_values'] as $attribute)
                                <div class="attribute-item">
                                    <label class="form-label">{{ $attribute['attribute_name'] }}:</label>
                                    <span class="attribute-value">{{ $attribute['value_name'] }}</span>
                                    
                                    <!-- Nếu là màu sắc, có thể hiển thị màu bằng mã màu -->
                                    @if ($attribute['attribute_name'] == 'color' && $attribute['value_code'])
                                        <div class="color-display" style="background-color: {{ $attribute['value_code'] }}; width: 20px; height: 20px; border-radius: 50%;"></div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="attribute-item">
                                <label class="form-label">Không có thuộc tính cho sản phẩm này.</label>
                            </div>
                        @endif
            
                        <!-- Các lựa chọn màu sắc nếu có -->
                        <label class="form-label">Color:</label>
                        <div class="d-flex mb-2 color-options">
                            @foreach ($item_cart['attribute_values'] as $attribute)
                                @if ($attribute['attribute_name'] == 'color')
                                    <input class="btn-color" type="radio" id="color-{{ $attribute['value_name'] }}" name="color" value="{{ $attribute['value_name'] }}">
                                    <label for="color-{{ $attribute['value_name'] }}" title="{{ $attribute['value_name'] }}" class="color-label me-2"
                                        style="background-color: {{ $attribute['value_code'] }};"></label>
                                @endif
                            @endforeach
                        </div>
            
                        <!-- Các lựa chọn size nếu có -->
                        <label class="form-label">Size:</label>
                        <div class="d-flex flex-wrap mb-2 wrap-vra">
                            @foreach ($item_cart['attribute_values'] as $attribute)
                                @if ($attribute['attribute_name'] == 'Kích cỡ')
                                    <button class="btn-variant">{{ $attribute['value_name'] }}</button>
                                @endif
                            @endforeach
                        </div>
            
                        <!-- Các lựa chọn chất liệu nếu có -->
                        <label class="form-label">Vải:</label>
                        <div class="d-flex flex-wrap mb-2 wrap-vra">
                            @foreach ($item_cart['attribute_values'] as $attribute)
                                @if ($attribute['attribute_name'] == 'Vải')
                                    <button class="btn-variant-default">{{ $attribute['value_name'] }}</button>
                                @endif
                            @endforeach
                        </div>
            
                    </div>
                    <div class="d-flex mt-3 justify-content-between box-variant-bottom">
                        <button type="button" id="backButton" class="btn-back">Trở lại</button>
                        <button type="submit" class="btn-confirm">Xác nhận</button>
                    </div>
                </div>
            </div> --}}



            {{-- <div id="variantBox" class="box-variant">
                <div class="variant-container">
                    <div class="variant-content">
                        <!-- Sẽ được điền động từ AJAX -->
                        <div id="productAttributes"></div>
                    </div>

                    <div class="d-flex mt-3 justify-content-between box-variant-bottom">
                        <button type="button" id="backButton" class="btn-back">Trở lại</button>
                        <button type="submit" class="btn-confirm">Xác nhận</button>
                    </div>
                </div>
            </div>

            <!-- Nút để tải biến thể -->
            <button id="loadVariantsButton">Load Variants</button>

            <!-- Container để hiển thị các biến thể -->
            <div id="variantsContainer"></div>

            <!-- Container để hiển thị các thuộc tính -->
            <div id="attributesContainer"></div> --}}


        </section>
    </main>

    <!-- End container content -->
@endsection
