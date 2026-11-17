@extends('visitor.layouts.app')

@section('title', $product->meta_title ?: ($product->name . ' - Yuvar Dhan Strength & Vitality'))
@section('meta_description', $product->meta_detail ?: ($product->detail ?: 'Discover ' . $product->name . ' by Yuvar Dhan. 100% natural and pure Ayurvedic formulation for strength, vitality, and holistic wellness.'))
@section('meta_keywords', 'Yuvar Dhan, ' . $product->name . ', Ayurveda, wellness, vitality, strength, natural health supplement')

@push('styles')
<meta property="og:title" content="{{ $product->meta_title ?: $product->name }}">
<meta property="og:description" content="{{ $product->meta_detail ?: $product->detail }}">
<meta property="og:image" content="{{ $product->og_image_url }}">
<meta property="og:type" content="product">
<meta property="og:url" content="{{ url()->current() }}">
@endpush

@section('content')
<!-- 1. Breadcrumb Bar -->
<div class="product-breadcrumb-bar py-2 py-md-3 border-bottom" style="background-color: var(--body-bg);">
  <div class="container-custom">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0 small flex-nowrap overflow-hidden text-truncate">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--primary-color);"><i class="bi bi-house-door me-1"></i>Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('home') }}#shop" class="text-decoration-none" style="color: var(--primary-color);">Formulations</a></li>
        <li class="breadcrumb-item active text-truncate fw-bold" aria-current="page" style="color: var(--gold-color); max-width: 200px;">{{ $product->name }}</li>
      </ol>
    </nav>
  </div>
</div>

