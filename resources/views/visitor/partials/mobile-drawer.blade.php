<!-- Luxury Mobile Navigation Drawer (Offcanvas) -->
<div class="offcanvas offcanvas-start mobile-nav-offcanvas" tabindex="-1" id="mobileNavDrawer"
  aria-labelledby="mobileNavDrawerLabel">

  <!-- Drawer Header -->
  <div class="mobile-nav-header">
    <div class="d-flex align-items-center">
      <img src="{{ asset('image/logo.png') }}" alt="Power Veda Logo" height="42">
    </div>
    <button type="button" class="mobile-nav-close-btn" data-bs-dismiss="offcanvas" aria-label="Close">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>

  <!-- Drawer Body -->
  <div class="offcanvas-body d-flex flex-column p-0">

    <!-- Streamlined Quick Action Strip (Cart) -->
    <a href="{{ route('cart.index') }}" class="mobile-cart-strip" data-bs-dismiss="offcanvas">
      <div class="cart-left">
        <div class="cart-icon-wrap">
          <i class="bi bi-bag"></i>
        </div>
        <div>
          <span class="cart-title">Your Shopping Cart</span>
          <span class="cart-subtitle"><span class="badge-cart-val">0</span> items in cart</span>
        </div>
      </div>
      <i class="bi bi-chevron-right arrow-icon" style="color: var(--gold-color);"></i>
    </a>

    <!-- Main Navigation Menu Links -->
    <ul class="mobile-nav-list">
      <li class="mobile-nav-item">
        <a class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}#home" data-bs-dismiss="offcanvas">
          <span class="nav-left">
            <i class="bi bi-house-door nav-icon"></i> Home
          </span>
          <i class="bi bi-chevron-right arrow-icon"></i>
        </a>
      </li>
      @if((isset($products) ? $products->count() : \App\Models\Product::count()) > 1)
        <li class="mobile-nav-item">
          <a class="mobile-nav-link" href="{{ route('home') }}#shop" data-bs-dismiss="offcanvas">
            <span class="nav-left">
              <i class="bi bi-bag nav-icon"></i> Shop Formulations
            </span>
            <i class="bi bi-chevron-right arrow-icon"></i>
          </a>
        </li>
      @endif
      <li class="mobile-nav-item">
        <a class="mobile-nav-link" href="{{ route('home') }}#why-us" data-bs-dismiss="offcanvas">
          <span class="nav-left">
            <i class="bi bi-shield-check nav-icon"></i> Why Power Veda
          </span>
          <i class="bi bi-chevron-right arrow-icon"></i>
        </a>
      </li>
      <li class="mobile-nav-item">
        <a class="mobile-nav-link" href="{{ route('home') }}#about" data-bs-dismiss="offcanvas">
          <span class="nav-left">
            <i class="bi bi-flower1 nav-icon"></i> Our Philosophy
          </span>
          <i class="bi bi-chevron-right arrow-icon"></i>
        </a>
      </li>
      <li class="mobile-nav-item">
        <a class="mobile-nav-link" href="{{ route('home') }}#reviews" data-bs-dismiss="offcanvas">
          <span class="nav-left">
            <i class="bi bi-star nav-icon"></i> Customer Reviews
          </span>
          <i class="bi bi-chevron-right arrow-icon"></i>
        </a>
      </li>
      <li class="mobile-nav-item">
        <a class="mobile-nav-link" href="{{ route('home') }}#contact" data-bs-dismiss="offcanvas">
          <span class="nav-left">
            <i class="bi bi-telephone nav-icon"></i> Contact &amp; Support
          </span>
          <i class="bi bi-chevron-right arrow-icon"></i>
        </a>
      </li>
    </ul>

    <!-- Divider -->
    <div class="mobile-nav-divider"></div>

    <!-- Account & Orders Section -->
    <div class="mobile-account-section">
      <div class="mobile-section-label">Account &amp; Orders</div>

      <!-- Guest: Login / Register Button (Shown when logged out) -->
      <div class="{{ auth()->check() ? 'd-none' : '' }}" id="mobile-guest-auth-block">
        <a class="mobile-nav-link mobile-login-btn" href="javascript:void(0)" data-bs-dismiss="offcanvas"
          data-bs-toggle="modal" data-bs-target="#authModal" id="mobile-auth-link">
          <span class="nav-left">
            <i class="bi bi-box-arrow-in-right nav-icon"></i> Login / Register
          </span>
          <i class="bi bi-chevron-right arrow-icon"></i>
        </a>
      </div>

      <!-- Logged-in User Block (Shown when logged in) -->
      <div class="{{ auth()->check() ? '' : 'd-none' }}" id="mobile-user-auth-block">
        <!-- User Badge Pill (Clickable directly to Account) -->
        <a href="{{ route('account') }}" class="mobile-user-badge mb-2 d-block text-decoration-none" title="View My Account">
          <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-person-circle fs-5" style="color: var(--gold-color);"></i>
              <div>
                <span class="d-block text-white fw-bold small text-truncate" style="max-width: 160px;" id="mobile-user-name">{{ auth()->check() ? auth()->user()->name : 'Member' }}</span>
                <span class="badge bg-warning text-dark" style="font-size: 0.65rem;" id="mobile-user-role">{{ auth()->check() ? auth()->user()->role : 'User' }}</span>
              </div>
            </div>
            <span class="badge" style="background: rgba(216, 188, 141, 0.2); color: var(--gold-color); font-size: 0.68rem;">View &rarr;</span>
          </div>
        </a>

        <ul class="mobile-nav-list p-0">
          <li class="mobile-nav-item">
            <a class="mobile-nav-link" href="{{ route('account') }}">
              <span class="nav-left">
                <i class="bi bi-person-badge nav-icon"></i> My Account Overview
              </span>
              <i class="bi bi-chevron-right arrow-icon"></i>
            </a>
          </li>
          <li class="mobile-nav-item" id="mobile-orders-item">
            <a class="mobile-nav-link" href="{{ route('account') }}?tab=orders">
              <span class="nav-left">
                <i class="bi bi-box-seam nav-icon"></i> My Orders &amp; Tracking
              </span>
              <i class="bi bi-chevron-right arrow-icon"></i>
            </a>
          </li>
          @if(auth()->check() && auth()->user()->isAdmin())
            <li class="mobile-nav-item" id="mobile-admin-item">
              <a class="mobile-nav-link" href="{{ route('admin.dashboard') }}">
                <span class="nav-left">
                  <i class="bi bi-speedometer2 nav-icon text-primary"></i> Admin Console
                </span>
                <i class="bi bi-chevron-right arrow-icon"></i>
              </a>
            </li>
          @else
            <li class="mobile-nav-item d-none" id="mobile-admin-item">
              <a class="mobile-nav-link" href="{{ route('admin.dashboard') }}">
                <span class="nav-left">
                  <i class="bi bi-speedometer2 nav-icon text-primary"></i> Admin Console
                </span>
                <i class="bi bi-chevron-right arrow-icon"></i>
              </a>
            </li>
          @endif
          <li class="mobile-nav-item" id="mobile-logout-item">
            <a class="mobile-nav-link text-danger" href="javascript:void(0)" onclick="handleLogout()">
              <span class="nav-left">
                <i class="bi bi-box-arrow-right nav-icon text-danger"></i> Sign Out (Logout)
              </span>
            </a>
          </li>
        </ul>
      </div>
    </div>

    <!-- Promo Badge Inside Mobile Menu -->
    <div class="mobile-nav-promo">
      <h6>⚡ 25% OFF SEASON SPECIAL</h6>
      <p>Use code <strong>POWER25</strong> on your order</p>
    </div>

    <!-- Drawer Footer -->
    <div class="mobile-nav-footer">
      <a href="tel:+918005558332" class="mobile-contact-btn">
        <i class="bi bi-telephone-fill"></i> +91 (800) 555-VEDA
      </a>
      <div class="mobile-social-row">
        <a href="https://facebook.com" class="social-icon-btn" target="_blank" rel="noopener noreferrer"
          aria-label="Facebook"><i class="bi bi-facebook"></i></a>
        <a href="https://instagram.com" class="social-icon-btn" target="_blank" rel="noopener noreferrer"
          aria-label="Instagram"><i class="bi bi-instagram"></i></a>
        <a href="https://youtube.com" class="social-icon-btn" target="_blank" rel="noopener noreferrer"
          aria-label="YouTube"><i class="bi bi-youtube"></i></a>
      </div>
    </div>

  </div>
</div>
