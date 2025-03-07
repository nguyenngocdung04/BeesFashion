@extends('user.layouts.master')

@section('script-libs')
    <script src="{{ asset('js/user/home.js') }}"></script>
@endsection

@section('content')
    <!-- Container content -->
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>Yêu thích</h4>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0">
            <div class="custom-container container wishlist-box">
                <div class="product-tab-content ratio1_3">
                    @if (count($products) > 0)
                        <div class="row-cols-xl-4 row-cols-md-3 row-cols-2 grid-section view-option row gy-4 g-xl-4">
                            @foreach ($products as $product)
                                <div class="col">
                                    <div class="product-box-3 product-wishlist">
                                        <div class="img-wrapper">
                                            <div class="label-block">
                                                <a class="label-2 delete-button" data-id="{{ $product->id }}"
                                                    href="javascript:void(0)" title="Remove from Wishlist" tabindex="0">
                                                    <i class="iconsax" data-icon="trash" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                            <div class="product-image"><a class="pro-first"
                                                    href="{{ route('product.detail', $product->SKU) }}"> <img class="bg-img"
                                                        src="{{ asset('uploads/products/images/' . $product->active_image) }}"
                                                        alt="product"></a><a class="pro-sec"
                                                    href="{{ route('product.detail', $product->SKU) }}"> <img class="bg-img"
                                                        src="{{ asset('uploads/products/images/' . $product->inactive_image) }}"
                                                        alt="product"></a></div>

                                        </div>
                                        <div class="product-detail">
                                            <ul class="rating">
                                                @php
                                                    $rating = $product->rating['average_rating'];
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
                                            </ul><a href="{{ route('product.detail', $product->SKU) }}">
                                                <h6>{{ \Illuminate\Support\Str::limit($product->name, 40) }}</h6>
                                            </a>
                                            <p>{{ $product->priceRange }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center">
                                <h5 class="text-center">Yêu thích của của bạn đang trống!</h5>
                                <div>
                                    <img class="img-fluid" src="{{ asset('assets/images/user/anhbanh.png') }}"
                                        width="190">
                                </div>
                                <div class="text-center mt-3">
                                    <a href="{{ route('/') }}" class="btn btn_black rounded sm">Quay lại trang chủ</a>
                                </div>
                            </div>
                    @endif

                </div>
            </div>
            </div>
        </section>

        </div>
    </main>
    <!-- End container content -->

@endsection
