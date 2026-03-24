{{-- resources/views/layouts/navigation.blade.php --}}
<nav class="navbar-modern sticky-top" x-data="{ mobileMenuOpen: false }">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between w-100">
            <!-- Logo + brand -->
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2">
                    <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-capsule text-white fs-5"></i>
                    </div>
                    <span class="logo-text fw-bold">{{ config('app.name', 'MediSwift') }}</span>
                </a>
            </div>

            <!-- Desktop Navigation Links (hidden on mobile) -->
            <div class="d-none d-md-flex align-items-center gap-2">
                @auth
                    @role('admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link-custom text-decoration-none {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="nav-link-custom text-decoration-none {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam me-1"></i> Orders
                        </a>
                        <a href="{{ route('admin.riders.index') }}" class="nav-link-custom text-decoration-none {{ request()->routeIs('admin.riders.*') ? 'active' : '' }}">
                            <i class="bi bi-people me-1"></i> Riders
                        </a>
                    @endrole

                    @role('rider')
                        <a href="{{ route('rider.dashboard') }}" class="nav-link-custom text-decoration-none {{ request()->routeIs('rider.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-bicycle me-1"></i> Dashboard
                        </a>
                        <a href="{{ route('rider.orders.index') }}" class="nav-link-custom text-decoration-none {{ request()->routeIs('rider.orders.*') ? 'active' : '' }}">
                            <i class="bi bi-geo-alt me-1"></i> Deliveries
                        </a>
                    @endrole

                    <!-- Optional: common links for customer? extendable -->
                @endauth
            </div>

            <!-- Right Side: Auth / User Menu -->
            <div class="d-flex align-items-center gap-3">
                @auth
                    <div class="dropdown">
                        <button class="btn p-0 border-0 bg-transparent d-flex align-items-center gap-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="userMenuButton">
                            <div class="avatar-circle">
                                <span class="text-uppercase fw-semibold">{{ substr(Auth::user()->name, 0, 2) }}</span>
                            </div>
                            <span class="d-none d-md-inline fw-medium text-dark">{{ Auth::user()->name }}</span>
                            <i class="bi bi-chevron-down d-none d-md-inline text-muted small"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-modern" aria-labelledby="userMenuButton">
                            <li>
                                <a class="dropdown-item dropdown-item-modern" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person-circle me-2"></i> My Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <button type="submit" class="dropdown-item dropdown-item-modern text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Log out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary-custom btn-sm">Sign in</a>
                    </div>
                @endauth

                <!-- Mobile menu toggle button (hamburger) -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="d-md-none border-0 bg-transparent p-2 rounded-circle" style="width: 44px; height: 44px;" aria-label="Toggle menu">
                    <i class="bi bi-list fs-3" :class="mobileMenuOpen ? 'bi-x-lg' : 'bi-list'"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Responsive Menu (full-width bottom sheet style) -->
        <div x-show="mobileMenuOpen" x-transition.duration.200ms class="d-md-none mt-3 pt-3 border-top" style="display: none;">
            <div class="d-flex flex-column gap-2 pb-3">
                @auth
                    <!-- Mobile nav items with icons -->
                    @role('admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link-custom py-2 px-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i> Admin Dashboard
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="nav-link-custom py-2 px-3 {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam me-2"></i> Admin Orders
                        </a>
                    @endrole

                    @role('rider')
                        <a href="{{ route('rider.dashboard') }}" class="nav-link-custom py-2 px-3 {{ request()->routeIs('rider.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-bicycle me-2"></i> Rider Dashboard
                        </a>
                        <a href="{{ route('rider.orders.index') }}" class="nav-link-custom py-2 px-3 {{ request()->routeIs('rider.orders.*') ? 'active' : '' }}">
                            <i class="bi bi-geo-alt me-2"></i> My Deliveries
                        </a>
                    @endrole

                    <!-- divider + profile + logout -->
                    <hr class="my-2">
                    <a href="{{ route('profile.edit') }}" class="nav-link-custom py-2 px-3">
                        <i class="bi bi-person-circle me-2"></i> Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}" id="mobile-logout-form">
                        @csrf
                        <button type="submit" class="nav-link-custom w-100 text-start border-0 bg-transparent py-2 px-3 text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Log out
                        </button>
                    </form>
                @else
                    <div class="d-flex flex-column gap-2 p-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary-custom w-100 text-center">Login</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    // Prevent dropdown from staying open after click on mobile (optional)
    document.addEventListener('DOMContentLoaded', function() {
        const mobileLogoutForm = document.getElementById('mobile-logout-form');
        if (mobileLogoutForm) {
            mobileLogoutForm.addEventListener('submit', function(e) {
                // normal submit
            });
        }
    });
</script>
