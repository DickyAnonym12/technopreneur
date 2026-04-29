<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <title>Blura Coffee Roastery</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-klassy-cafe.css">
    <link rel="stylesheet" href="assets/css/owl-carousel.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <style>
        .nav li {
            list-style: none;
        }

        .nav {
            display: flex;
            gap: -2px;
        }

        .nav a {
            padding: 8px 3px;
            display: inline-block;
            text-decoration: none;
            color: #000;
        }

        .nav a:hover {
            color: #FF2D20;
        }

        /* =============================================
           FIX: Active state hanya muncul pada nav item
           yang sesuai dengan halaman yang sedang dibuka
        =============================================== */
        .nav a.active {
            color: #FF2D20;
        }

        /* Kontainer untuk menu item dengan scroll horizontal */
        .menu-item-carousel {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background-color: #1a3969;
            border-radius: 25px;
            position: relative;
            width: 100%;
        }

        /* Kontainer produk dengan scroll horizontal */
        .product-container {
            display: flex;
            overflow-x: auto;
            gap: 20px;
            padding-bottom: 20px;
            flex-wrap: nowrap;
            width: 100%;
            max-width: 100%;
            scroll-behavior: smooth;
        }

        /* Card Produk */
        .product-card {
            flex: 0 0 300px;
            min-width: 300px;
            margin: 0 15px;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 450px;
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        }

        /* Gambar Produk */
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
        }

        /* Info produk */
        .product-info {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Judul produk */
        .product-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Deskripsi produk */
        .product-description {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Harga Produk */
        .product-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #1a3969;
            margin-bottom: 15px;
        }

        /* Stok Produk */
        .product-stock {
            font-size: 0.9rem;
            color: #888;
            margin-bottom: 20px;
        }

        /* Tombol Buy Now */
        .buy-button {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            background-color: #1a3969;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .buy-button:hover {
            background-color: #1a3969;
        }

        .buy-button.disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }

        /* Product Container */
        .product-container {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 20px 0;
            gap: 20px;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .product-container::-webkit-scrollbar {
            display: none;
        }

        /* Scroll Buttons */
        .scroll-left,
        .scroll-right {
            background-color: #1a3969;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background-color 0.3s;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
        }

        .scroll-left {
            left: 10px;
        }

        .scroll-right {
            right: 10px;
        }

        .scroll-left:hover,
        .scroll-right:hover {
            background-color: #1a3969;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .product-card {
                flex: 0 0 250px;
                min-width: 250px;
                height: 400px;
            }

            .product-image {
                height: 150px;
            }

            .scroll-left,
            .scroll-right {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }
        }

        @media (max-width: 1024px) {
            .product-card {
                max-width: 250px;
            }

            .product-image {
                height: 200px;
            }

            .product-container {
                gap: 10px;
            }
        }

        @media (max-width: 768px) {
            .product-card {
                max-width: 200px;
            }

            .product-image {
                height: 150px;
            }
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        #top .main-banner {
            height: 400px;
            overflow: hidden;
        }

        #top .main-banner .img-fill img {
            object-fit: cover;
            width: 100%;
            height: 100%;
            max-height: 400px;
        }

        .Modern-Slider .item {
            height: 400px;
        }

        #top .left-content {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 400px;
            text-align: center;
        }

        #top .left-content .inner-content {
            padding: 20px;
        }
    </style>

</head>

