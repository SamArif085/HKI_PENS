<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        @if (Auth::user()->role === 1)
            <a href="{{ route('dashboardAdmin') }}" class="logo d-flex justify-content-center">
                <img src="{{ asset('img/Logo_PENS.png') }}" alt="logo-web">
                <span class="d-none d-lg-block" style="color: #5691cc">Sentra HKI</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        @endif
        @if (Auth::user()->role === 2)
            <a href="{{ route('dashboard') }}" class="logo d-flex justify-content-center">
                <img src="{{ asset('images/logo-web.jpg') }}" alt="logo-web" class="rounded float-start">
                <span class="d-none d-lg-block" style="color: #5691cc">HKI</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        @endif
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    {{-- <img src="img/profile-img.jpg" alt="Profile" class="rounded-circle"> --}}
                    <img src="{{ asset('img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                    {{-- <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span> --}}
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->name }}</h6>
                        <span>{{ Auth::user()->name }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->