<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chainjing | Portal Publik</title>

    <!-- Favicon -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body class="index-page">

    <!-- Header -->
    <!-- Header -->
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div
            class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
            <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
                <h1 class="sitename">Chainjing</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#daftar-ruu">Daftar RUU</a></li>
                    <li><a href="#voting">Voting Summary</a></li>
                    <li><a href="#revisi">Ringkasan Revisi</a></li>
                    <li><a href="#dana">Dana Publik</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            @guest
                <a class="btn btn-getstarted" href="{{ route('login') }}">Login</a>
            @else
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://eu.ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=250"
                            alt="Avatar" class="rounded-circle me-2 flex-shrink-0" width="36" height="36">
                        <span class="d-none d-sm-inline fw-semibold text-dark">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-3 border-0 mt-2 p-0 overflow-hidden"
                        aria-labelledby="userDropdown" style="min-width: 220px;">
                        <li class="bg-light px-3 py-3">
                            <div class="fw-semibold">{{ Auth::user()->name }}</div>
                            <div class="text-muted small">{{ Auth::user()->email }}</div>
                        </li>
                        <li>
                            <hr class="dropdown-divider m-0">
                        </li>
                        {{-- <li>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item py-2">
                                <i class="bi bi-person me-2 text-primary"></i> View Profile
                            </a>
                        </li> --}}
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2">
                                    <i class="bi bi-box-arrow-right me-2 text-danger"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>


            @endguest
        </div>
    </header>

    <!-- Main -->
    <main class="main pt-5 mt-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="footer" class="footer">
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="{{ url('/') }}"
                        class="logo d-flex align-items-center me-auto me-xl-0 mx-auto mx-xl-0">
                        <h1 class="sitename">Chainjing</h1>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Jl. Merdeka No. 1</p>
                        <p>Jakarta, Indonesia</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+62 812 3456 7890</span></p>
                        <p><strong>Email:</strong> <span>info@chainjing.id</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Menu</h4>
                    <ul>
                        <li><a href="#hero">Home</a></li>
                        <li><a href="#fitur">Fitur</a></li>
                        <li><a href="#ruu">RUU</a></li>
                        <li><a href="#revisi">Revisi</a></li>
                        <li><a href="#dana">Dana Publik</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Bantuan</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Kontak</a></li>
                        <li><a href="#">Ketentuan</a></li>
                        <li><a href="#">Privasi</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 footer-newsletter">
                    <h4>Langganan Info</h4>
                    <p>Dapatkan update terbaru dari Chainjing langsung ke email kamu.</p>
                    <form action="#" method="post" class="d-flex">
                        <input type="email" name="email" class="form-control" placeholder="Email kamu">
                        <input type="submit" value="Langganan" class="btn btn-primary ms-2">
                    </form>
                </div>
            </div>
        </div>

        <div class="container text-center mt-4">
            <p>© {{ date('Y') }} <strong class="sitename">Chainjing</strong>. All Rights Reserved</p>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')

</body>

</html>