<body>

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="{{ route('home') }}" class="logo">
                            <img src="assets/images/Blura.png" alt="LOGO KONYAte">
                        </a>
                        <!-- ***** Logo End ***** -->

                        <!-- ***** Menu Start ***** -->
                        @php
                            // Make section links work from any page (e.g. Cart) by routing through home first.
                            $home    = route('home');
                            $isHome  = request()->routeIs('home');
                            $isCart  = request()->routeIs('cart');

                            $linkTop     = $isHome ? '#top'         : ($home . '#top');
                            $linkAbout   = $isHome ? '#about'       : ($home . '#about');
                            $linkMenu    = $isHome ? '#menu'        : ($home . '#menu');
                            $linkContact = $isHome ? '#reservation' : ($home . '#reservation');
                        @endphp

                        <ul class="nav">
                            {{-- Home: aktif hanya jika di halaman home --}}
                            <li class="scroll-to-section">
                                <a href="{{ $linkTop }}" class="{{ $isHome ? 'active' : '' }}">Home</a>
                            </li>

                            <li class="scroll-to-section">
                                <a href="{{ $linkAbout }}">About</a>
                            </li>

                            <li class="scroll-to-section">
                                <a href="{{ $linkMenu }}">Menu</a>
                            </li>

                            <li class="scroll-to-section">
                                <a href="{{ $linkContact }}">Contact</a>
                            </li>

                            {{-- Cart: aktif hanya jika di halaman cart --}}
                            <li class="scroll-to-section">
                                <a href="{{ route('cart') }}" class="{{ $isCart ? 'active' : '' }}">
                                    <i class="fa fa-shopping-cart"></i> Cart
                                    <span class="badge badge-pill badge-danger">
                                        {{ count((array) session('cart')) }}
                                    </span>
                                </a>
                            </li>

                            @if (Route::has('login'))
                                @auth
                                    @if (Auth::user()->usertype == '1')
                                        {{-- Cek jika user adalah admin --}}
                                        <li>
                                            <a href="{{ url('/dashboard') }}"
                                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] {{ request()->is('dashboard*') ? 'active' : '' }}">
                                                Dashboard
                                            </a>
                                        </li>
                                    @endif

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown"
                                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <img class="avatar rounded-circle" alt="Image placeholder"
                                                src="{{ Auth::check() ? (Auth::user()->foto_profile ? asset('photo_profile/' . Auth::user()->foto_profile) : asset('default-profile.png')) : asset('default-profile.png') }}"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                                        Logout
                                                    </a>
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('login') }}"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                            Log in
                                        </a>
                                    </li>
                                @endauth
                            @endif
                        </ul>

                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <main>
        @yield('content')
    </main>

    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-xs-12">
                    <div class="right-text-content text-center">
                        <ul class="social-icons list-inline">
                            <li class="list-inline-item"><a href="#"><i class="fa fa-whatsapp"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-envelope"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="logo">
                        <a href="index.html"><img src="assets/images/Blura.png" alt="Blura"></a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12">
                    <div class="left-text-content text-center">
                        <p>© Copyright Klassy Cafe Co.
                            <br>Design: TemplateMo
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ***** Footer End ***** -->

    <!-- jQuery -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="assets/js/owl-carousel.js"></script>
    <script>
        const scrollLeftBtn = document.querySelector('.scroll-left');
        const scrollRightBtn = document.querySelector('.scroll-right');
        const productContainer = document.querySelector('.product-container');

        if (scrollLeftBtn && scrollRightBtn && productContainer) {
            function getProductWidth() {
                const card = document.querySelector('.product-card');
                return card ? card.offsetWidth + 20 : 320;
            }

            scrollLeftBtn.addEventListener('click', function () {
                productContainer.scrollBy({
                    left: -getProductWidth(),
                    behavior: 'smooth'
                });
            });

            scrollRightBtn.addEventListener('click', function () {
                productContainer.scrollBy({
                    left: getProductWidth(),
                    behavior: 'smooth'
                });
            });
        }
    </script>

    <script src="assets/js/accordions.js"></script>
    <script src="assets/js/datepicker.js"></script>
    <script src="assets/js/scrollreveal.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/imgfix.min.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/lightbox.js"></script>
    <script src="assets/js/isotope.js"></script>

    <!-- Global Init -->
    <script src="assets/js/custom.js"></script>
    <script>
        $(function () {
            var selectedClass = "";
            $("p").click(function () {
                selectedClass = $(this).attr("data-rel");
                $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("." + selectedClass).fadeOut();
                setTimeout(function () {
                    $("." + selectedClass).fadeIn();
                    $("#portfolio").fadeTo(50, 1);
                }, 500);
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.dropdown-toggle').dropdown();
        });
    </script>

</body>

</html>
