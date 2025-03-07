@extends('user.layouts.master')

@section('content')
    <!--Container Content -->
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h5>{{ $product->name }}</h5>
                        </div>
                        {{-- <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">Product Detail</a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space product-thumbnail-page pt-0 mb-4">
            <div class="custom-container container">
                <div class="row gy-4">
                    {{-- box-left --}}
                    <div class="col-lg-6">
                        <div class="row sticky">
                            <div class="col-sm-2 col-3">
                                <div class="swiper product-slider product-slider-img">
                                    <div class="swiper-wrapper">
                                        @foreach ($product->product_files as $image)
                                            <div class="swiper-slide"><img src="{{ asset('uploads/products/images/' . $image->file_name) }}" alt=""></div>
                                        @endforeach
                                        {{-- <div class="swiper-slide"> <img src="../assets/images/product/slider/4.jpg"
                                                alt=""><span> <i class="iconsax" data-icon="play"></i></span></div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10 col-9">
                                <div class="swiper product-slider-thumb product-slider-img-1">
                                    <div class="swiper-wrapper ratio_square-2">
                                        @foreach ($product->product_files as $image)
                                            <div class="swiper-slide"><img class="bg-img" src="{{ asset('uploads/products/images/' . $image->file_name) }}" alt=""></div>
                                        @endforeach
                                        {{-- <div class="swiper-slide"> <video class="video-tag" loop="" autoplay="" muted="">
                                                <source
                                                    src="https://themes.pixelstrap.net/katie/assets/images/product/slider/clothing.mp4"
                                                    type="video/mp4"> Your browser does not support the video tag.
                                            </video></div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- box-right --}}
                    <div class="col-lg-6">
                        <div class="product-detail-box">
                            <div class="product-option">
                                <div class="move-fast-box d-flex align-items-center gap-1"><img src="{{ asset('assets/images/gif/fire.gif') }}" alt="">
                                    <p>Move fast!</p>
                                </div>
                                <h1 class="css-w60u47">{{ $product->name }}</h1>
                                <div class="product-sku mt-1">SKU: {{ $product->SKU }}</div>
                                <div class="box-price-top d-flex align-items-center gap-2">
                                    <div id="price">{{ $product->priceRange }}</div>
                                    <div id="regular" class="currency">{{ $product->regularPrice }}</div>
                                    <div id="discount" class="offer-btn">{{ $product->discountPercent }}</div>
                                    <div class="currency" id="sale-price"></div>
                                    <div class="currency" id="regular-price"></div>
                                    <div class="" id="percent-discount"></div>
                                </div>
                                <div class="rating mt-2">
                                    <ul>
                                        <li>
                                            @php
                                                $averageRating = $reviewData['stats']['average_rating'];
                                                $fullStars = floor($averageRating);
                                                $hasHalfStar = $averageRating - $fullStars >= 0.5;
                                                $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                                            @endphp

                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fa-solid fa-star"></i>
                                            @endfor

                                            @if ($hasHalfStar)
                                                <i class="fa-solid fa-star-half-stroke"></i>
                                            @endif

                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                <i class="fa-regular fa-star"></i>
                                            @endfor
                                        </li>
                                        <li>
                                            <h5 class="number-star">({{ number_format($reviewData['stats']['average_rating'], 1) }})</h5>
                                        </li>
                                        @if (!empty($reviewData['stats']['total_reviews']))
                                            <li>
                                                <h5 class="total-rating">
                                                    <span style="font-weight: 800">{{ $reviewData['stats']['total_reviews'] }}</span> đánh giá
                                                </h5>
                                            </li>
                                        @endif
                                        <li>
                                            <h5 class="total-rating">
                                                <span style="font-weight: 800">{{ $reviewData['stats']['total_sold'] }}</span> đã bán
                                            </h5>
                                        </li>
                                    </ul>
                                </div>
                                <div class="buy-box border-buttom mb-3">
                                    <ul>
                                        <li> <span data-bs-toggle="modal" data-bs-target="#size-chart" title="Quick View" tabindex="0"><i class="iconsax me-2" data-icon="ruler"></i>Biểu đồ kích cỡ</span>
                                        </li>
                                        <li> <span data-bs-toggle="modal" data-bs-target="#terms-conditions-modal" title="Quick View" tabindex="0"><i class="iconsax me-2" data-icon="truck"></i>Giao hàng & hoàn trả</span></li>
                                        {{-- <li> <span data-bs-toggle="modal" data-bs-target="#question-box" title="Quick View" tabindex="0"><i class="iconsax me-2" data-icon="question-message"></i>Đặt câu hỏi</span></li> --}}
                                    </ul>
                                </div>
                                <input type="number" class="total_attributes" value="{{ count($array_attributes) }}" hidden>
                                <input type="number" class="product_id" value="{{ $product->id }}" hidden>
                                <div class="blink-border">
                                    @foreach ($array_attributes as $attribute_item)
                                        @if ($attribute_item['type'] == 'button')
                                            <div class="d-flex attribute-section">
                                                <div>
                                                    <h5>{{ $attribute_item['name'] }}:</h5>
                                                    <div class="button-box attribute_group" data-id="{{ $attribute_item['id'] }}" data-type="{{ $attribute_item['type'] }}">
                                                        <ul class="button-variant">
                                                            @foreach ($attribute_item['attribute_values'] as $attribute_value_item)
                                                                <li class="attribute_item able" title="{{ $attribute_value_item['name'] }}" data-id="{{ $attribute_value_item['id'] }}">
                                                                    {{ $attribute_value_item['name'] }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($attribute_item['type'] == 'color')
                                            <div class="attribute-section">
                                                <h5>{{ $attribute_item['name'] }}:</h5>
                                                <div class="color-box attribute_group" data-id="{{ $attribute_item['id'] }}">
                                                    <ul class="color-variant">
                                                        @foreach ($attribute_item['attribute_values'] as $attribute_value_item)
                                                            <li class="attribute_item able" title="{{ $attribute_value_item['name'] }}"
                                                                style="background-color: {{ $attribute_value_item['value'] }}; border:1px solid rgba(var(--theme-default))"
                                                                data-id="{{ $attribute_value_item['id'] }}">
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            <div class="attribute-section">
                                                <h5>{{ $attribute_item['name'] }}:</h5>
                                                <div class="default-box attribute_group" data-id="{{ $attribute_item['id'] }}">
                                                    <ul class="default-variant">
                                                        @foreach ($attribute_item['attribute_values'] as $attribute_value_item)
                                                            <li class="attribute_item able" title="{{ $attribute_value_item['name'] }}" data-id="{{ $attribute_value_item['id'] }}">
                                                                {{ $attribute_value_item['name'] }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="quantity-box d-flex align-items-center gap-3">
                                    <div class="quantity_pro">
                                        <button class="reduce" type="button"><i class="fa-solid fa-minus"></i></button>
                                        <input class="quantity" type="number" value="1" min="1" max="20">
                                        <button class="increment" type="button"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                    <div class="selected-variant d-flex">
                                        <p id="update-stock" class="me-1" style="color: rgb(0, 181, 120)">{{ $total_stock }} </p> sản phẩm có sẵn
                                    </div>
                                    <!-- Nút "Chọn lại" -->
                                    <div class="reset-button">
                                        <button class="reset_selected">Chọn lại</button>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center w-100 add-cart-box mb-3 gap-2">
                                    <a class="btn btn_black sm add-to-cart" href="#" title="add product">Thêm vào giỏ hàng</a>
                                    <a class="btn btn_outline sm" href="#" id="buy_now">Mua ngay</a>
                                    <!-- Xử lý đặt hàng -->
                                    <form id="form_post_data_to_check_out" action="{{ route('checkout') }}" method="POST">
                                        @csrf
                                        @method('GET')
                                        <input type="hidden" name="product_variant_id" id="input_post_data_to_check_out">
                                        <input type="hidden" name="quantity" id="quantity">
                                        <input type="hidden" name="status_cart" id="is_cart">
                                    </form>
                                </div>
                                <div class="buy-box">
                                    <ul>
                                        <li> <a href="#"> <i class="fa-regular fa-heart me-2"></i>Thêm vào yêu thích</a></li>
                                        <li> <a href="#"> <i class="fa-solid fa-arrows-rotate me-2"></i>So sánh</a></li>
                                        <li> <a href="#" data-bs-toggle="modal" data-bs-target="#social-box" title="Quick View" tabindex="0"><i
                                                    class="fa-solid fa-share-nodes me-2"></i>Chia sẻ</a></li>
                                    </ul>
                                </div>
                                <div class="sale-box">
                                    <div class="d-flex align-items-center gap-2"><img src="{{ asset('assets/images/gif/timer.gif') }}" alt="">
                                        <p>Thời gian còn lại có hạn! Nhanh tay mua ngay.</p>
                                    </div>
                                    <div class="countdown">
                                        <ul class="clockdiv1">
                                            <li>
                                                <div class="timer">
                                                    <div class="days"></div>
                                                </div><span class="title">Ngày</span>
                                            </li>
                                            <li>:</li>
                                            <li>
                                                <div class="timer">
                                                    <div class="hours"></div>
                                                </div><span class="title">Giờ</span>
                                            </li>
                                            <li>:</li>
                                            <li>
                                                <div class="timer">
                                                    <div class="minutes"></div>
                                                </div><span class="title">Phút</span>
                                            </li>
                                            <li>:</li>
                                            <li>
                                                <div class="timer">
                                                    <div class="seconds"></div>
                                                </div><span class="title">Giây</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- <div class="dz-info">
                                    <ul>
                                        <li>
                                            <div class="d-flex align-items-center gap-2">
                                                <h6>Sku:</h6>
                                                <p> SKU_45 </p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center gap-2">
                                                <h6>Available: </h6>
                                                <p>Pre-Order</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center gap-2">
                                                <h6>Tags: </h6>
                                                <p>Color Pink Clay , Athletic, Accessories, Vendor Kalles</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center gap-2">
                                                <h6>Vendor: </h6>
                                                <p> Balenciaga</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div> --}}
                                <div class="share-option">
                                    <h5>Thanh toán an toàn </h5><img class="img-fluid" src="{{ asset('assets/images/other-img/secure_payments.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="custom-accordion product-custom-accordion">
                            <div class="accordion product-content" id="accordionDescription">
                                {{-- Mô tả sản phẩm --}}
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne"><span>Mô tả sản phẩm</span></button>
                                    </h2>
                                    <div class="accordion-collapse collapse show" id="collapseOne" data-bs-parent="#accordionDescription">
                                        <div class="accordion-body">
                                            <div class="row gy-4">
                                                {!! $product->description !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo"><span>Hướng dẫn sử dụng và bảo quản</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseTwo" data-bs-parent="#accordionDescription">
                                        <div class="accordion-body">
                                            <p>- KHÔNG giặt máy. KHÔNG sử dụng nước giặt chứa chất tẩy.</p>
                                            <p>- KHÔNG ngâm trong nước. KHÔNG giặt chung với quần áo có màu.</p>
                                            <p>- KHÔNG giặt khô. KHÔNG là.</p>
                                            <p>- KHÔNG sấy áo lông vũ trong máy sấy nhiệt độ cao.</p>
                                            <p>- KHÔNG phơi sản phẩm dưới ánh nắng trực tiếp, để khô tự nhiên ở nơi thoáng mát.</p>
                                            <p>- KHÔNG cất sản phẩm khi còn ẩm, chưa khô hoàn toàn.</p>
                                            <p>- KHÔNG nên cho sản phẩm sau khi sử dụng vào túi nylon hoặc các hộp kín</p>
                                            <p>- Giặt tay nước mát và ấn, bóp nhẹ sản phẩm</p>
                                            <p>- Vỗ nhẹ sản phẩm sau khi phơi khô và kéo căng về mặt vải để lông vũ phục hồi trạng thái ban đầu.</p>
                                            <p>- Xử lý lông lông vũ bị rút ra ngoài đường chỉ may bằng cách kéo ngược lại sợi vào trong áo (Do ma sát khi sử dụng hoặc do tĩnh
                                                điện).</p>
                                            <p>- Sản phẩm được gấp/gói trong thời gian dài có thể bị nhăn vải bề mặt. Kéo căng bề mặt vải và treo sản phẩm để được phục hồi
                                                nguyên bản trạng thái ban đầu.</p>
                                            <p>- Khi không sử dụng cần giặt sạch sản phẩm và bảo quản tại nơi khô thoáng sau khi đã phơi khô hoàn toàn.</p>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                            aria-expanded="false" aria-controls="collapseThree"><span>Q & A</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseThree" data-bs-parent="#accordionDescription">
                                        <div class="accordion-body">
                                            <div class="question-main-box">
                                                <h5>Questions & Answers</h5>
                                                <h6 data-bs-toggle="modal" data-bs-target="#question-modal" title="Quick View" tabindex="0">Post Your Question</h6>
                                            </div>
                                            <div class="question-answer">
                                                <ul>
                                                    <li>
                                                        <div class="question-box">
                                                            <p>Q1 </p>
                                                            <h6>Which designer created the little black dress?</h6>
                                                            <ul class="link-dislike-box">
                                                                <li> <a href="#"><i class="iconsax" data-icon="like">
                                                                        </i>0</a></li>
                                                                <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                                        </i>0</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="answer-box"><b>Ans.</b><span>The little black dress
                                                                (LBD) is often attributed to the iconic fashion designer
                                                                Coco Chanel. She popularized the concept of the LBD in the
                                                                1920s, offering a simple, versatile, and elegant garment
                                                                that became a staple in women's fashion.</span></div>
                                                    </li>
                                                    <li>
                                                        <div class="question-box">
                                                            <p>Q2 </p>
                                                            <h6>Which First Lady influenced women's fashion in the 1960s?
                                                            </h6>
                                                            <ul class="link-dislike-box">
                                                                <li> <a href="#"><i class="iconsax" data-icon="like">
                                                                        </i>0</a></li>
                                                                <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                                        </i>0</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="answer-box"><b>Ans.</b><span>The First Lady who
                                                                significantly influenced women's fashion in the 1960s was
                                                                Jacqueline Kennedy, the wife of President John F. Kennedy.
                                                                She was renowned for her elegant and sophisticated style,
                                                                often wearing simple yet chic outfits that set trends during
                                                                her time in the White House. </span></div>
                                                    </li>
                                                    <li>
                                                        <div class="question-box">
                                                            <p>Q3 </p>
                                                            <h6>What was the first name of the fashion designer Chanel?</h6>
                                                            <ul class="link-dislike-box">
                                                                <li> <a href="#"><i class="iconsax" data-icon="like">
                                                                        </i>0</a></li>
                                                                <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                                        </i>0</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="answer-box"><b>Ans.</b><span>The first name of the
                                                                fashion designer Chanel was Gabrielle. Gabrielle "Coco"
                                                                Chanel was a pioneering French fashion designer known for
                                                                her timeless designs, including the iconic Chanel suit and
                                                                the little black dress.</span></div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- Đánh giá --}}
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                            aria-expanded="false" aria-controls="collapseThree"><span>Đánh giá</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseFour" data-bs-parent="#accordionDescription">
                                        <div class="accordion-body mb-4">
                                            @if ($reviewData['stats']['total_reviews'] > 0)
                                                <div class="row gy-4">
                                                    <div class="col-lg-4">
                                                        <div class="review-right">
                                                            <div class="customer-rating">
                                                                <div class="global-rating">
                                                                    <div>
                                                                        <h5>{{ number_format($reviewData['stats']['average_rating'], 1) }}</h5>
                                                                    </div>
                                                                    <div>
                                                                        <h6>Đánh giá trung bình</h6>
                                                                        <ul class="rating mb p-0">
                                                                            @php
                                                                                $fullStars = floor($reviewData['stats']['average_rating']);
                                                                                $hasHalfStar = $reviewData['stats']['average_rating'] - $fullStars >= 0.5;
                                                                            @endphp
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                @if ($i <= $fullStars)
                                                                                    <li><i class="fa-solid fa-star"></i></li>
                                                                                @elseif($i == $fullStars + 1 && $hasHalfStar)
                                                                                    <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                                                                @else
                                                                                    <li><i class="fa-regular fa-star"></i></li>
                                                                                @endif
                                                                            @endfor
                                                                            <li><span>({{ $reviewData['stats']['total_reviews'] }})</span></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <ul class="rating-progess">
                                                                    @foreach ($reviewData['stats']['star_percentages'] as $star => $percentage)
                                                                        <li>
                                                                            <p>{{ $star }} Sao</p>
                                                                            <div class="progress" role="progressbar" aria-label="Rating progress" aria-valuenow="{{ $percentage }}"
                                                                                aria-valuemin="0" aria-valuemax="100">
                                                                                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: {{ $percentage }}%"></div>
                                                                            </div>
                                                                            <p>{{ $percentage }}%</p>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="comments-box">
                                                            <h5>Đánh giá người dùng ({{ $reviewData['stats']['active_review_count'] }})</h5>
                                                            <ul class="theme-scrollbar">
                                                                @foreach ($reviewData['reviews'] as $review)
                                                                    <li class="w-100">
                                                                        <div class="comment-items">
                                                                            <div class="user-img">
                                                                                <img src="{{ asset('assets/images/user/user-icon.jpg') }}" alt="User Avatar">
                                                                            </div>
                                                                            <div class="user-content">
                                                                                <div class="user-info">
                                                                                    <div class="d-flex justify-content-between gap-3">
                                                                                        <h6>
                                                                                            <i class="iconsax" data-icon="user-1"></i>
                                                                                            {{ substr($review->user->full_name, 0, -4) . '****' }}
                                                                                        </h6>
                                                                                        <span>
                                                                                            <i class="iconsax" data-icon="clock"></i>
                                                                                            {{ \Carbon\Carbon::parse($review->created_at)->format('M d, Y') }}
                                                                                        </span>
                                                                                    </div>
                                                                                    <ul class="rating mb p-0">
                                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                                            <li>
                                                                                                <i class="{{ $i <= $review->star ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                                                                            </li>
                                                                                        @endfor
                                                                                    </ul>
                                                                                </div>
                                                                                <p>{{ $review->content }}</p>
                                                                                <span class="variant-info">
                                                                                    <small class="text-muted">
                                                                                        Mã biến thể: {{ $review->product_variant->SKU }}
                                                                                    </small>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="text-center py-5">
                                                    <div>
                                                        <img class="img-fluid" src="{{ asset('assets/images/user/beesFashion.svg') }}" width="250">
                                                    </div>
                                                    <h6 class="mt-4">Sản phẩm chưa có đánh giá</h6>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                {{-- End đánh giá --}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        @if (count($relatedProducts) > 0)
            <section class="section-b-space pt-0 mb-4">
                <div class="custom-container product-contain container">
                    <div class="text-center mb-4">
                        <h3>Sản Phẩm Liên Quan</h3>
                    </div>
                    <div class="swiper special-offer-slide-2">
                        <div class="swiper-wrapper ratio1_3">
                            @foreach ($relatedProducts as $relatedProduct)
                                <div class="swiper-slide">
                                    <div class="product-box-3">
                                        <div class="img-wrapper">
                                            <div class="label-block"><a class="label-2 wishlist-icon" href="javascript:void(0)" tabindex="0"><i class="iconsax" data-icon="heart"
                                                        aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a></div>
                                            <div class="product-image">
                                                <a class="pro-first" href="{{ route('product.detail', $relatedProduct->SKU) }}">
                                                    <img class="bg-img" src="{{ asset('uploads/products/images/' . $relatedProduct->active_image) }}" alt="product"></a>
                                                <a class="pro-sec" href="{{ route('product.detail', $relatedProduct->SKU) }}">
                                                    <img class="bg-img" src="{{ asset('uploads/products/images/' . $relatedProduct->inactive_image) }}" alt="product"></a>
                                            </div>
                                            <div class="cart-info-icon">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart" tabindex="0"><i class="iconsax" data-icon="basket-2" aria-hidden="true"
                                                        data-bs-toggle="tooltip" data-bs-title="Add to cart">
                                                    </i></a>
                                                {{-- <a href="compare.html" tabindex="0"><i class="iconsax" data-icon="arrow-up-down" aria-hidden="true" data-bs-toggle="tooltip"
                                                data-bs-title="Compare"></i></a> --}}
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view" tabindex="0"><i class="iconsax" data-icon="eye" aria-hidden="true"
                                                        data-bs-toggle="tooltip" data-bs-title="Quick View"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-detail">
                                            <ul class="rating">
                                                @php
                                                    $rating = $relatedProduct->rating['average_rating'];
                                                    $fullStars = floor($rating);
                                                    $hasHalfStar = $rating - $fullStars >= 0.5;
                                                    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                                                @endphp

                                                @for ($i = 0; $i < $fullStars; $i++)
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                @endfor

                                                @if ($hasHalfStar)
                                                    <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                                @endif

                                                @for ($i = 0; $i < $emptyStars; $i++)
                                                    <li><i class="fa-regular fa-star"></i></li>
                                                @endfor

                                                <li>{{ number_format($rating, 1) }}</li>
                                            </ul><a href="{{ route('product.detail', $relatedProduct->id) }}">
                                                <h6>{{ $relatedProduct->name }}</h6>
                                            </a>
                                            <p style="color: rgb(201, 33, 39)">{{ $relatedProduct->priceRange }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if (count($bestProducts) > 0)
            <section class="section-b-space pt-0 mb-4">
                <div class="custom-container product-contain container">
                    <div class="text-center mb-4">
                        <h3>Sản Phẩm Bán Chạy</h3>
                    </div>
                    <div class="swiper special-offer-slide-2">
                        <div class="swiper-wrapper ratio1_3">
                            @foreach ($bestProducts as $bestProduct)
                                <div class="swiper-slide">
                                    <div class="product-box-3">
                                        <div class="img-wrapper">
                                            <div class="label-block"><span class="info-ticket seller">Best Seller</span><a class="label-2 wishlist-icon" href="javascript:void(0)" tabindex="0"><i
                                                        class="iconsax" data-icon="heart" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a></div>
                                            <div class="product-image">
                                                <a class="pro-first" href="{{ route('product.detail', $bestProduct->SKU) }}">
                                                    <img class="bg-img" src="{{ asset('uploads/products/images/' . $bestProduct->active_image) }}" alt="product"></a>
                                                <a class="pro-sec" href="{{ route('product.detail', $bestProduct->SKU) }}">
                                                    <img class="bg-img" src="{{ asset('uploads/products/images/' . $bestProduct->inactive_image) }}" alt="product"></a>
                                            </div>
                                            <div class="cart-info-icon">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart" tabindex="0"><i class="iconsax" data-icon="basket-2" aria-hidden="true"
                                                        data-bs-toggle="tooltip" data-bs-title="Add to cart">
                                                    </i></a>
                                                {{-- <a href="compare.html" tabindex="0"><i class="iconsax" data-icon="arrow-up-down" aria-hidden="true" data-bs-toggle="tooltip"
                                                data-bs-title="Compare"></i></a> --}}
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view" tabindex="0"><i class="iconsax" data-icon="eye" aria-hidden="true"
                                                        data-bs-toggle="tooltip" data-bs-title="Quick View"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-detail">
                                            <ul class="rating">
                                                @php
                                                    $rating = $bestProduct->rating['average_rating'];
                                                    $fullStars = floor($rating);
                                                    $hasHalfStar = $rating - $fullStars >= 0.5;
                                                    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                                                @endphp

                                                @for ($i = 0; $i < $fullStars; $i++)
                                                    <li><i class="fa-solid fa-star"></i></li>
                                                @endfor

                                                @if ($hasHalfStar)
                                                    <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                                @endif

                                                @for ($i = 0; $i < $emptyStars; $i++)
                                                    <li><i class="fa-regular fa-star"></i></li>
                                                @endfor

                                                <li>{{ number_format($rating, 1) }}</li>
                                            </ul><a href="{{ route('product.detail', $bestProduct->id) }}">
                                                <h6>{{ $bestProduct->name }}</h6>
                                            </a>
                                            <p style="color: rgb(201, 33, 39)">{{ $bestProduct->priceRange }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <div class="reviews-modal modal theme-modal fade" id="question-modal" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Ask a question</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="reviews-product">
                                    <div> <img src="../assets/images/modal/1.jpg" alt="">
                                        <div>
                                            <h5>Denim Skirts Corset Blazer</h5>
                                            <p>$20.00 <del>$35.00</del></p>
                                            <ul class="rating mb p-0">
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-regular fa-star"> </i></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="from-group"> <label class="form-label">Your Question</label>
                                    <textarea class="form-control" id="comment-1" cols="30" rows="5" placeholder="Write Your Question here..."></textarea>
                                </div>
                            </div>
                            <div class="modal-button-group"><button class="btn btn-cancel" type="submit" data-bs-dismiss="modal" aria-label="Close">Cancel</button><button class="btn btn-submit"
                                    type="submit" data-bs-dismiss="modal" aria-label="Close">Submit</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="terms-conditions-modal modal theme-modal fade" id="terms-conditions-modal" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Giao hàng & trả hàng</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <ul class="returns-policy">
                            <li> <b>Chính sách trả hàng: </b>Hầu hết các mặt hàng chưa mở có thể được trả lại trong vòng 30 ngày kể từ ngày giao hàng để được hoàn lại toàn bộ tiền. Chúng tôi chi trả chi phí vận chuyển trả lại cho các lỗi của chúng tôi (ví dụ: các mặt hàng không đúng hoặc bị lỗi). Việc hoàn tiền thường được xử lý trong vòng bốn tuần, mặc dù thường nhanh hơn. Điều này bao gồm thời gian vận chuyển trả lại (5-10 ngày làm việc), xử lý khi nhận được (3-5 ngày làm việc) và xử lý hoàn tiền của ngân hàng của bạn (5-10 ngày làm việc). Để trả lại một mặt hàng, hãy đăng nhập, truy cập đơn hàng của bạn và nhấp vào "Trả lại mặt hàng". Chúng tôi sẽ gửi email cho bạn sau khi việc trả lại của bạn được xử lý.</li>
                            <li>– Miễn phí vận chuyển cho các đơn hàng trên 200.000đ.</li>
                            <li>– Chấp nhận trả lại trong vòng 10 ngày kể từ ngày nhận đối với các mặt hàng chưa mặc. </li>
                            <li>– Vui lòng tham khảo Điều khoản & Điều kiện giao hàng của chúng tôi để biết thêm chi tiết.</li>
                            <li>– Các sản phẩm trả lại phải còn trong bao bì gốc, được bọc an toàn, không bị hư hỏng và chưa mặc.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal theme-modal fade" id="size-chart" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Size Chart</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0"><a href="#"> <img class="img-fluid" src="../assets/images/size-chart/size-chart.jpg" alt=""></a></div>
                </div>
            </div>
        </div>

        <div class="modal theme-modal fade question-answer-modal" id="question-box" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Ask a Question</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="reviews-product">
                                    <div> <img src="../assets/images/modal/0.jpg" alt="">
                                        <div>
                                            <h5>Denim Skirts Corset Blazer</h5>
                                            <p>$20.00 <del>$35.00 </del></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="from-group"> <label class="form-label">Your Question :</label>
                                    <textarea class="form-control" id="comment" cols="30" rows="4" placeholder="Write your Question here..."></textarea>
                                </div>
                            </div>
                            <div class="modal-button-group"><button class="btn btn-cancel" type="submit" data-bs-dismiss="modal" aria-label="Close">Cancel</button><button class="btn btn-submit"
                                    type="submit" data-bs-dismiss="modal" aria-label="Close">Submit</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal theme-modal fade social-modal" id="social-box" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6>Copy link</h6><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"><input class="form-field form-field--input" type="text" value="http://127.0.0.1:8000/">
                        <h6>Share:</h6>
                        <ul>
                            <li> <a href="#" target="_blank"> <i class="fa-brands fa-facebook-f"></i></a></li>
                            <li> <a href="#" target="_blank"> <i class="fa-brands fa-pinterest-p"></i></a></li>
                            <li> <a href="#" target="_blank"> <i class="fa-brands fa-x-twitter"></i></a>
                            </li>
                            <li> <a href="#" target="_blank"> <i class="fa-brands fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End container content -->
@endsection

@section('script-libs')
    <script src="{{ asset('assets/js/grid-option.js') }}"></script>
    <script>
        const array_variants = @json($array_variants) || [];
    </script>
    <script src="{{ asset('js/user/product-detail.js') }}"></script>
@endsection
