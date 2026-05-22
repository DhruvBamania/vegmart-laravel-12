<div class="container-scroller">
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo mr-5" href="{{route('dashboard')}}">
                <img src="{{asset('admin/images/vegmart_Logo.png')}}" class="mr-2 h-auto mt-4" alt="logo"/>
            </a>
            <a class="navbar-brand brand-logo-mini" href="{{route('dashboard')}}">
                <img src="{{asset('admin/images/vegmart_Logo.png')}}" style="width:40px; height:auto;" alt="logo"/>
            </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            {{-- Laptop Toggler: Stays exactly as you had it --}}
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
            
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                        <img src="{{ auth()->user()->image ? asset('uploads/profile_images/' . auth()->user()->image) : asset('uploads/profile_images/default-avatar.png') }}" 
                        alt="Admin Profile" 
                        class="rounded-circle" 
                        style="width: 40px; height: 40px; object-fit: cover;">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="{{ route('adminProfile') }}">
                            <i class="ti-settings text-primary"></i> Settings
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}">
                            <i class="ti-power-off text-primary"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>

            {{-- Android Toggler: Forced ID for direct targeting --}}
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" id="mobile-menu-toggle">
                <span class="icon-menu"></span>
            </button>
        </div>
    </nav>

    <div class="container-fluid page-body-wrapper">
        {{-- Added ID for direct JS targeting --}}
        <nav class="sidebar sidebar-offcanvas" id="sidebar-mobile">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products') }}">
                        <i class="icon-paper menu-icon"></i>
                        <span class="menu-title">Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customers') }}">
                        <i class="icon-head menu-icon"></i>
                        <span class="menu-title">Customers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders') }}">
                        <i class="icon-bag menu-icon"></i>
                        <span class="menu-title">Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact.us') }}">
                        <i class="fa-regular fa-envelope menu-icon"></i>
                        <span class="menu-title">Contact Us</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.discounts') }}">
                        <i class="fa-solid fa-ticket menu-icon"></i>
                        <span class="menu-title">Manage Discounts</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="icon-archive menu-icon"></i>
                        <span class="menu-title">My Profile</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="auth">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ route('adminProfile') }}"> Profile </a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{route('logout')}}"> Logout </a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
        
        <div class="main-panel">
            <div class="content-wrapper">
               
@push('styles')
<style>
    @media (max-width: 991px) {
        #sidebar-mobile {
            position: fixed !important;
            height: 100vh !important;
            top: 70px !important;
            bottom: 0;
            right: -250px !important; 
            width: 250px !important;
            transition: all 0.3s ease-in-out;
            z-index: 1050 !important;
            background: #ffffff;
            display: block !important;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
        }
        
        /* The class that slides it in */
        #sidebar-mobile.active {
            right: 0 !important;
        }

        .navbar .navbar-menu-wrapper {
            width: auto !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const sidebar = document.getElementById('sidebar-mobile');

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.classList.toggle('active');
            });
        }

        // Close sidebar if user clicks outside of it
        document.addEventListener('click', function(event) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickInsideBtn = toggleBtn.contains(event.target);

            if (!isClickInsideSidebar && !isClickInsideBtn && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
    });
</script>
@endpush