<!-- 2. Product Hero Showcase (2-Column Showcase) -->
<section class="product-showcase-section py-4 py-lg-5 bg-white">
  <div class="container-custom">
    <div class="row g-4 g-lg-5 align-items-start">

      <!-- Left Column: Image Gallery & Trust Highlights -->
      <div class="col-12 col-lg-6 mb-4 mb-lg-0">
        <div class="product-gallery-sticky position-relative">
          
          <!-- Main Product Display Card -->
          <div class="product-main-img-card rounded-4 p-2 p-sm-3 p-md-4 border position-relative overflow-hidden" style="background: #FAFAFA; border-color: rgba(216, 188, 141, 0.35) !important;">
            <span class="badge-natural position-absolute top-0 start-0 m-2 m-sm-3 m-md-4 z-1" style="font-size: 0.7rem;">
              [ {{ $product->badge ?: 'NATURAL' }} ]
            </span>
            @if($product->discount)
              <span class="price-badge-gold position-absolute top-0 end-0 m-2 m-sm-3 m-md-4 z-1 shadow-sm" style="font-size: 0.72rem;">
                {{ $product->discount }}
              </span>
            @endif

            <div class="product-img-zoom-wrap text-center py-2 py-md-3">
              <img src="{{ $product->photo_url }}" alt="{{ $product->name }}" class="img-fluid rounded-3 shadow-sm product-detail-main-img" id="mainProductImage">
            </div>
          </div>

          <!-- Trust Badges Under Image -->
          <div class="row g-2 mt-2 mt-md-3 text-center">
            <div class="col-6 col-sm-3">
              <div class="p-2 rounded bg-light border text-center h-100 product-trust-pill">
                <i class="bi bi-shield-fill-check text-warning d-block fs-6 mb-1"></i>
                <span class="d-block fw-bold text-truncate" style="font-size: 0.68rem; color: var(--heading-color);">100% Pure</span>
              </div>
            </div>
            <div class="col-6 col-sm-3">
              <div class="p-2 rounded bg-light border text-center h-100 product-trust-pill">
                <i class="bi bi-patch-check-fill text-success d-block fs-6 mb-1"></i>
                <span class="d-block fw-bold text-truncate" style="font-size: 0.68rem; color: var(--heading-color);">Lab Verified</span>
              </div>
            </div>
            <div class="col-6 col-sm-3">
              <div class="p-2 rounded bg-light border text-center h-100 product-trust-pill">
                <i class="bi bi-truck text-primary d-block fs-6 mb-1"></i>
                <span class="d-block fw-bold text-truncate" style="font-size: 0.68rem; color: var(--heading-color);">Fast Delivery</span>
              </div>
            </div>
            <div class="col-6 col-sm-3">
              <div class="p-2 rounded bg-light border text-center h-100 product-trust-pill">
                <i class="bi bi-arrow-counterclockwise text-warning d-block fs-6 mb-1"></i>
                <span class="d-block fw-bold text-truncate" style="font-size: 0.68rem; color: var(--heading-color);">30-Day Return</span>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Right Column: Product Info, Pricing & Buy Box -->
      <div class="col-12 col-lg-6">
        <div class="product-info-panel pt-2 pt-lg-0">
          
          <!-- Rating & Stock Status -->
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 product-rating-stock-bar">
            <div class="d-flex align-items-center flex-wrap gap-2">
              <div class="stars text-warning small">
                @for($i = 1; $i <= 5; $i++)
                  @if($product->rating >= $i)
                    <i class="bi bi-star-fill"></i>
                  @elseif($product->rating >= $i - 0.5)
                    <i class="bi bi-star-half"></i>
                  @else
                    <i class="bi bi-star text-muted opacity-50"></i>
                  @endif
                @endfor
              </div>
              <a href="#productTabs" onclick="switchProductTab('reviews')" class="small text-muted text-decoration-none fw-semibold">
                {{ number_format($product->rating, 1) }} ({{ $product->reviews_count }} reviews)
              </a>
            </div>

            <!-- Stock Pill -->
            @if($product->stock <= 0)
              <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill small">
                <i class="bi bi-x-circle me-1"></i> Out of Stock
              </span>
            @elseif($product->stock <= 20)
              <span class="badge bg-warning-subtle text-dark border border-warning px-2 py-1 rounded-pill small">
                <i class="bi bi-exclamation-circle me-1"></i> Only {{ $product->stock }} Left
              </span>
            @else
              <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill small">
                <i class="bi bi-check-circle me-1"></i> In Stock
              </span>
            @endif
          </div>

          <!-- Product Title -->
          <h1 class="h2 fw-bold mb-2 mb-md-3 product-page-title" style="color: var(--heading-color); font-family: var(--font-family); letter-spacing: -0.5px;">
            {{ $product->name }}
          </h1>

          <!-- Price Wrap -->
          <div class="product-price-section mb-3 mb-md-4 pb-3 border-bottom">
            <div class="d-flex align-items-baseline flex-wrap gap-2 gap-sm-3 mb-1">
              <span class="fs-2 fw-bold text-dark lh-1" style="color: var(--heading-color) !important;">₹{{ number_format($product->price, 0) }}</span>
              @if($product->original_price)
                <span class="fs-5 text-muted text-decoration-line-through">₹{{ number_format($product->original_price, 0) }}</span>
              @endif
              @if($product->discount)
                <span class="price-badge-gold fs-6">{{ $product->discount }}</span>
              @endif
            </div>
            <span class="d-block small text-muted mt-1">Inclusive of all taxes</span>
          </div>

          <!-- Short Description -->
          <p class="text-muted mb-3 mb-md-4" style="line-height: 1.7; font-size: 0.95rem;">
            {{ $product->detail ?: 'Sacred botanical extract handcrafted according to Vedic traditions, third-party lab tested, and 100% natural.' }}
          </p>

          <!-- Quick Benefits Checklist -->
          <div class="row g-2 mb-3 mb-md-4">
            <div class="col-12 col-sm-6">
              <div class="d-flex align-items-center gap-2 small text-muted">
                <i class="bi bi-check-circle-fill text-success flex-shrink-0"></i> <span>100% Vegetarian &amp; GMO-Free</span>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="d-flex align-items-center gap-2 small text-muted">
                <i class="bi bi-check-circle-fill text-success flex-shrink-0"></i> <span>Heavy-Metal Tested (Lead &amp; Mercury Free)</span>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="d-flex align-items-center gap-2 small text-muted">
                <i class="bi bi-check-circle-fill text-success flex-shrink-0"></i> <span>No Synthetic Binders or Fillers</span>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="d-flex align-items-center gap-2 small text-muted">
                <i class="bi bi-check-circle-fill text-success flex-shrink-0"></i> <span>Ayush &amp; GMP Standard Certified</span>
              </div>
            </div>
          </div>

          <!-- Purchase Action Controls Box -->
          <div class="p-3 p-md-4 rounded-3 border mb-3 mb-md-4 product-buy-box" style="background: #FAFAFA; border-color: rgba(216, 188, 141, 0.4) !important;">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
              <div class="d-flex align-items-center gap-2">
                <label for="productDetailQty" class="fw-bold small mb-0" style="color: var(--heading-color);">Quantity:</label>
                <div class="cart-qty-control" style="background: #FFFFFF;">
                  <button type="button" class="cart-qty-btn" onclick="adjustProductPageQty(-1)" aria-label="Decrease quantity">-</button>
                  <span class="cart-qty-val" id="productDetailQty">1</span>
                  <button type="button" class="cart-qty-btn" onclick="adjustProductPageQty(1)" aria-label="Increase quantity">+</button>
                </div>
              </div>
              <span class="small text-muted"><i class="bi bi-lightning-charge-fill text-warning"></i> Fast Dispatch</span>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex flex-column flex-sm-row gap-2">
              <button type="button" class="btn btn-primary flex-grow-1 py-3 fw-bold text-uppercase" onclick="addProductPageToCart()" style="letter-spacing: 0.5px;">
                <i class="bi bi-bag-plus-fill me-2"></i> ADD TO CART
              </button>
              <button type="button" class="btn btn-secondary flex-grow-1 py-3 fw-bold text-uppercase" onclick="buyNowProductPage()" style="letter-spacing: 0.5px;">
                <i class="bi bi-lightning-fill me-1"></i> BUY NOW
              </button>
            </div>
          </div>

          <!-- Formulation Fast Facts Strip -->
          <div class="row g-2 p-2 p-md-3 rounded bg-light border small text-muted formulation-facts-strip">
            <div class="col-12 col-sm-4 mb-2 mb-sm-0">
              <span class="d-block fw-bold" style="color: var(--heading-color); font-size: 0.74rem; text-transform: uppercase;">Dosage Protocol</span>
              <span class="d-block text-truncate">{{ $product->how_to_use ? \Illuminate\Support\Str::limit($product->how_to_use, 30) : '1-2 capsules daily' }}</span>
            </div>
            <div class="col-12 col-sm-4 border-sm-start ps-sm-3 mb-2 mb-sm-0">
              <span class="d-block fw-bold" style="color: var(--heading-color); font-size: 0.74rem; text-transform: uppercase;">Carrier (Anupana)</span>
              <span>Warm Milk / Water</span>
            </div>
            <div class="col-12 col-sm-4 border-sm-start ps-sm-3">
              <span class="d-block fw-bold" style="color: var(--heading-color); font-size: 0.74rem; text-transform: uppercase;">Extraction Type</span>
              <span>Full-Spectrum Potent</span>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<!-- 3. Comprehensive Product Details Tabs Section -->
