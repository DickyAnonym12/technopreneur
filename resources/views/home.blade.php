@extends('master1')

@section('title', 'home')

@section('content')

    <!-- ***** Main Banner Area Start ***** -->
    <div id="top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="left-content">
                        <div class="inner-content">
                            <h4>Blura</h4>
                            <h6>THE BEST COFFEE EVER</h6>

                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="main-banner header-text">
                        <div class="Modern-Slider">
                            <!-- Item -->
                            @foreach ($Slideshow as $slide)
                                <div class="item">
                                    <div class="img-fill">
                                        <img src="{{ asset('gambar/' . $slide->gambar_slideshow) }}" alt="">
                                    </div>
                                </div>
                            @endforeach
                            <!-- // Item -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- ***** About Area Starts ***** -->
    <section class="section" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="left-text-content">
                        <div class="section-heading">
                            <h6>About Us</h6>
                            <h2>We Leave A Delicious Memory For You</h2>
                        </div>
                        <p>Selamat datang di Konya, penyedia minuman terbaik yang menghadirkan cita rasa autentik dan
                            berkualitas tinggi. Kami berkomitmen untuk memberikan pengalaman minuman yang menyegarkan dan
                            memuaskan, dengan bahan-bahan pilihan dan proses produksi yang terjamin.
                        </p>
                        <div class="row">
                            <div class="col-4">
                                <img src="assets/images/images (4).jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img src="assets/images/Caramel-coffee11.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img src="assets/images/pistachio-latte-square.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="right-content">
                        <div class="thumb">
                            <a rel="nofollow" href="http://youtube.com"><i class="fa fa-play"></i></a>
                            <img src="assets/images/about-video-bg.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** About Area Ends ***** -->

    <!-- ***** Menu Area Starts ***** -->
    <section class="section" id="menu">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="section-heading">
                        <h6>Our Menu</h6>
                        <h2>Our selection of drinks with quality taste</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-item-carousel">
            <button class="scroll-left">
                &larr; <!-- Panah kiri -->
            </button>

            <div class="product-container">
                @foreach ($Products as $product)
                    <div class="product-card">
                        <img src="{{ asset('gambar/' . $product->gambar) }}" alt="{{ $product->nama_minuman }}"
                            class="product-image">
                        <div class="product-info">
                            <h1 class="product-title">{{ $product->nama_minuman }}</h1>
                            <p class="product-description">{{ $product->deskripsi }}</p>
                            <h3 class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>


                            <a href="{{ route('add.to.cart', ['id' => $product->Id_minuman]) }}"
                                class="buy-button text-center">
                                Beli Sekarang
                            </a>

                        </div>
                    </div>
                @endforeach
            </div>

            <button class="scroll-right">
                &rarr; <!-- Panah kanan -->
            </button>
        </div>



    </section>
    <!-- ***** Menu Area Ends ***** -->

    <!-- ***** Reservation Us Area Starts ***** -->
    <section class="section" id="reservation">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="left-text-content">
                        <div class="section-heading">
                            <h6>Contact Us</h6>
                            <h2>Here You Can Make A Reservation Or Just Walk In To Our Cafe</h2>
                        </div>
                        <p>Donec pretium est orci, non vulputate arcu hendrerit a. Fusce a eleifend riqsie, namei
                            sollicitudin urna diam, sed commodo purus porta ut.</p>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="phone">
                                    <i class="fa fa-phone"></i>
                                    <h4>Phone Numbers</h4>
                                    <span><a href="#">080-090-0990</a><br><a href="#">080-090-0880</a></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="message">
                                    <i class="fa fa-envelope"></i>
                                    <h4>Emails</h4>
                                    <span><a href="#">hello@company.com</a><br><a
                                            href="#">info@company.com</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">

                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.627812224595!2d101.44184527496479!3d0.5599116994346172!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5ab4281b3e397%3A0xee489c22626c1714!2sBlura%20Coffee%20Roastery!5e0!3m2!1sen!2sid!4v1777450101994!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> {{-- menambahkan ifrme --}}
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Reservation Area Ends ***** -->
@endsection
