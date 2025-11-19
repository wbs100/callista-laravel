<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Callista LK - Premium Furniture & Interior Design</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    @stack('styles')
</head>

<body>

    <!-- Preloader -->
    <div class="preloader">
        <div class="loader">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    @include('public-site.partials.nav')

    @yield('content')

    @include('public-site.partials.footer')

    <!--sweetalert-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--jquery-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include cart/wishlist logic -->
    @include('public-site.partials.cw-logic')
    @include('public-site.partials.cw-logic2')

    @stack('scripts')

</body>
</html>