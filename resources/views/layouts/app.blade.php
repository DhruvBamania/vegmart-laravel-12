<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title','Fruitables')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Google Web Fonts -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('theme/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('theme/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/style.css') }}" rel="stylesheet">

    @stack('styles')

</head>
<body>
    {{-- Navbar --}}
    @include('partials.nav')

    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Vendor JS --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="{{ asset('theme/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{ asset('theme/lib/lightbox/js/lightbox.min.js')}}"></script>
    <script src="{{ asset('theme/lib/owlcarousel/owl.carousel.min.js')}}"></script>

    {{-- Template Main JS --}}
    <script src="{{ asset('theme/js/main.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
