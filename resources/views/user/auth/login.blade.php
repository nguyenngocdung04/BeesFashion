@extends('user.layouts.master')

@section('content')
    <!-- Container content -->
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>Đăng nhập</h4>
                        </div>
                        {{-- <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">Login</a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0 login-bg-img">
            <div class="custom-container container login-page">
                <div class="row align-items-center">
                    <div class="col-xxl-7 col-6 d-none d-lg-block">
                        <div class="login-img"> <img class="img-fluid"
                                src="{{asset('assets/images/user/auth.svg')}}" alt=""></div>
                    </div>
                    <div class="col-xxl-4 col-lg-6 mx-auto">
                        <div class="log-in-box">
                            <div class="log-in-title">
                                <h4>Chào mừng đến với BeesFashion</h4>
                                <p>Đăng nhập tài khoản của bạn</p>
                            </div>
                            {{-- Form login --}}
                            <div class="login-box">
                                <form class="row g-3" action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input class="form-control @error('login') is-invalid @enderror"
                                                id="floatingInputValue" type="text" name="login" placeholder="Nhập Email hoặc Username của bạn."
                                                 value="{{ old('login') }}">
                                            <label for="floatingInputValue">Nhập Email hoặc Username của bạn.</label>
                                            {{-- Hiển thị thông báo lỗi --}}
                                            @error('login')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input class="form-control @error('password') is-invalid @enderror"
                                                id="floatingInputValue1" type="password" name="password"
                                                placeholder="Nhập mật khẩu của bạn.">
                                            <label for="floatingInputValue1">Nhập mật khẩu của bạn.</label>
                                            {{-- Hiển thị thông báo lỗi --}}
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="forgot-box">
                                            <div>
                                                <input class="custom-checkbox me-2" id="login1" type="checkbox"
                                                    name="remember">
                                                <label for="login1">Ghi nhớ mật khẩu</label>
                                            </div>
                                            <a href="{{route('fotgot-pasword')}}">Quên mật khẩu?</a>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn login btn_black sm" type="submit" data-bs-dismiss="modal"
                                            aria-label="Close">Đăng Nhập</button>
                                    </div>
                                </form>
                            </div>

                            <div class="other-log-in">
                                <h6>OR</h6>
                            </div>
                            <div class="log-in-button">
                                <ul>
                                    <li> <a href="{{route('google')}}"> <i class="fa-brands fa-google me-2"> </i>Google</a></li>
                                    <li> <a href="#"><i class="fa-brands fa-facebook-f me-2"></i>Facebook </a></li>
                                </ul>
                            </div>
                            <div class="other-log-in"></div>
                            <div class="sign-up-box">
                                <p>Bạn chưa có tài khoản?</p><a href="{{ route('register') }}">Đăng Ký</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- End container content -->
@endsection
