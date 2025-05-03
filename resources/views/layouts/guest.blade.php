<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/kaiadmin.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">

            {{-- Main Content --}}
            @yield('content')

            {{-- Auth Toggle --}}
            <div class="text-center mt-5">
                @if (Request::routeIs('login'))
                    <p class="small text-muted">Belum punya akun?
                        <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Daftar sekarang</a>
                    </p>
                @elseif (Request::routeIs('register'))
                    <p class="small text-muted">Sudah punya akun?
                        <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Login di sini</a>
                    </p>
                @endif
            </div>

            {{-- Back to publik --}}
            <div class="text-center mt-3">
                <a href="{{ url('/') }}"
                    class="btn btn-light border rounded-pill px-4 py-2 small text-muted shadow-sm">
                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Halaman Publik
                </a>
            </div>

        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    @stack('scripts')
</body>

</html>
