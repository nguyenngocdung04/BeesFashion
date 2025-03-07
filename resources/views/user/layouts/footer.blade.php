    <!-- Footer -->
    <footer class="footer-layout-img">
        <section class="section-b-space footer-1">
            <div class="custom-container container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="footer-content">
                            <div class="footer-logo"><a href="{{ route('/') }}"> <img class="img-fluid"
                                        src="{{ asset('assets/images/logo/logo-Bee-white.png') }}" alt="Footer Logo"></a>
                            </div>
                            <ul>
                                <li>
                                    <i class="iconsax" data-icon="location"></i>
                                    <h6>Tòa nhà FPT Polytechnic, 13 Trịnh Văn Bô, Xuân Phương, Nam Từ Liêm, Hà Nội</h6>
                                </li>
                                <li>
                                    <i class="iconsax" data-icon="phone-calling"></i>
                                    <h6>+ 8497889999</h6>
                                </li>
                                <li>
                                    <i class="iconsax" data-icon="mail"></i>
                                    <h6>contact@beesfashion.com</h6>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col">
                        <div class="footer-content">
                            <div>
                                <div class="footer-title d-md-block">
                                    <h5>Về BeesFahion</h5>
                                    <ul class="footer-details accordion-hidden">
                                        <li> <a class="nav" href="{{ route('/') }}">Chúng tôi là ai</a></li>
                                        <li> <a class="nav" href="#">Cam kết của chúng tôi</a></li>
                                        <li> <a class="nav" href="#">Tin tuyển dụng</a></li>
                                        <li> <a class="nav" href="#">Cửa hàng</a></li>
                                        <li> <a class="nav" href="#">Liên hệ</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="footer-content">
                            <div>
                                <div class="footer-title d-md-block">
                                    <h5>Hỗ trợ khách hàng</h5>
                                    <ul class="footer-details accordion-hidden">
                                        <li> <a class="nav" href="#">Hướng dẫn đặt hàng</a></li>
                                        <li> <a class="nav" href="#">Phương thức thanh toán</a></li>
                                        <li> <a class="nav" href="#">Chính sách thành viên</a></li>
                                        <li> <a class="nav" href="#">Chính sách tích - tiêu điểm</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="footer-content">
                            <div>
                                <div class="footer-title d-md-block">
                                    <h5>Chính sách</h5>
                                    <ul class="footer-details accordion-hidden">
                                        <li> <a class="nav" href="#">Chính sách vận chuyển</a></li>
                                        <li> <a class="nav" href="#">Chính sách kiểm hàng</a></li>
                                        <li> <a class="nav" href="#">Chính sách đổi trả</a></li>
                                        <li> <a class="nav" href="#">Điều kiện & Điều khoản</a></li>
                                        <li> <a class="nav" href="#">Chính sách bảo mật</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="footer-content">
                            <div>
                                <div class="footer-title d-md-block">
                                    <h5>Liên hệ</h5>
                                    <ul class="footer-details accordion-hidden">
                                        <li> <a class="nav" href="#">Tư vấn mua online: 012 3456 7899</a></li>
                                        <li> <a class="nav" href="#">Khiếu nại và bảo hành: 012 3456 7899</a></li>
                                        <li> <a class="nav" href="#">Email: cskh@beesfashion.vn</a></li>
                                        <li> <a class="nav" href="#">Giờ làm việc: 24/7</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="sub-footer">
            <div class="custom-container container">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="footer-end">
                            <h6>Copyright © 2024 Beesfashion.vn All Rights Reserved. </h6>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="payment-card-bottom">
                            <ul>
                                <li> <img src="{{ asset('assets/images/footer/discover.png') }}" alt="">
                                </li>
                                <li> <img src="{{ asset('assets/images/footer/american.png') }}" alt="">
                                </li>
                                <li> <img src="{{ asset('assets/images/footer/master.png') }}" alt=""></li>
                                <li> <img src="{{ asset('assets/images/footer/giro.png') }}" alt=""></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End footer -->

    {{-- Modal logout --}}
    <div class="modal theme-modal fade confirmation-modal" id="modal-logout" tabindex="-1" role="dialog"
        aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body"> <img class="img-fluid" src="{{ asset('assets/images/gif/question.gif') }}"
                        alt="">
                    <h4>Xác nhận</h4>
                    <p>Bạn có chắc muốn đăng xuất không?</p>
                    <div class="submit-button"> <button class="btn" type="submit" data-bs-dismiss="modal"
                            aria-label="Close">Không</button><a class="btn" href="{{ route('logout') }}">Có</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End logout --}}

    <!-- Modal cart right -->
    {{-- <div class="offcanvas offcanvas-end shopping-details" id="offcanvasRight" tabindex="-1"
        aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h4 class="offcanvas-title" id="offcanvasRightLabel">Shopping Cart</h4>
            <button class="btn-close" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body theme-scrollbar">
            <ul class="offcanvas-cart">
                <li>
                    <a href="#"> <img src="{{ asset('assets/images/cart/1.jpg') }}" alt=""></a>
                    <div>
                        <h6 class="mb-0">Shirts Men's Clothing</h6>
                        <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                    id="total">105</span></span></p>
                        <div class="btn-containter">
                            <div class="btn-control">
                                <button class="btn-control__remove" id="btn-remove">&minus;</button>
                                <div class="btn-control__quantity">
                                    <div id="quantity-previous">2</div>
                                    <div id="quantity-current">3</div>
                                    <div id="quantity-next">4</div>
                                </div>
                                <button class="btn-control__add" id="btn-add">+</button>
                            </div>
                        </div>
                    </div>
                    <i class="iconsax delete-icon" data-icon="trash"></i>
                </li>
                <li>
                    <a href="#"> <img src="{{ asset('assets/images/cart/2.jpg') }}" alt=""></a>
                    <div>
                        <h6 class="mb-0">Shirts Men's Clothing</h6>
                        <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                    id="total1">105</span></span></p>
                        <div class="btn-containter">
                            <div class="btn-control">
                                <button class="btn-control__remove" id="btn-remove1">&minus;</button>
                                <div class="btn-control__quantity">
                                    <div id="quantity1-previous">2</div>
                                    <div id="quantity1-current">3</div>
                                    <div id="quantity1-next">4</div>
                                </div>
                                <button class="btn-control__add" id="btn-add1">+</button>
                            </div>
                        </div>
                    </div>
                    <i class="iconsax delete-icon" data-icon="trash"></i>
                </li>
                <li>
                    <a href="#"> <img src="{{ asset('assets/images/cart/3.jpg') }}" alt=""></a>
                    <div>
                        <h6 class="mb-0">Shirts Men's Clothing</h6>
                        <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                    id="total2">105</span></span></p>
                        <div class="btn-containter">
                            <div class="btn-control">
                                <button class="btn-control__remove" id="btn-remove2">&minus;</button>
                                <div class="btn-control__quantity">
                                    <div id="quantity2-previous">2</div>
                                    <div id="quantity2-current">3</div>
                                    <div id="quantity2-next">4</div>
                                </div>
                                <button class="btn-control__add" id="btn-add2">+</button>
                            </div>
                        </div>
                    </div>
                    <i class="iconsax delete-icon" data-icon="trash"></i>
                </li>
                <li>
                    <a href="#"> <img src="{{ asset('assets/images/cart/4.jpg') }}" alt=""></a>
                    <div>
                        <h6 class="mb-0">Shirts Men's Clothing</h6>
                        <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                    id="total3">105</span></span></p>
                        <div class="btn-containter">
                            <div class="btn-control">
                                <button class="btn-control__remove" id="btn-remove3">&minus;</button>
                                <div class="btn-control__quantity">
                                    <div id="quantity3-previous">2</div>
                                    <div id="quantity3-current">3</div>
                                    <div id="quantity3-next">4</div>
                                </div>
                                <button class="btn-control__add" id="btn-add3">+</button>
                            </div>
                        </div>
                    </div>
                    <i class="iconsax delete-icon" data-icon="trash"></i>
                </li>
            </ul>
        </div>
        <div class="offcanvas-footer">
            <p>Spend <span>$ 14.81 </span>more and enjoy <span>FREE SHIPPING!</span></p>
            <div class="footer-range-slider">
                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="46"
                    aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-striped progress-bar-animated theme-default"
                        style="width: 46%"></div>
                </div>
            </div>
            <div class="price-box">
                <h6>Total :</h6>
                <p>$ 49.59 USD</p>
            </div>
            <div class="cart-button"> <a class="btn btn_outline" href="cart.html"> View Cart</a><a
                    class="btn btn_black" href="check-out.html"> Checkout</a></div>
        </div>
    </div> --}}
    <!-- End modal cart right -->


    <!-- End modal add cart -->

    <!-- Modal Seach -->
    <div class="offcanvas offcanvas-top search-details" id="offcanvasTop" tabindex="-1"
        aria-labelledby="offcanvasTopLabel">
        <div class="offcanvas-header"><button class="btn-close" type="button" data-bs-dismiss="offcanvas"
                aria-label="Close"><i class="fa-solid fa-xmark"></i></button></div>
        <div class="offcanvas-body theme-scrollbar">
            <div class="container">
                <h3>Bạn đang muốn tìm kiếm gì!!</h3>
                <div class="search-box">
                    <input type="search" id="search-input-of-header" name="text"
                        placeholder="Tìm kiếm sản phẩm...">
                    <i class="iconsax" data-icon="search-normal-2" id="search-icon"></i>
                </div>

                <h4>Có thể bạn sẽ thích</h4>
                <div class="row gy-4 ratio_square-2 preemptive-search">
                    @foreach ($search as $product)
                        <div class="col-xl-2 col-sm-4 col-6">
                            <div class="product-box-6">
                                <div class="img-wrapper">
                                    <div class="product-image"><a href="{{ route('product.detail', $product->SKU) }}">
                                            <img class="bg-img"
                                                src="{{ asset('uploads/products/images/' . $product->active_image) }}"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div>
                                        <a href="{{ route('product.detail', $product->SKU) }}">
                                            <h6>{{ \Illuminate\Support\Str::limit($product->name, 40) }}</h6>
                                        </a>
                                        <p>{{ $product->priceRange }}</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- End seach -->
    <script>
        // Lắng nghe sự kiện nhấn Enter trên ô input tìm kiếm
        document.getElementById('search-input-of-header').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });

        // Lắng nghe sự kiện click vào biểu tượng tìm kiếm
        document.getElementById('search-icon').addEventListener('click', function() {
            performSearch();
        });

        // Hàm thực hiện tìm kiếm và chuyển hướng tới trang sản phẩm
        function performSearch() {
            const searchValue = document.getElementById('search-input-of-header').value.trim(); // Lấy giá trị từ ô input
            console.log(searchValue);

            if (searchValue) {
                var current_url = new URL(window.location.href);
                var search_param = current_url.searchParams.has('search');
                if (search_param) {
                    current_url.searchParams.delete('search');
                    window.history.replaceState({}, '', current_url);
                }


                // Chuyển hướng đến trang product và thêm query string 'name' với từ khóa tìm kiếm
                window.location.href = '/product?search=' + encodeURIComponent(searchValue);
            }
        }
    </script>
