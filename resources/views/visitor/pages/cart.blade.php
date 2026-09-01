@extends('visitor.layouts.app')

@section('title', 'Shopping Cart - Power Veda Premium Wellness')
@section('meta_description', 'View your selected Power Veda Ayurvedic formulations, adjust quantities, and proceed to secure checkout for nationwide delivery.')
@section('meta_keywords', 'Power Veda, shopping cart, Ayurvedic health supplements, checkout')

@section('content')
<!-- 1. Breadcrumb Bar -->
<div class="product-breadcrumb-bar py-3 border-bottom" style="background-color: var(--body-bg);">
  <div class="container-custom">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0 small">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--primary-color);"><i class="bi bi-house-door me-1"></i>Home</a></li>
        <li class="breadcrumb-item active fw-bold" aria-current="page" style="color: var(--gold-color);">Shopping Cart</li>
      </ol>
    </nav>
  </div>
</div>

<!-- 2. Main Cart Page Section -->
<section class="cart-page-section py-5 bg-white" style="min-height: 60vh;">
  <div class="container-custom">

    <div class="section-header text-start mb-4">
      <span class="section-tag tag-wellness"><i class="bi bi-bag-check-fill me-1"></i> Your Selection</span>
      <h1 class="h2 fw-bold mb-1" style="color: var(--heading-color); font-family: var(--font-family);">
        Shopping Cart (<span class="badge-cart-val text-warning">0</span> <span id="cart-items-word">items</span>)
      </h1>
      <p class="text-muted small mb-0">Review your formulations and prepare your daily wellness routine.</p>
    </div>

    <!-- Dynamic Cart Layout -->
    <div id="cart-page-loaded-content">
      <div class="row g-4 align-items-start">

        <!-- Left Column: Cart Items List & Action Controls -->
        <div class="col-12 col-lg-8">
          
          <!-- Free Shipping Notification Bar -->
          <div class="p-3 rounded-3 mb-4 border d-flex align-items-center gap-3" id="free-shipping-meter-box" style="background: rgba(216, 188, 141, 0.12); border-color: rgba(216, 188, 141, 0.35) !important;">
            <i class="bi bi-truck text-warning fs-4"></i>
            <div class="flex-grow-1">
              <span class="d-block small fw-bold" id="free-shipping-msg" style="color: var(--heading-color);">
                Orders above ₹999 qualify for FREE Express Shipping across India!
              </span>
              <div class="progress mt-1" style="height: 6px; background-color: rgba(6, 30, 67, 0.08);">
                <div class="progress-bar bg-warning" id="free-shipping-progress" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>

          <!-- Desktop Items Table (Hidden on Mobile) -->
          <div class="d-none d-md-block border rounded-4 overflow-hidden mb-4 shadow-sm">
            <table class="table align-middle mb-0 cart-table">
              <thead style="background-color: var(--body-bg);">
                <tr>
                  <th scope="col" class="py-3 ps-4 text-uppercase small fw-bold" style="color: var(--heading-color); font-size: 0.76rem; letter-spacing: 0.8px;">Product</th>
                  <th scope="col" class="py-3 text-uppercase small fw-bold" style="color: var(--heading-color); font-size: 0.76rem; letter-spacing: 0.8px;">Price</th>
                  <th scope="col" class="py-3 text-center text-uppercase small fw-bold" style="color: var(--heading-color); font-size: 0.76rem; letter-spacing: 0.8px;">Quantity</th>
                  <th scope="col" class="py-3 text-end text-uppercase small fw-bold" style="color: var(--heading-color); font-size: 0.76rem; letter-spacing: 0.8px;">Subtotal</th>
                  <th scope="col" class="py-3 pe-4 text-end text-uppercase small fw-bold" style="color: var(--heading-color); font-size: 0.76rem; letter-spacing: 0.8px;">Remove</th>
                </tr>
              </thead>
              <tbody id="cart-page-table-tbody">
                <!-- Rendered dynamically by JavaScript -->
              </tbody>
            </table>
          </div>

          <!-- Mobile Items Cards Container (Visible on Mobile Only) -->
          <div class="d-md-none d-flex flex-column gap-3 mb-4" id="cart-page-mobile-cards">
            <!-- Rendered dynamically by JavaScript -->
          </div>

          <!-- Bottom Action Buttons -->
          <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 p-3 rounded-3 border bg-light">
            <a href="{{ route('home') }}#shop" class="btn btn-outline-secondary btn-sm">
              <i class="bi bi-arrow-left me-1"></i> Continue Shopping
            </a>
            <button type="button" class="btn btn-link text-danger btn-sm p-0 text-decoration-none" onclick="clearCart()">
              <i class="bi bi-trash3 me-1"></i> Clear Cart
            </button>
          </div>

        </div>

        <!-- Right Column: Order Summary Card -->
        <div class="col-12 col-lg-4">
          <div class="cart-summary-sticky-card p-4 rounded-4 border shadow-sm" style="background: #FAFAFA; border-color: rgba(216, 188, 141, 0.35) !important;">
            
            <h2 class="h5 fw-bold mb-3 pb-2 border-bottom" style="color: var(--heading-color); font-family: var(--font-family);">
              Order Summary
            </h2>

            <div class="d-flex justify-content-between align-items-center py-2 text-muted small">
              <span>Items Subtotal</span>
              <span class="fw-bold text-dark" id="cart-page-subtotal">₹0</span>
            </div>

            <div class="d-flex justify-content-between align-items-center py-2 text-muted small">
              <span>Estimated Shipping</span>
              <span class="fw-bold text-success" id="cart-page-shipping">FREE</span>
            </div>

            <div class="d-flex justify-content-between align-items-center py-2 text-muted small">
              <span>GST &amp; Taxes</span>
              <span class="text-success fw-semibold">Included</span>
            </div>

            <hr class="my-3" style="border-color: rgba(216, 188, 141, 0.4);">

            <div class="d-flex justify-content-between align-items-baseline mb-4">
              <div>
                <strong class="d-block text-dark fs-5" style="font-family: var(--font-family);">Total Amount</strong>
                <span class="small text-muted" style="font-size: 0.72rem;">(Inclusive of all taxes)</span>
              </div>
              <span class="fs-4 fw-bold" style="color: var(--heading-color);" id="cart-page-total">₹0</span>
            </div>

            <!-- Proceed to Checkout Button -->
            <button type="button" class="btn btn-primary w-100 py-3 fw-bold text-uppercase shadow-sm mb-3" onclick="handleInitiateCheckout()" id="cart-page-checkout-btn" style="letter-spacing: 0.6px;">
              <i class="bi bi-shield-lock-fill me-2"></i> PROCEED TO CHECKOUT
            </button>

            <!-- Trust Icons Under Summary -->
            <div class="row g-2 text-center pt-2">
              <div class="col-4">
                <div class="p-2 rounded bg-white border small">
                  <i class="bi bi-shield-check text-warning d-block fs-6 mb-1"></i>
                  <span class="d-block text-muted" style="font-size: 0.68rem; line-height: 1.2;">256-Bit SSL</span>
                </div>
              </div>
              <div class="col-4">
                <div class="p-2 rounded bg-white border small">
                  <i class="bi bi-patch-check-fill text-success d-block fs-6 mb-1"></i>
                  <span class="d-block text-muted" style="font-size: 0.68rem; line-height: 1.2;">100% Pure</span>
                </div>
              </div>
              <div class="col-4">
                <div class="p-2 rounded bg-white border small">
                  <i class="bi bi-truck text-primary d-block fs-6 mb-1"></i>
                  <span class="d-block text-muted" style="font-size: 0.68rem; line-height: 1.2;">Fast Delivery</span>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>

    <!-- Empty Cart State View (Shown when cart is empty) -->
    <div id="cart-page-empty-state" class="text-center py-5 d-none">
      <div class="cart-empty-box p-5 rounded-4 border mx-auto shadow-sm" style="max-width: 580px; background: #FAFAFA; border-color: rgba(216, 188, 141, 0.35) !important;">
        <div class="cart-empty-icon-wrap mx-auto mb-3" style="width: 80px; height: 80px; border-radius: 50%; background: rgba(216, 188, 141, 0.15); display: flex; align-items: center; justify-content: center;">
          <i class="bi bi-bag-x text-warning" style="font-size: 2.4rem;"></i>
        </div>
        <h2 class="h4 fw-bold mb-2" style="color: var(--heading-color); font-family: var(--font-family);">Your Shopping Bag is Empty</h2>
        <p class="text-muted small mb-4" style="line-height: 1.6;">
          You haven't added any sacred Vedic formulations to your cart yet. Explore our handcrafted remedies for strength, stamina, and cellular vitality.
        </p>
        <a href="{{ route('home') }}#shop" class="btn btn-primary px-4 py-3 fw-bold text-uppercase">
          <i class="bi bi-bag-plus me-2"></i> EXPLORE FORMULATIONS
        </a>
      </div>
    </div>

  </div>
