<!-- Sticky Header (Deep Navy #061E43) -->
<header class="site-header" id="siteHeader">
  <nav class="navbar" id="mainNavbar">
    <div class="container-custom w-100 d-flex align-items-center justify-content-between">

      <!-- Yuvar Dhan Logo & Tagline -->
      <div class="d-flex align-items-center">
        <a class="brand-logo" href="{{ route('home') }}" aria-label="Yuvar Dhan Home">
          <img src="{{ asset('image/logo.png') }}" alt="Yuvar Dhan Logo" width="220" height="50">
        </a>
        <div class="brand-tagline-wrap d-none d-sm-flex flex-column ps-3 ms-2 border-start"
          style="border-color: rgba(216, 188, 141, 0.4) !important;">
          <span class="brand-tagline-title"
            style="color: var(--gold-color); font-size: 0.76rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; line-height: 1.2;">
           Yuvar Dhan
          </span>
          <span class="brand-tagline-sub"
            style="color: var(--white-color); font-size: 0.84rem; font-weight: 800; letter-spacing: 0.6px; line-height: 1.15;">
            Strength &amp; Vitality
          </span>
        </div>
      </div>

      <!-- Desktop Navigation Links (Visible on Large Screens >= 992px) -->
      <div class="d-none d-lg-flex justify-content-center">
        <ul class="navbar-nav flex-row gap-1 mb-0">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}#home">Home</a>
          </li>
          @if((isset($products) ? $products->count() : \App\Models\Product::count()) > 1)
            <li class="nav-item">
              <a class="nav-link" href="{{ route('home') }}#shop">Shop</a>
            </li>
          @endif
          <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}#why-us">Why Yuvar Dhan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}#reviews">Reviews</a>
          </li>
          <li class="nav-item {{ auth()->check() ? '' : 'd-none' }}" id="nav-my-orders-item">
            <a class="nav-link {{ request()->routeIs('account') ? 'active' : '' }}" href="{{ route('account') }}?tab=orders">
              My Orders
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}#contact">Contact</a>
          </li>
        </ul>
      </div>

      <!-- Desktop Action Buttons (Account, Orders & Cart - visible on desktop) -->
      <div class="nav-actions d-none d-lg-flex align-items-center">

        <!-- Guest: Login / Register Text Button -->
        <button type="button" class="btn-header-auth {{ auth()->check() ? 'd-none' : '' }}" data-bs-toggle="modal" data-bs-target="#authModal"
          aria-label="Login or Register" title="Login / Register" id="desktop-account-btn">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login / Register</span>
        </button>

        <!-- Logged-in User Account Dropdown Wrapper -->
        <div class="dropdown d-inline-block {{ auth()->check() ? '' : 'd-none' }}" id="account-dropdown-wrapper">
          <!-- Logged-in User Dropdown Toggle with Name -->
          <button type="button" class="btn-header-auth dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
            id="desktop-user-dropdown-btn" title="My Account">
            <i class="bi bi-person-circle"></i>
            <span id="desktop-header-user-name">{{ auth()->check() ? explode(' ', auth()->user()->name)[0] : 'Account' }}</span>
          </button>

          <!-- User Account Menu -->
          <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 mt-2 p-2" id="desktop-user-dropdown-menu" style="min-width: 220px; border: 1px solid rgba(216, 188, 141, 0.4) !important;">
            <li class="px-3 py-2 border-bottom mb-2 bg-light rounded-2">
              <span class="d-block small text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Signed In As</span>
              <strong class="d-block text-dark text-truncate" id="dropdown-user-name">{{ auth()->check() ? auth()->user()->name : 'Member' }}</strong>
              <span class="badge bg-warning text-dark mt-1" style="font-size: 0.68rem;" id="dropdown-user-role">{{ auth()->check() ? auth()->user()->role : 'User' }}</span>
            </li>
            <li>
              <a class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2" href="{{ route('account') }}">
                <i class="bi bi-person-badge text-warning"></i> My Account Overview
              </a>
            </li>
            <li>
              <a class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2" href="{{ route('account') }}?tab=orders">
                <i class="bi bi-box-seam text-warning"></i> My Orders &amp; Tracking
              </a>
            </li>
            @if(auth()->check() && auth()->user()->isAdmin())
              <li id="dropdown-admin-item">
                <a class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                  <i class="bi bi-speedometer2 text-primary"></i> Admin Console
                </a>
              </li>
            @else
              <li id="dropdown-admin-item" class="d-none">
                <a class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                  <i class="bi bi-speedometer2 text-primary"></i> Admin Console
                </a>
              </li>
            @endif
            <li><hr class="dropdown-divider my-2"></li>
            <li>
              <button type="button" class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2 text-danger fw-semibold" onclick="handleLogout()">
                <i class="bi bi-box-arrow-right"></i> Sign Out (Logout)
              </button>
            </li>
          </ul>
        </div>

        <a href="{{ route('account') }}?tab=orders" class="action-btn-gold text-decoration-none {{ auth()->check() ? '' : 'd-none' }}"
          aria-label="My Orders" title="My Orders & Tracking" id="desktop-orders-btn">
          <i class="bi bi-box-seam"></i>
        </a>
        <a href="{{ route('cart.index') }}" class="action-btn-gold text-decoration-none"
          aria-label="Shopping Cart" title="Shopping Cart">
          <i class="bi bi-bag"></i>
          <span class="badge-counter badge-cart-val">0</span>
        </a>
      </div>

      <!-- Mobile Header Controls (Visible on Mobile/Tablet < 992px) -->
      <div class="d-flex d-lg-none align-items-center gap-2">
        <!-- Direct Account Link on Mobile (Logged In) -->
        <a href="{{ route('account') }}" class="action-btn-gold {{ auth()->check() ? '' : 'd-none' }}"
          aria-label="My Account" title="My Account" id="mobile-header-account-btn">
          <i class="bi bi-person-circle"></i>
        </a>

        <!-- Guest Login Modal Trigger on Mobile (Logged Out) -->
        <button type="button" class="action-btn-gold {{ auth()->check() ? 'd-none' : '' }}" data-bs-toggle="modal" data-bs-target="#authModal"
          aria-label="Sign In or Register" title="Sign In / Register" id="mobile-header-guest-btn">
          <i class="bi bi-person"></i>
        </button>

        <!-- Quick Cart Link on Mobile -->
        <a href="{{ route('cart.index') }}" class="action-btn-gold text-decoration-none"
          aria-label="Shopping Cart" title="Shopping Cart">
          <i class="bi bi-bag"></i>
          <span class="badge-counter badge-cart-val">0</span>
        </a>

        <!-- Luxury Offcanvas Mobile Drawer Trigger Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNavDrawer"
          aria-controls="mobileNavDrawer" aria-label="Open Mobile Navigation">
          <i class="bi bi-list fs-4"></i>
        </button>
      </div>

    </div>
  </nav>
</header>
