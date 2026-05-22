@push('styles')
    .nav-link-profile::after {
        display: none !important;
    }

    /* 2. Desktop Behavior: Hover to show menu */
    @media (min-width: 992px) {
        #profile-container:hover #desktop-dropdown {
            display: block;
            margin-top: 0;
        }
    }

    /* 3. Mobile Behavior: Hide the dropdown menu entirely 
       (User will be redirected to Profile page on click) */
    @media (max-width: 991.98px) {
        #desktop-dropdown {
            display: none !important;
        }
        
        /* Ensure the icon is easy to tap on mobile */
        .nav-link-profile {
            padding: 10px;
            display: block;
        }
    }
@endpush


<!-- Spinner Start -->
<div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status"></div>
</div>
<!-- Spinner End -->

<!-- Navbar start -->
        <div class="container-fluid fixed-top">
            <div class="container topbar bg-primary d-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <div class="top-info ps-2">
                        <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Thaltej, Ahmedabad - 380061</a></small>
                        <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">fruitable.contact@gmail.com</a></small>
                    </div>
                   <!--  <div class="top-link pe-2">
                        <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                        <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                        <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
                    </div> -->
                </div>
            </div>
            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                    <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('admin/images/vegmart_Logo.png')}}" style="height: 120px;" alt="logo"/></a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">
                            <a href="{{route('home')}}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                            <a href="{{route('shop')}}" class="nav-item nav-link {{ request()->routeIs('shop') ? 'active' : '' }}">Shop</a>
                            
                            <a href="{{route('contact')}}" class="nav-item nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                        </div>
                        <div class="d-flex m-3 me-0">
                           <a href="{{route('cart.show')}}" class="position-relative me-4 my-auto">
                                <i class="fa fa-shopping-bag fa-2x"></i>
                                @auth
                                @php $count = auth()->user()->cartItems()->sum('quantity'); @endphp
                                @if($count > 0)
                                    <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">
                                        {{ $count }}
                                    </span>
                                @endif
                            @endauth
                                </a>
                            <!-- Profile start -->
                             <div class="nav-item dropdown" id="profile-container">
    <a href="{{ route('profile') }}" class="my-auto nav-link-profile" id="profileIcon">
        <i class="fas fa-user fa-2x"></i>
    </a>
    
    {{-- Dropdown menu - Only shown on Desktop via CSS --}}
    <div class="dropdown-menu m-0 px-1 bg-secondary rounded-0 border-0 dropdown-menu-end" id="desktop-dropdown">
        @if (Auth::check())
            <a href="{{ route('profile') }}" class="dropdown-item {{ request()->routeIs('profile') ? 'active' : '' }}">My Account</a>
            <a href="{{ route('view.orders') }}" class="dropdown-item {{ request()->routeIs('view.orders') ? 'active' : '' }}">Your Orders</a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('logout') }}" class="dropdown-item">Log Out</a>
        @else
            <a href="{{ route('login') }}" class="dropdown-item {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
            <a href="{{ route('register') }}" class="dropdown-item {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
        @endif
    </div>
</div>
                            <!-- Profile end -->
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->

       