@extends('user.layouts.master')

@section('content')
    <!-- Container content -->
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>404</h4>
                        </div>
                        <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">404</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0">
            <div class="custom-container container error-img">
                <div class="row g-4">
                    <div class="col-12 px-0"> <a href="#"><img class="img-fluid"
                                src="../assets/images/other-img/404.png" alt=""></a></div>
                    <div class="col-12">
                        <h2>Page Not Found </h2>
                        <p>The page you are looking for doesn't exist or an other error occurred. Go back, or head over
                            to
                            choose a new direction. </p><a class="btn btn_black rounded" href="index.html">Back Home
                            Page
                            <svg>
                                <use href="https://themes.pixelstrap.net/katie/assets/svg/icon-sprite.svg#arrow"></use>
                            </svg></a>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- End container content -->
@endsection
