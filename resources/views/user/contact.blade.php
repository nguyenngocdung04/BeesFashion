@extends('user.layouts.master')

@section('content')
    <!-- Container content -->
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>Liên hệ</h4>
                        </div>
                        {{-- <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">Contact</a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0">
            <div class="custom-container container">
                <div class="contact-main">
                    <div class="row gy-3">
                        <div class="col-12">
                            <div class="title-1 address-content">
                                <p class="pb-0">Thông Tin Liên Hệ<span></span></p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="address-items">
                                <div class="icon-box"><i class="iconsax" data-icon="phone-calling"></i></div>
                                <div class="contact-box">
                                    <h6>Số Điện Thoại</h6>
                                    <p>+84 123 - 456 - 7890</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="address-items">
                                <div class="icon-box"> <i class="iconsax" data-icon="mail"></i></div>
                                <div class="contact-box">
                                    <h6>Địa Chỉ Email</h6>
                                    <p>contact@beesfashion.com</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="address-items">
                                <div class="icon-box"><i class="iconsax" data-icon="location"></i></div>
                                <div class="contact-box">
                                    <h6>Địa Chỉ Khác</h6>
                                    <p>FPT Polytechnic Hà Nội</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="address-items">
                                <div class="icon-box"> <i class="iconsax" data-icon="map-1"></i></div>
                                <div class="contact-box">
                                    <h6>Văn Phòng</h6>
                                    <p>FPT Polytechnic</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0">
            <div class="custom-container container">
                <div class="contact-main">
                    <div class="row align-items-center gy-4">
                        <div class="col-lg-6 order-lg-1 order-2">
                            <div class="contact-box">
                                <h4>Liên hệ với chúng tôi</h4>
                                <p>Nếu bạn có những sản phẩm tuyệt vời hoặc muốn hợp tác, hãy liên hệ với chúng tôi.</p>
                                <form class="contact-form" action="{{ route('contact.store') }}" method="POST">
                                    @csrf
                                    <div class="row gy-4">
                                        <div class="col-12">
                                            <label class="form-label" for="inputEmail4">Họ và tên</label>
                                            <input class="form-control @error('full_name') is-invalid @enderror" id="inputEmail4" type="text" name="full_name" placeholder="Nhập họ và tên"
                                                value="{{ old('full_name') }}">
                                            @error('full_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="inputEmail5">Email</label>
                                            <input class="form-control @error('email') is-invalid @enderror" id="inputEmail5" type="email" name="email" placeholder="Nhập địa chỉ email"
                                                value="{{ old('email') }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="inputEmail6">Số điện thoại</label>
                                            <input class="form-control @error('phone') is-invalid @enderror" id="inputEmail6" type="text" name="phone" placeholder="Nhập số điện thoại"
                                                value="{{ old('phone') }}">
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="inputEmail7">Tiêu đề</label>
                                            <input class="form-control @error('subject') is-invalid @enderror" id="inputEmail7" type="text" name="subject" placeholder="Nhập tiêu đề"
                                                value="{{ old('subject') }}">
                                            @error('subject')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Nội dung</label>
                                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="6" placeholder="Nhập nội dung">{{ old('message') }}</textarea>
                                            @error('message')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn_black rounded sm" type="submit">Gửi tin nhắn</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6 order-lg-2 order-1 offset-xl-1">
                            <div class="contact-img"> <img class="img-fluid" src="{{ asset('assets/images/user/1.svg') }}" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- End container content -->
@endsection