</section>

<!-- 3. Recommended Formulations Section -->
@if(isset($recommendedProducts) && $recommendedProducts->count() > 0)
<section class="related-products-section py-5 bg-white border-top">
  <div class="container-custom">
    
    <div class="section-header text-center mb-4">
      <span class="section-tag">Holistic Wellness</span>
      <h2 class="section-title">Recommended For You</h2>
      <p class="section-desc">Popular Ayurvedic formulations crafted for holistic balance and endurance.</p>
    </div>

    <div class="row g-4">
      @foreach($recommendedProducts as $relProduct)
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="product-card" data-id="{{ $relProduct->id }}">
            <div class="product-img-wrapper">
              <a href="{{ route('product.detail', $relProduct->slug ?: $relProduct->id) }}">
                <img src="{{ $relProduct->photo_url }}" alt="{{ $relProduct->name }}" loading="lazy">
              </a>
              <span class="badge-natural">[ {{ $relProduct->badge ?: 'NATURAL' }} ]</span>
              <div class="product-card-actions">
                <a href="{{ route('product.detail', $relProduct->slug ?: $relProduct->id) }}" class="btn-card-action" title="View Details">
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>

            <div class="product-content">
              <h3 class="product-title">
                <a href="{{ route('product.detail', $relProduct->slug ?: $relProduct->id) }}" class="text-decoration-none text-reset">
                  {{ $relProduct->name }}
                </a>
              </h3>
              <p class="product-description">{{ $relProduct->detail }}</p>

              <div class="product-pricing-wrap">
                <span class="price-discounted">₹{{ number_format($relProduct->price, 0) }}</span>
                @if($relProduct->original_price)
                  <span class="price-original">₹{{ number_format($relProduct->original_price, 0) }}</span>
                @endif
                @if($relProduct->discount)
                  <span class="price-badge-gold">{{ $relProduct->discount }}</span>
                @endif
              </div>

              <button type="button" class="btn-add-cart" onclick="addToCart({{ $relProduct->id }})">
                <i class="bi bi-bag-plus"></i> ADD TO CART
              </button>
            </div>
          </div>
        </div>
      @endforeach
    </div>

  </div>
</section>
@endif
@endsection
