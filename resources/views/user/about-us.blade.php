@extends('user.layouts.master')

@section('content')
    <!-- Container content -->
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>About Us </h4>
                        </div>
                        {{-- <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">About Us </a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0">
            <div class="custom-container container">
                <div class="row align-items-center gy-4">
                    <div class="col-lg-6 order-1 order-lg-1 ratio_55">
                        <div class="about-img"> <img class="bg-img img-fluid" src="{{asset('assets/images/about/7.jpg')}}" alt="">
                            <div class="about-tag"> <a href="{{route('product')}}">
                                    <h5>Women</h5><i class="fa-solid fa-arrow-right"></i>
                                </a></div>
                        </div>
                    </div>
                    <div class="col-lg-6 order-2 order-lg-2">
                        <div class="about-content">
                            <div class="sidebar-title">
                                <div class="loader-line"></div>
                                <h3>Here's the newest fashion. </h3>
                            </div>
                            <p>With increased awareness about environmental issues, sustainable fashion has gained
                                traction.
                                Women are embracing eco-friendly materials, upcycling, and supporting brands with
                                transparent supply chains. Layering isn't just about staying warm—it's a styling
                                technique
                                that adds depth and dimension to outfits. Lightweight cardigans, duster coats, and
                                scarves
                                are essential layering pieces that can easily transition from day to night.</p>
                            <ul>
                                <li><i class="iconsax" data-icon="cloud"></i>
                                    <div>
                                        <h6>Soft Fabric</h6>
                                        <p>Get complimentary ground shipping on every order.Don’t love it? Send it back,
                                            on
                                            us.</p>
                                    </div>
                                </li>
                                <li> <i class="iconsax" data-icon="clock"></i>
                                    <div>
                                        <h6>All Day Comfort</h6>
                                        <p>We believe getting dressed should be the easiest part of your day.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 order-4 order-lg-3">
                        <div class="about-content about-content-1">
                            <div class="sidebar-title">
                                <div class="loader-line"></div>
                                <h3>Mastering Men's Fashion</h3>
                            </div>
                            <p>Start with foundational pieces like well-fitted jeans, classic white shirts, and
                                versatile
                                jackets. These basics form the backbone of your wardrobe, allowing for endless
                                mix-and-match
                                possibilities.Whether it's a suit or a simple button-down shirt, proper tailoring can
                                elevate your look from average to exceptional. Invest in alterations to ensure your
                                clothes
                                fit impeccably, enhancing your silhouette and boosting your confidence.</p>
                            <ul>
                                <li><i class="iconsax" data-icon="cloud"></i>
                                    <div>
                                        <h6>Soft Fabric</h6>
                                        <p>Get complimentary ground shipping on every order.Don’t love it? Send it back,
                                            on
                                            us.</p>
                                    </div>
                                </li>
                                <li> <i class="iconsax" data-icon="clock"></i>
                                    <div>
                                        <h6>All Day Comfort</h6>
                                        <p>We believe getting dressed should be the easiest part of your day.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 order-3 order-lg-4 ratio_55">
                        <div class="about-img about-img-1"> <img class="bg-img img-fluid"
                                src="{{asset('assets/images/about/8.jpg')}}" alt="">
                            <div class="about-tag"> <a href="{{route('product')}}">
                                    <h5>Men</h5><i class="fa-solid fa-arrow-right"></i>
                                </a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space layout-light">
            <div class="custom-container container">
                <div class="row gy-4">
                    <div class="col-12">
                        <div class="title-1">
                            <p>Our Excellence<span></span></p>
                            <h3>Superiority is our first priority.</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="about-icon"> <i class="iconsax" data-icon="blur"></i>
                            <h5>Superior Substances</h5>
                            <p>Our sportswear is precisely engineered to provide unparalleled comfort and durability,
                                using
                                quality fabrics in its expert construction.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="about-icon"> <i class="iconsax" data-icon="diamonds"></i>
                            <h5>Simple Style</h5>
                            <p>Elegant simplicity. Our sportswear exudes effortless flair that communicates volumes,
                                embodying the essence of minimalistic design.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="about-icon"> <i class="iconsax" data-icon="media-sliders-3"></i>
                            <h5>Different Dimensions</h5>
                            <p>With a broad selection of sizes and shapes, our sportswear encourages diversity and
                                celebrates the beauty of individuality, catering to all body types.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pb-0 fashion-girl">
            <div class="custom-container container">
                <div class="row gy-4 align-items-end">
                    <div class="col-12">
                        <div class="title-1 mb-0">
                            <p>Our Fashion Style<span></span></p>
                            <h3>Salutations from the New Fashion Era</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fashion-box-1">
                            <p>Quisquemos sodales suscipit tortor ditaemcos condimentum de cosmo lacus meleifend menean
                                diverra loremous. Nullam sit amet orci rutrum risus laoreet semper vel non magna. Mauris
                                vel
                                sem a lectus vehicula ultricies. Etiam semper sollicitudin lectus indous scelerisque...
                            </p>
                            <a href="{{route('product')}}">Let's Check this out <i
                                    class="fa-solid fa-arrow-right-long"></i></a><img class="img-fluid"
                                src="{{asset('assets/images/about/fashion-1.jpg')}}" alt="">
                        </div>
                    </div>
                    <div class="col-md-4 d-none d-md-block">
                        <div class="product-img"><img class="img-fluid" src="{{asset('assets/images/about/1.png')}}" alt=""></div>
                    </div>
                    <div class="col-md-4">
                        <div class="fashion-box-1 fashion-item"> <img class="img-fluid"
                                src="{{asset('assets/images/about/fashion-2.jpg')}}" alt=""><a href="{{route('product')}}">Let's Check
                                this
                                out <i class="fa-solid fa-arrow-right-long"></i></a>
                            <p>Quisquemos sodales suscipit tortor ditaemcos condimentum de cosmo lacus meleifend menean
                                diverra loremous. Nullam sit amet orci rutrum risus laoreet semper vel non magna. Mauris
                                vel
                                sem a lectus vehicula ultricies. Etiam semper sollicitudin lectus indous scelerisque...
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space layout-light">
            <div class="custom-container container">
                <div class="row">
                    <div class="col-12">
                        <div class="title-1">
                            <p>Our Creative Team<span></span></p>
                            <h3>Katie Team Member</h3>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="swiper our-team">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="our-team-content">
                                        <div class="team-img"><img class="img-fluid" src="{{asset('assets/images/about/1.jpg')}}"
                                                alt="">
                                            <ul class="social-group">
                                                <li> <a href="https://www.facebook.com/" target="_blank"><i
                                                            class="fa-brands fa-facebook-f"></i></a></li>
                                                <li> <a href="https://www.facebook.com/" target="_blank"><i
                                                            class="fa-brands fa-instagram"> </i></a></li>
                                                <li> <a href="https://www.pinterest.com/" target="_blank"><i
                                                            class="fa-brands fa-pinterest"></i></a></li>
                                                <li> <a href="https://twitter.com/" target="_blank"><i
                                                            class="fa-brands fa-x-twitter"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="team-content">
                                            <h5>Edward Lindgren</h5>
                                            <p>Marketing</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="our-team-content">
                                        <div class="team-img"><img class="img-fluid" src="{{asset('assets/images/about/2.jpg')}}"
                                                alt="">
                                            <ul class="social-group">
                                                <li> <a href="https://www.facebook.com/" target="_blank"><i
                                                            class="fa-brands fa-facebook-f"></i></a></li>
                                                <li> <a href="https://www.facebook.com/" target="_blank"><i
                                                            class="fa-brands fa-instagram"> </i></a></li>
                                                <li> <a href="https://www.pinterest.com/" target="_blank"><i
                                                            class="fa-brands fa-pinterest"></i></a></li>
                                                <li> <a href="https://twitter.com/" target="_blank"><i
                                                            class="fa-brands fa-x-twitter"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="team-content">
                                            <h5>Lisa John</h5>
                                            <p>Chief Operating Officer</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="our-team-content">
                                        <div class="team-img"><img class="img-fluid" src="{{asset('assets/images/about/3.jpg')}}"
                                                alt="">
                                            <ul class="social-group">
                                                <li> <a href="https://www.facebook.com/" target="_blank"><i
                                                            class="fa-brands fa-facebook-f"></i></a></li>
                                                <li> <a href="https://www.facebook.com/" target="_blank"><i
                                                            class="fa-brands fa-instagram"> </i></a></li>
                                                <li> <a href="https://www.pinterest.com/" target="_blank"><i
                                                            class="fa-brands fa-pinterest"></i></a></li>
                                                <li> <a href="https://twitter.com/" target="_blank"><i
                                                            class="fa-brands fa-x-twitter"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="team-content">
                                            <h5>Chineze Afamefuna</h5>
                                            <p>Marketing</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="our-team-content">
                                        <div class="team-img"><img class="img-fluid" src="{{asset('assets/images/about/4.jpg')}}"
                                                alt="">
                                            <ul class="social-group">
                                                <li> <a href="https://www.facebook.com/" target="_blank"><i
                                                            class="fa-brands fa-facebook-f"></i></a></li>
                                                <li> <a href="https://www.facebook.com/" target="_blank"><i
                                                            class="fa-brands fa-instagram"> </i></a></li>
                                                <li> <a href="https://www.pinterest.com/" target="_blank"><i
                                                            class="fa-brands fa-pinterest"></i></a></li>
                                                <li> <a href="https://twitter.com/" target="_blank"><i
                                                            class="fa-brands fa-x-twitter"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="team-content">
                                            <h5>Nado Husa</h5>
                                            <p>Marketing Director</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="our-team-content">
                                        <div class="team-img"><img class="img-fluid" src="{{asset('assets/images/about/5.jpg')}}"
                                                alt="">
                                            <ul class="social-group">
                                                <li> <a href="https://www.facebook.com/" target="_blank"><i
                                                            class="fa-brands fa-facebook-f"></i></a></li>
                                                <li> <a href="https://www.facebook.com/" target="_blank"><i
                                                            class="fa-brands fa-instagram"> </i></a></li>
                                                <li> <a href="https://www.pinterest.com/" target="_blank"><i
                                                            class="fa-brands fa-pinterest"></i></a></li>
                                                <li> <a href="https://twitter.com/" target="_blank"><i
                                                            class="fa-brands fa-x-twitter"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="team-content">
                                            <h5>Cartherin Forres</h5>
                                            <p>Co-Founder</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="our-team-content">
                                        <div class="team-img"><img class="img-fluid" src="{{asset('assets/images/about/6.jpg')}}"
                                                alt="">
                                            <ul class="social-group">
                                                <li> <a href="https://www.facebook.com/" target="_blank"><i
                                                            class="fa-brands fa-facebook-f"></i></a></li>
                                                <li> <a href="https://www.facebook.com/" target="_blank"><i
                                                            class="fa-brands fa-instagram"> </i></a></li>
                                                <li> <a href="https://www.pinterest.com/" target="_blank"><i
                                                            class="fa-brands fa-pinterest"></i></a></li>
                                                <li> <a href="https://twitter.com/" target="_blank"><i
                                                            class="fa-brands fa-x-twitter"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="team-content">
                                            <h5>Jane Doe</h5>
                                            <p>Marketing Director</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space">
            <div class="custom-container container">
                <div class="row">
                    <div class="col-12">
                        <div class="title-1">
                            <p>Latest Testimonials<span></span></p>
                            <h3>Our customer’s reviews</h3>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="swiper our-testimonials">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide testimonials-box">
                                    <div class="customer-item"><i class="fa-solid fa-quote-left"></i>
                                        <div class="customer-box">
                                            <p> Customers have been overwhelmingly positive about our new product. One
                                                satisfied customer mentioned, 'I've been using this for a week now, and
                                                I'm
                                                amazed at the results! It's incredibly easy to use and has exceeded my
                                                expectations.'</p>
                                        </div>
                                    </div>
                                    <div class="customer-img"><img class="img-fluid" src="{{asset('assets/images/user/user-icon.jpg')}}"
                                            alt="">
                                        <div>
                                            <h5> Jimmy C. Bash</h5>
                                            <p>@instagram</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide testimonials-box">
                                    <div class="customer-item"><i class="fa-solid fa-quote-left"></i>
                                        <div class="customer-box">
                                            <p> Another customer commented, 'This product has truly made a difference in
                                                my
                                                daily routine. I love how versatile it is and how it has simplified my
                                                life.' Additionally, a long-time user shared, 'I've tried similar
                                                products
                                                in the past</p>
                                        </div>
                                    </div>
                                    <div class="customer-img"><img class="img-fluid" src="{{asset('assets/images/user/user-icon.jpg')}}"
                                            alt="">
                                        <div>
                                            <h5> Jimmy C. Bash</h5>
                                            <p>@instagram</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide testimonials-box">
                                    <div class="customer-item"><i class="fa-solid fa-quote-left"></i>
                                        <div class="customer-box">
                                            <p> The quality is outstanding, and the customer service team has been very
                                                responsive to any questions I've had.' Overall, the feedback has been
                                                fantastic, with customers praising both the effectiveness of the product
                                                and
                                                the excellent support provided by our team."</p>
                                        </div>
                                    </div>
                                    <div class="customer-img"><img class="img-fluid" src="{{asset('assets/images/user/3.jpg')}}"
                                            alt="">
                                        <div>
                                            <h5> Jimmy C. Bash</h5>
                                            <p>@instagram</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide testimonials-box">
                                    <div class="customer-item"><i class="fa-solid fa-quote-left"></i>
                                        <div class="customer-box">
                                            <p> Structured chic panels power party flattering ultimate trim back pencil
                                                silhouette perfect look. Stretch lining hemline above knee burgundy
                                                satin
                                                finish concealed zip small buttons rayon 'I've tried similar products in
                                                the
                                                past, but none compare to this one</p>
                                        </div>
                                    </div>
                                    <div class="customer-img"><img class="img-fluid" src="{{asset('assets/images/user/8.jpg')}}"
                                            alt="">
                                        <div>
                                            <h5> Jimmy C. Bash</h5>
                                            <p>@instagram</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- End container content -->
@endsection