<section class="product-tabs-section py-4 py-lg-5" id="productTabs" style="background-color: var(--body-bg); border-top: 1px solid rgba(216, 188, 141, 0.25);">
  <div class="container-custom">
    
    <!-- Tab Nav Headers -->
    <div class="product-tabs-header-wrap mb-3 mb-md-4">
      <ul class="nav nav-tabs product-nav-tabs border-0 d-flex justify-content-start flex-nowrap overflow-x-auto gap-2 pb-2" id="detailTabs" role="tablist">
        <li class="nav-item flex-shrink-0" role="presentation">
          <button class="nav-link product-tab-btn active" id="tab-overview-btn" data-bs-toggle="tab" data-bs-target="#pane-overview" type="button" role="tab" aria-controls="pane-overview" aria-selected="true">
            <i class="bi bi-info-circle me-1 me-sm-2 text-warning"></i> 1. Sacred Formulation
          </button>
        </li>
        <li class="nav-item flex-shrink-0" role="presentation">
          <button class="nav-link product-tab-btn" id="tab-howtouse-btn" data-bs-toggle="tab" data-bs-target="#pane-howtouse" type="button" role="tab" aria-controls="pane-howtouse" aria-selected="false">
            <i class="bi bi-clock-history me-1 me-sm-2 text-warning"></i> 2. How to Use &amp; Rituals
          </button>
        </li>
        <li class="nav-item flex-shrink-0" role="presentation">
          <button class="nav-link product-tab-btn" id="tab-faqs-btn" data-bs-toggle="tab" data-bs-target="#pane-faqs" type="button" role="tab" aria-controls="pane-faqs" aria-selected="false">
            <i class="bi bi-question-circle me-1 me-sm-2 text-warning"></i> 3. FAQs ({{ $product->activeFaqs->count() }})
          </button>
        </li>
        <li class="nav-item flex-shrink-0" role="presentation">
          <button class="nav-link product-tab-btn" id="tab-reviews-btn" data-bs-toggle="tab" data-bs-target="#pane-reviews" type="button" role="tab" aria-controls="pane-reviews" aria-selected="false">
            <i class="bi bi-star-fill me-1 me-sm-2 text-warning"></i> 4. Reviews ({{ $product->reviews->count() }})
          </button>
        </li>
      </ul>
    </div>

    <!-- Tab Panes Content -->
    <div class="tab-content bg-white p-3 p-sm-4 p-md-5 rounded-4 border shadow-sm" id="detailTabsContent" style="border-color: rgba(216, 188, 141, 0.35) !important;">

      <!-- Tab 1: Sacred Formulation & Highlights -->
      <div class="tab-pane fade show active" id="pane-overview" role="tabpanel" aria-labelledby="tab-overview-btn">
        <div class="row g-4 align-items-center">
          <div class="col-lg-8">
            <h3 class="h4 fw-bold mb-3" style="color: var(--heading-color);">Ayurvedic Wisdom &amp; Extraction Integrity</h3>
            <p class="text-muted" style="line-height: 1.8; font-size: 0.98rem;">
              {{ $product->detail }}
            </p>
            <p class="text-muted" style="line-height: 1.8; font-size: 0.98rem;">
              Yuvar Dhan formulations are crafted with single-source wildcrafted botanicals harvested sustainably from native Himalayan altitudes and fertile Ayurvedic belts. Using gentle low-temperature green extraction, we protect the full therapeutic spectrum of withanolides, curcuminoids, and essential botanical bio-markers.
            </p>

            <div class="row g-3 mt-3">
              <div class="col-md-6">
                <div class="p-3 rounded bg-light border">
                  <strong class="d-block small text-uppercase mb-1" style="color: var(--gold-color); letter-spacing: 0.5px;">Bio-Potency Standard</strong>
                  <span class="small text-muted">Standardized botanical purity with active biomarkers verified in every single batch.</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="p-3 rounded bg-light border">
                  <strong class="d-block small text-uppercase mb-1" style="color: var(--gold-color); letter-spacing: 0.5px;">Ethical Cleanse Guarantee</strong>
                  <span class="small text-muted">Zero artificial additives, zero synthetic binders, zero hidden steroids or stimulants.</span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="p-4 rounded-4 text-center border" style="background: linear-gradient(135deg, #061E43 0%, #0B3661 100%); color: #ffffff;">
              <i class="bi bi-award-fill fs-1 text-warning d-block mb-2"></i>
              <h4 class="h5 fw-bold text-white mb-2">100% Authentic Quality</h4>
              <p class="small text-white-50 mb-3">Certified laboratory tested for heavy metal purity and microbiological safety.</p>
              <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill">Vedic Purity Guaranteed</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Tab 2: Dynamic How to Use & Daily Rituals -->
      <div class="tab-pane fade" id="pane-howtouse" role="tabpanel" aria-labelledby="tab-howtouse-btn">
        <div class="mb-4">
          <h3 class="h4 fw-bold mb-2" style="color: var(--heading-color);">How to Use {{ $product->name }}</h3>
          <p class="text-muted">
            Follow this authentic 4-step Ayurvedic protocol to experience maximum bioavailability, cellular absorption, and vital transformation.
          </p>

          @if($product->how_to_use)
            <div class="p-3 rounded-3 mb-4 d-flex align-items-center gap-3" style="background: rgba(216, 188, 141, 0.15); border: 1px solid rgba(216, 188, 141, 0.4);">
              <i class="bi bi-info-circle-fill text-warning fs-4"></i>
              <div>
                <strong class="d-block small text-uppercase" style="color: var(--heading-color); letter-spacing: 0.5px;">General Dosage Guideline</strong>
                <span class="small text-dark">{{ $product->how_to_use }}</span>
              </div>
            </div>
          @endif
        </div>

        <!-- 4 Step Cards Grid -->
        <div class="row g-4 mb-4">
          @foreach($product->how_to_use_steps_list as $step)
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="ritual-step-card h-100">
                <div class="ritual-step-header d-flex justify-content-between align-items-center mb-3">
                  <span class="ritual-step-number">{{ $step['step_number'] ?? '01' }}</span>
                  <span class="ritual-step-badge">{{ $step['timing'] ?? 'Daily Routine' }}</span>
                </div>
                <div class="ritual-icon-box mb-3">
                  <i class="bi {{ $step['icon'] ?? 'bi-capsule' }}"></i>
                </div>
                <h4 class="ritual-step-title">{{ $step['title'] ?? 'Dosage & Measure' }}</h4>
                <p class="ritual-step-desc">{{ $step['description'] ?? '' }}</p>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Vedic Anupana Callout -->
        <div class="vedic-wisdom-box p-3 p-md-4 rounded-3 d-flex align-items-center gap-3">
          <div class="wisdom-icon-circle flex-shrink-0">
            <i class="bi bi-lightbulb-fill text-warning"></i>
          </div>
          <div>
            <strong class="d-block text-white small text-uppercase" style="letter-spacing: 1px; color: var(--gold-color) !important;">Vedic Anupana Wisdom</strong>
            <span class="text-white-50 small">
              Ayurveda emphasizes the concept of Anupana (the carrier liquid). Taking formulations with warm milk, warm water, or honey promotes optimal digestive agni and guides the botanical nutrients directly to bodily tissues.
            </span>
          </div>
        </div>
      </div>

      <!-- Tab 3: Dynamic Product FAQs -->
      <div class="tab-pane fade" id="pane-faqs" role="tabpanel" aria-labelledby="tab-faqs-btn">
        <div class="mb-4">
          <h3 class="h4 fw-bold mb-2" style="color: var(--heading-color);">Frequently Asked Questions</h3>
          <p class="text-muted">Common questions regarding {{ $product->name }} formulation, usage, and safety.</p>
        </div>

        @if($product->activeFaqs->count() > 0)
          <div class="accordion custom-faq-accordion" id="productPageFaqAccordion">
            @foreach($product->activeFaqs as $fIndex => $faq)
              <div class="accordion-item faq-accordion-item mb-3">
                <h3 class="accordion-header" id="prod-faq-heading-{{ $faq->id }}">
                  <button class="accordion-button faq-accordion-btn {{ $fIndex !== 0 ? 'collapsed' : '' }}" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#prod-faq-collapse-{{ $faq->id }}" 
                    aria-expanded="{{ $fIndex === 0 ? 'true' : 'false' }}" 
                    aria-controls="prod-faq-collapse-{{ $faq->id }}">
                    <span class="faq-q-number me-3">Q{{ $fIndex + 1 }}</span>
                    <span class="faq-q-text flex-grow-1">{{ $faq->question }}</span>
                  </button>
                </h3>
                <div id="prod-faq-collapse-{{ $faq->id }}" 
                  class="accordion-collapse collapse {{ $fIndex === 0 ? 'show' : '' }}" 
                  aria-labelledby="prod-faq-heading-{{ $faq->id }}" 
                  data-bs-parent="#productPageFaqAccordion">
                  <div class="accordion-body faq-accordion-body">
                    <p class="mb-0 text-muted" style="line-height: 1.7;">{{ $faq->answer }}</p>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <!-- Default Standard FAQs if none configured for this specific product -->
          <div class="accordion custom-faq-accordion" id="productPageFaqAccordion">
            <div class="accordion-item faq-accordion-item mb-3">
              <h3 class="accordion-header" id="prod-faq-def-1">
                <button class="accordion-button faq-accordion-btn" type="button" data-bs-toggle="collapse" data-bs-target="#prod-faq-def-c1" aria-expanded="true">
                  <span class="faq-q-number me-3">Q1</span>
                  <span class="faq-q-text">How long should I consume this formulation to see optimal benefits?</span>
                </button>
              </h3>
              <div id="prod-faq-def-c1" class="accordion-collapse collapse show" data-bs-parent="#productPageFaqAccordion">
                <div class="accordion-body faq-accordion-body">
                  <p class="mb-0 text-muted">We recommend consistent daily consumption for 60 to 90 continuous days. Natural Ayurvedic extracts work harmoniously with your metabolism for deep cellular rejuvenation.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item faq-accordion-item mb-3">
              <h3 class="accordion-header" id="prod-faq-def-2">
                <button class="accordion-button faq-accordion-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#prod-faq-def-c2" aria-expanded="false">
                  <span class="faq-q-number me-3">Q2</span>
                  <span class="faq-q-text">Is this product tested for heavy metals and safety?</span>
                </button>
              </h3>
              <div id="prod-faq-def-c2" class="accordion-collapse collapse" data-bs-parent="#productPageFaqAccordion">
                <div class="accordion-body faq-accordion-body">
                  <p class="mb-0 text-muted">Yes. Every single batch is tested by accredited third-party laboratories for heavy metals (Lead, Mercury, Arsenic) and microbiological purity.</p>
                </div>
              </div>
            </div>
          </div>
        @endif

        <!-- Consultation Banner -->
        <div class="faq-help-box mt-4 p-4 rounded-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
          <div>
            <h4 class="h6 fw-bold mb-1" style="color: var(--heading-color);">Need personalized Ayurvedic advice?</h4>
            <p class="small text-muted mb-0">Our dedicated wellness consultants are available to help customize your protocol.</p>
          </div>
          <a href="{{ route('home') }}#contact" class="btn btn-secondary btn-sm">
            <i class="bi bi-chat-dots-fill me-1"></i> Contact Wellness Team
          </a>
        </div>
      </div>

      <!-- Tab 4: Verified Customer Reviews -->
      <div class="tab-pane fade" id="pane-reviews" role="tabpanel" aria-labelledby="tab-reviews-btn">
        <div class="row g-4 align-items-center mb-4 pb-4 border-bottom">
          <div class="col-12 col-md-4 text-center border-md-end mb-3 mb-md-0 pb-3 pb-md-0 border-bottom border-md-bottom-0">
            <div class="display-4 fw-bold" style="color: var(--heading-color); font-family: var(--font-family);">{{ number_format($product->rating, 1) }}</div>
            <div class="stars text-warning fs-5 my-2">
              @for($i = 1; $i <= 5; $i++)
                @if($product->rating >= $i)
                  <i class="bi bi-star-fill"></i>
                @elseif($product->rating >= $i - 0.5)
                  <i class="bi bi-star-half"></i>
                @else
                  <i class="bi bi-star text-muted opacity-50"></i>
                @endif
              @endfor
            </div>
            <span class="small text-muted fw-semibold">Based on {{ $product->reviews_count }} ratings</span>
          </div>

          <div class="col-12 col-md-8 text-center text-md-start">
            <h4 class="h5 fw-bold mb-2" style="color: var(--heading-color);">Real Experiences from Real Customers</h4>
            <p class="small text-muted mb-0">
              Read verified feedback from individuals who have integrated {{ $product->name }} into their daily wellness journey.
            </p>
          </div>
        </div>

        <!-- Reviews List -->
        <div class="row g-3">
          @forelse($product->reviews as $review)
            <div class="col-12 col-md-6">
              <div class="review-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <div class="review-stars text-warning small">
                    @for($i = 1; $i <= 5; $i++)
                      @if($i <= $review->rating)
                        <i class="bi bi-star-fill"></i>
                      @else
                        <i class="bi bi-star text-muted opacity-50"></i>
                      @endif
                    @endfor
                  </div>
                  <span class="small text-muted">{{ $review->created_at ? $review->created_at->format('M d, Y') : 'Verified' }}</span>
                </div>
                <p class="review-quote small mb-3">"{{ $review->comment }}"</p>
                <div class="review-author mt-auto pt-2 border-top">
                  <img src="{{ $review->photo_url }}" alt="{{ $review->author }}" class="review-avatar" style="width: 38px; height: 38px;" loading="lazy">
                  <div>
                    <h5 class="review-name mb-0" style="font-size: 0.88rem;">{{ $review->author }}</h5>
                    <span class="review-verified small" style="font-size: 0.72rem;">
                      <i class="bi bi-patch-check-fill"></i> Verified Buyer &bull; {{ $review->location ?: 'India' }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12 text-center py-4 text-muted">
              <p class="mb-0">No direct customer reviews posted for this item yet. All batches are backed by our 30-day satisfaction guarantee.</p>
            </div>
          @endforelse
        </div>
      </div>

    </div>

  </div>
</section>

<!-- 4. Related Formulations Section -->
@if($relatedProducts->count() > 0)
<section class="related-products-section py-5 bg-white border-top">
  <div class="container-custom">
    
    <div class="section-header text-center mb-4">
      <span class="section-tag">Holistic Synergy</span>
      <h2 class="section-title">You May Also Benefit From</h2>
      <p class="section-desc">Formulations formulated to complement your daily health and vitality protocol.</p>
    </div>

    <div class="row g-4">
      @foreach($relatedProducts as $relProduct)
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

<!-- Product Schema JSON-LD for Google SEO Rich Snippets -->
@php
  $productSchema = [
    '@context' => 'https://schema.org/',
    '@type'    => 'Product',
    'name'     => $product->name,
    'image'    => [$product->photo_url],
    'description' => $product->detail ?: 'Pure Ayurvedic formulation by Yuvar Dhan.',
    'brand'    => [
      '@type' => 'Brand',
      'name'  => 'Yuvar Dhan'
    ],
    'offers'   => [
      '@type'         => 'Offer',
      'url'           => url()->current(),
      'priceCurrency' => 'INR',
      'price'         => (string) $product->price,
      'availability'  => $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
      'itemCondition' => 'https://schema.org/NewCondition'
    ],
    'aggregateRating' => [
      '@type'       => 'AggregateRating',
      'ratingValue' => (string) ($product->rating ?: 5.0),
      'reviewCount' => (string) max(1, $product->reviews_count ?: 10)
    ]
  ];
@endphp
<script type="application/ld+json">
  {!! json_encode($productSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

@push('scripts')
<script>
  let productDetailPageQty = 1;
  const currentProductObj = {
    id: {{ $product->id }},
    name: @json($product->name),
    price: {{ (float) $product->price }},
    originalPrice: {{ $product->original_price ? (float)$product->original_price : 'null' }},
    discount: @json($product->discount ?: ''),
    badge: @json($product->badge ?: 'NATURAL'),
    image: @json($product->photo_url),
    description: @json($product->detail ?: '')
  };

  function adjustProductPageQty(delta) {
    productDetailPageQty = Math.max(1, productDetailPageQty + delta);
    document.getElementById('productDetailQty').innerText = productDetailPageQty;
  }

  function addProductPageToCart() {
    if (typeof addToCart === 'function') {
      addToCart(currentProductObj, productDetailPageQty);
    }
  }

  function buyNowProductPage() {
    if (typeof addToCart === 'function') {
      addToCart(currentProductObj, productDetailPageQty);
      // Open Checkout Modal
      const checkoutModalEl = document.getElementById('checkoutModal');
      if (checkoutModalEl && typeof bootstrap !== 'undefined') {
        const modal = new bootstrap.Modal(checkoutModalEl);
        modal.show();
      }
    }
  }

  function switchProductTab(tabName) {
    const tabBtn = document.getElementById('tab-' + tabName + '-btn');
    if (tabBtn && typeof bootstrap !== 'undefined') {
      const tab = new bootstrap.Tab(tabBtn);
      tab.show();
    }
  }
</script>
@endpush
@endsection
