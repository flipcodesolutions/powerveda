@extends('visitor.layouts.app')

@section('title', 'Yuvar Dhan - Premium Wellness, Strength & Vitality')
@section('meta_description', 'Discover Yuvar Dhan: Premium wellness formulations designed to support strength, vitality, and a healthier lifestyle. 100% natural, pure, and trustworthy.')
@section('meta_keywords', 'Yuvar Dhan, wellness, strength, vitality, natural, Ayurvedic, health supplements, pure formulations')

@section('content')
<!-- 1. Hero Section (Deep Navy with Gold Accents) -->
<section class="hero-section" id="home">
  <div class="container-custom">
    <div class="row align-items-center">

      <div class="col-lg-7">
        <div class="hero-tag">
          <i class="bi bi-award-fill"></i> POWER &bull; STRENGTH &bull; WELLNESS &bull; VITALITY
        </div>
        <h1 class="hero-title">
          Strength &amp; <span class="gold-text">Vitality</span>
        </h1>
        <p class="hero-subtitle">
          Premium wellness products designed to support a stronger, healthier, and balanced lifestyle through pure
          natural botanicals and sacred Vedic science.
        </p>
        <div class="hero-cta-group">
          @if($products->count() > 1)
            <a href="#shop" class="btn btn-primary">
              <i class="bi bi-bag-check-fill"></i> SHOP NOW
            </a>
          @elseif($latestProduct)
            <button type="button" class="btn btn-primary" onclick="addToCart({{ $latestProduct->id }})">
              <i class="bi bi-bag-plus-fill"></i> ADD TO CART
            </button>
          @endif
          <a href="#about" class="btn btn-wellness">
            <i class="bi bi-flower1"></i> OUR PHILOSOPHY
          </a>
        </div>
        <div class="hero-trust-bar">
          <div class="hero-trust-item">
            <i class="bi bi-shield-fill-check"></i> 100% Certified Pure
          </div>
          <div class="hero-trust-item">
            <i class="bi bi-truck"></i> Express Nationwide Delivery
          </div>
          <div class="hero-trust-item">
            <i class="bi bi-patch-check-fill"></i> Third-Party Lab Verified
          </div>
        </div>
      </div>

      <div class="col-lg-5 d-none d-lg-block">
        @if($latestProduct)
          <div class="hero-product-card" data-product-id="{{ $latestProduct->id }}">
            <a href="{{ route('product.detail', $latestProduct->slug ?: $latestProduct->id) }}" class="d-block overflow-hidden rounded-3">
              <img src="{{ $latestProduct->photo_url }}" alt="{{ $latestProduct->name }}" class="hero-product-img" style="width: 100%; height: 260px; object-fit: cover; transition: transform 0.3s ease;">
            </a>
            <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
              <span class="badge-natural">[ {{ $latestProduct->badge ?: 'LATEST RELEASE' }} ]</span>
              <div class="stars text-warning small">
                @for($i = 1; $i <= 5; $i++)
                  @if($latestProduct->rating >= $i)
                    <i class="bi bi-star-fill"></i>
                  @elseif($latestProduct->rating >= $i - 0.5)
                    <i class="bi bi-star-half"></i>
                  @else
                    <i class="bi bi-star"></i>
                  @endif
                @endfor
              </div>
            </div>
            <h4 class="fw-bold mb-1" style="font-size: 1.15rem; color: var(--heading-color);">
              <a href="{{ route('product.detail', $latestProduct->slug ?: $latestProduct->id) }}" class="text-decoration-none text-reset">
                {{ $latestProduct->name }}
              </a>
            </h4>
            <p class="text-muted small mb-3 text-truncate">{{ $latestProduct->detail ?: 'Pure root extract designed for peak physical endurance and vitality.' }}</p>
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <span class="fw-bold fs-5" style="color: var(--heading-color);">₹{{ number_format($latestProduct->price, 0) }}</span>
                @if($latestProduct->original_price)
                  <span class="text-muted text-decoration-line-through small ms-1">₹{{ number_format($latestProduct->original_price, 0) }}</span>
                @endif
              </div>
              <div class="d-flex gap-2">
                <a href="{{ route('product.detail', $latestProduct->slug ?: $latestProduct->id) }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center justify-content-center" title="View Details">
                  <i class="bi bi-eye"></i>
                </a>
                <button class="btn btn-sm btn-primary" onclick="addToCart({{ $latestProduct->id }})">
                  <i class="bi bi-plus-lg"></i> Add
                </button>
              </div>
            </div>
          </div>
        @endif
      </div>

    </div>
  </div>
</section>

<!-- 2. Why Choose Yuvar Dhan (4 Feature Cards) -->
<section class="why-choose-section" id="why-us" aria-label="Why Choose Yuvar Dhan">
  <div class="container-custom">
    <div class="section-header">
      <span class="section-tag tag-wellness">Our Foundations</span>
      <h2 class="section-title">Why Choose Yuvar Dhan</h2>
      <p class="section-desc">Every Yuvar Dhan formulation is guided by four foundational pillars of authentic health and enduring vitality.</p>
    </div>

    <div class="row g-4">

      <!-- Strength -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="why-feature-card">
          <div class="why-icon-circle icon-gold">
            <i class="bi bi-lightning-charge"></i>
          </div>
          <h3 class="why-card-title">Strength</h3>
          <p class="why-card-desc">Quality products formulated with care to support physical resilience, stamina, and daily energy.</p>
        </div>
      </div>

      <!-- Natural -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="why-feature-card">
          <div class="why-icon-circle icon-green">
            <i class="bi bi-flower1"></i>
          </div>
          <h3 class="why-card-title">Natural</h3>
          <p class="why-card-desc">Focused on wellness and natural botanicals, strictly free from synthetic chemicals or artificial fillers.</p>
        </div>
      </div>

      <!-- Trusted -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="why-feature-card">
          <div class="why-icon-circle icon-silver">
            <i class="bi bi-shield-check"></i>
          </div>
          <h3 class="why-card-title">Trusted</h3>
          <p class="why-card-desc">A brand customers rely on for authentic Vedic integrity, precision extraction, and proven safety.</p>
        </div>
      </div>

      <!-- Vitality -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="why-feature-card">
          <div class="why-icon-circle icon-gold">
            <i class="bi bi-heart-pulse"></i>
          </div>
          <h3 class="why-card-title">Vitality</h3>
          <p class="why-card-desc">Holistic formulations designed to nourish mind, body, and soul for an active, healthier lifestyle.</p>
        </div>
      </div>

    </div>
  </div>
</section>

@if($products->count() > 1)
<!-- 3. Product Section (Unified Product Catalog) -->
<section class="products-section" id="shop">
  <div class="container-custom">

    <div class="section-header">
      <span class="section-tag">Pure Formulations</span>
      <h2 class="section-title">The Yuvar Dhan Range</h2>
      <p class="section-desc">Handcrafted formulas engineered for maximum bio-potency, third-party lab tested, and 100% natural.</p>
    </div>

    <!-- Search Toolbar -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom flex-wrap gap-3">
      <div class="fw-bold" style="color: var(--heading-color);">
        <i class="bi bi-grid-fill text-warning me-1"></i> All Formulations (<span id="formulation-count">{{ $products->count() }}</span> {{ $products->count() === 1 ? 'Item' : 'Items' }})
      </div>
      <div class="product-search-box">
        <i class="bi bi-search"></i>
        <input type="text" id="product-search" placeholder="Search formulations..." aria-label="Search products">
      </div>
    </div>

    <!-- Product Cards Grid (Dynamic from Database) -->
    <div class="row" id="products-grid">
      @forelse($products as $product)
        <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4 product-item-col"
          data-title="{{ $product->name }}" data-badge="{{ $product->badge ?: 'NATURAL' }}">
          <div class="product-card" data-id="{{ $product->id }}">
            <div class="product-img-wrapper">
              <a href="{{ route('product.detail', $product->slug ?: $product->id) }}">
                <img src="{{ $product->photo_url }}" alt="{{ $product->name }}" loading="lazy">
              </a>
              <span class="badge-natural">[ {{ $product->badge ?: 'NATURAL' }} ]</span>
              <div class="product-card-actions">
                <a href="{{ route('product.detail', $product->slug ?: $product->id) }}" class="btn-card-action" title="View Details">
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>

            <div class="product-content">
              <h3 class="product-title">
                <a href="{{ route('product.detail', $product->slug ?: $product->id) }}" class="text-decoration-none text-reset">
                  {{ $product->name }}
                </a>
              </h3>
              <p class="product-description">{{ $product->detail }}</p>

              <div class="product-rating">
                <span class="stars">
                  @for($i = 1; $i <= 5; $i++)
                    @if($product->rating >= $i)
                      <i class="bi bi-star-fill"></i>
                    @elseif($product->rating >= $i - 0.5)
                      <i class="bi bi-star-half"></i>
                    @else
                      <i class="bi bi-star"></i>
                    @endif
                  @endfor
                </span>
                <span class="text-muted small">({{ $product->reviews_count }})</span>
              </div>

              <div class="product-pricing-wrap">
                <span class="price-discounted">₹{{ number_format($product->price, 0) }}</span>
                @if($product->original_price)
                  <span class="price-original">₹{{ number_format($product->original_price, 0) }}</span>
                @endif
                @if($product->discount)
                  <span class="price-badge-gold">{{ $product->discount }}</span>
                @endif
              </div>

              <button type="button" class="btn-add-cart" onclick="addToCart({{ $product->id }})">
                <i class="bi bi-bag-plus"></i> ADD TO CART
              </button>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center py-5 text-muted">
          <p>No formulations currently available in catalog.</p>
        </div>
      @endforelse
    </div>

  </div>
</section>
@endif

@push('scripts')
<script>
  window.dbProducts = @json($products);
  if (window.dbProducts && window.dbProducts.length > 0) {
    if (typeof productsData !== 'undefined') {
      productsData.length = 0;
      window.dbProducts.forEach(p => {
        const photoUrl = p.photo_url || (p.photo ? (p.photo.startsWith('http') ? p.photo : (p.photo.startsWith('/') ? p.photo : '/' + p.photo)) : '/image/products/product-1.jpg');
        productsData.push({
          id: p.id,
          name: p.name,
          price: parseFloat(p.price) || 0,
          originalPrice: p.original_price ? parseFloat(p.original_price) : null,
          discount: p.discount || '',
          stock: p.stock,
          rating: parseFloat(p.rating) || 5.0,
          reviews: p.reviews_count || 0,
          badge: p.badge || 'NATURAL',
          image: photoUrl,
          description: p.detail || '',
          how_to_use: p.how_to_use || '',
          how_to_use_steps: p.how_to_use_steps_list || [],
          faqs: p.active_faqs || []
        });
      });
    }
  }

  function switchRitualProduct(productId) {
    // Switch tabs active state
    document.querySelectorAll('.btn-product-ritual-tab').forEach(btn => {
      btn.classList.remove('active');
    });
    const clickedBtn = document.querySelector(`[data-product-target="ritual-product-${productId}"]`);
    if (clickedBtn) clickedBtn.classList.add('active');

    // Switch panel visibility
    document.querySelectorAll('.ritual-product-panel').forEach(panel => {
      panel.classList.add('d-none');
      panel.classList.remove('active');
    });
    const activePanel = document.getElementById(`ritual-product-${productId}`);
    if (activePanel) {
      activePanel.classList.remove('d-none');
      activePanel.classList.add('active');
    }
  }
</script>
@endpush

<!-- 4. Promotional Section (Deep Navy + Royal Blue + Gold + White) -->
<section class="promotional-section" aria-label="Special Promotion">
  <div class="container-custom">
    <div class="promo-inner">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <span class="promo-tag">⭐ LIMITED TIME OFFER</span>
          <h2 class="promo-title">PREMIUM WELLNESS COLLECTION</h2>
          <p class="promo-subtitle">
            Discover products designed for strength, vitality and wellness. Enjoy exclusive seasonal pricing and free
            botanical gifts with your order.
          </p>

          <!-- Real-time Deal Countdown Timer -->
          <div class="countdown-box">
            <div class="countdown-unit">
              <span class="countdown-num" id="timer-hours">14</span>
              <span class="countdown-lbl">Hours</span>
            </div>
            <div class="countdown-unit">
              <span class="countdown-num" id="timer-minutes">30</span>
              <span class="countdown-lbl">Mins</span>
            </div>
            <div class="countdown-unit">
              <span class="countdown-num" id="timer-seconds">00</span>
              <span class="countdown-lbl">Secs</span>
            </div>
          </div>

          <div class="d-flex flex-wrap align-items-center gap-3">
            @if($products->count() > 1)
              <a href="#shop" class="btn btn-primary">
                <i class="bi bi-lightning-fill"></i> EXPLORE NOW
              </a>
            @elseif($latestProduct)
              <button type="button" class="btn btn-primary" onclick="addToCart({{ $latestProduct->id }})">
                <i class="bi bi-bag-plus-fill"></i> ORDER NOW
              </button>
            @endif
            <a href="#about" class="btn btn-outline-gold">
              OUR PHILOSOPHY
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 5. About Yuvar Dhan Section (White Background with Subtle Gold/Green Accents) -->
<section class="about-section" id="about">
  <div class="container-custom">
    <div class="row align-items-center g-5">

      <div class="col-lg-6">
        <div class="about-visual-wrap">
          <img src="{{ asset('image/about.jpg') }}" alt="Yuvar Dhan Botanical Preparation & Clinical Heritage" class="about-img" loading="lazy">
          <div class="about-heritage-badge">
            <div class="about-badge-number">2006</div>
            <div class="about-badge-label">Ayurvedic Heritage</div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <span class="section-tag tag-wellness"><i class="bi bi-flower1 me-1"></i> About Yuvar Dhan</span>
        <h2 class="section-title text-start mb-3">Traditional Ayurveda. <span class="gold-text">Modern Men’s Wellness.</span></h2>
        <p class="text-muted mb-3" style="font-size: 1rem; line-height: 1.7;">
          <strong>Yuvar Dhan</strong> is a specialized men’s wellness brand committed to supporting modern men with thoughtfully developed Ayurvedic wellness solutions inspired by traditional Indian knowledge and contemporary lifestyle needs.
        </p>
        <p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.65;">
          Yuvar Dhan is an <strong>associated wellness brand of M.C.D.C.R. Vaidraj Disease Eradication Center</strong>, an established Ayurvedic healthcare organization serving patients since <strong>2006</strong>. This association brings decades of patient care, wellness consultation, and clinical formulation expertise directly to men's health.
        </p>

        <div class="row g-2 mb-4">
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-2 p-2 rounded bg-light border">
              <i class="bi bi-heart-pulse-fill text-warning fs-5"></i>
              <span class="small fw-semibold text-dark">Overall Vitality &amp; Energy</span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-2 p-2 rounded bg-light border">
              <i class="bi bi-peace-fill text-success fs-5"></i>
              <span class="small fw-semibold text-dark">Stress &amp; Lifestyle Balance</span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-2 p-2 rounded bg-light border">
              <i class="bi bi-lightning-charge-fill text-primary fs-5"></i>
              <span class="small fw-semibold text-dark">Strength &amp; Performance</span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-2 p-2 rounded bg-light border">
              <i class="bi bi-box-seam-fill text-secondary fs-5"></i>
              <span class="small fw-semibold text-dark">Discreet &amp; Pure Experience</span>
            </div>
          </div>
        </div>

        <div class="p-3 mb-4 rounded-3" style="background: rgba(216, 188, 141, 0.12); border-left: 3px solid var(--gold-color);">
          <p class="small text-muted mb-0">
            <strong class="text-dark"><i class="bi bi-shield-check text-warning me-1"></i> Business Association:</strong>
            Yuvar Dhan operates in association with M.C.D.C.R. Vaidraj Disease Eradication Center. Certain payments, invoices, and operational services may be processed under authorized accounts of M.C.D.C.R. Vaidraj.
          </p>
        </div>

        <div class="d-flex flex-wrap gap-3">
          <a href="#shop" class="btn btn-secondary">
            DISCOVER PRODUCTS <i class="bi bi-arrow-right ms-1"></i>
          </a>
          <a href="{{ route('about') }}" class="btn btn-outline-dark">
            READ OUR FULL STORY <i class="bi bi-file-earmark-person ms-1"></i>
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- 6. Customer Reviews / Testimonials Slider Section -->
<section class="reviews-section" id="reviews" aria-label="Customer Testimonials">
  <div class="container-custom">

    <div class="section-header position-relative">
      <span class="section-tag">Verified Experiences</span>
      <h2 class="section-title">Trusted by Thousands Across the Country</h2>
      <p class="section-desc">Read genuine experiences from individuals who have integrated Yuvar Dhan into their daily wellness journey.</p>
    </div>

    @if($reviews->count() > 0)
      <div class="testimonials-slider-wrapper position-relative">
        
        <!-- Navigation Arrow Buttons -->
        <button type="button" class="testimonial-arrow-btn prev-btn" id="testimonial-prev" aria-label="Previous Testimonial">
          <i class="bi bi-chevron-left"></i>
        </button>
        <button type="button" class="testimonial-arrow-btn next-btn" id="testimonial-next" aria-label="Next Testimonial">
          <i class="bi bi-chevron-right"></i>
        </button>

        <!-- Slider Track Container -->
        <div class="testimonials-slider-track-container" id="testimonials-track-container">
          <div class="testimonials-slider-track" id="testimonials-slider-track">
            @foreach($reviews as $review)
              <div class="testimonial-slide-item">
                <div class="review-card h-100 d-flex flex-column justify-content-between">
                  <div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <div class="review-stars text-warning mb-0">
                        @for($i = 1; $i <= 5; $i++)
                          @if($i <= $review->rating)
                            <i class="bi bi-star-fill"></i>
                          @else
                            <i class="bi bi-star text-muted opacity-50"></i>
                          @endif
                        @endfor
                      </div>
                      <span class="testimonial-quote-icon">
                        <i class="bi bi-quote"></i>
                      </span>
                    </div>

                    <p class="review-quote">
                      "{{ $review->comment }}"
                    </p>
                  </div>

                  <div class="review-author mt-3 pt-3 border-top" style="border-color: rgba(6, 30, 67, 0.08) !important;">
                    <img src="{{ $review->photo_url }}" alt="{{ $review->author }}" class="review-avatar" loading="lazy">
                    <div>
                      <h4 class="review-name">{{ $review->author }}</h4>
                      <span class="review-verified">
                        <i class="bi bi-patch-check-fill"></i> Verified Buyer &bull; {{ $review->location ?: 'India' }}
                      </span>
                      @if($review->product)
                        <div class="small text-muted mt-1">
                          <i class="bi bi-bag-check text-warning me-1"></i>{{ $review->product->name }}
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Slider Pagination Dots -->
        <div class="testimonials-dots-container d-flex justify-content-center align-items-center gap-2 mt-4" id="testimonials-dots"></div>

      </div>
    @else
      <div class="col-12 text-center py-4 text-muted">
        <p>No customer reviews available yet.</p>
      </div>
    @endif

  </div>
</section>

<!-- 8. Frequently Asked Questions (Dynamic Accordion) -->
<section class="faqs-section" id="faqs" aria-label="Frequently Asked Questions">
  <div class="container-custom">
    
    <div class="section-header text-center mb-5">
      <span class="section-tag"><i class="bi bi-patch-question-fill me-1"></i> Answers &amp; Clarity</span>
      <h2 class="section-title">Frequently Asked Questions</h2>
      <p class="section-desc" style="max-width: 680px; margin: 0 auto;">
        Find clear answers about our authentic Vedic formulations, lab certifications, dosage protocols, and fast express shipping.
      </p>
    </div>

    @if($faqs->count() > 0)
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
          
          <div class="accordion custom-faq-accordion" id="powervedaFaqAccordion">
            @foreach($faqs as $fIndex => $faq)
              <div class="accordion-item faq-accordion-item mb-3">
                <h3 class="accordion-header" id="faq-heading-{{ $faq->id }}">
                  <button class="accordion-button faq-accordion-btn {{ $fIndex !== 0 ? 'collapsed' : '' }}" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#faq-collapse-{{ $faq->id }}" 
                    aria-expanded="{{ $fIndex === 0 ? 'true' : 'false' }}" 
                    aria-controls="faq-collapse-{{ $faq->id }}">
                    <span class="faq-q-number me-3">Q{{ $fIndex + 1 }}</span>
                    <span class="faq-q-text flex-grow-1">{{ $faq->question }}</span>
                    @if($faq->product)
                      <span class="badge bg-light text-secondary border small ms-2 d-none d-md-inline-block">{{ $faq->product->name }}</span>
                    @endif
                  </button>
                </h3>
                <div id="faq-collapse-{{ $faq->id }}" 
                  class="accordion-collapse collapse {{ $fIndex === 0 ? 'show' : '' }}" 
                  aria-labelledby="faq-heading-{{ $faq->id }}" 
                  data-bs-parent="#powervedaFaqAccordion">
                  <div class="accordion-body faq-accordion-body">
                    <p class="mb-0 text-muted" style="line-height: 1.7;">{{ $faq->answer }}</p>
                    @if($faq->product)
                      <div class="mt-3 pt-2 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <span class="small text-muted"><i class="bi bi-tag-fill text-warning me-1"></i>Related Formulation: <strong>{{ $faq->product->name }}</strong></span>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addToCart({{ $faq->product->id }})">
                          <i class="bi bi-bag-plus"></i> Quick Add (₹{{ number_format($faq->product->price, 0) }})
                        </button>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <!-- FAQ Still Have Questions Banner -->
          <div class="faq-help-box mt-4 p-4 rounded-3 d-flex flex-wrap align-items-center justify-content-between gap-3 text-center text-md-start">
            <div class="d-flex align-items-center gap-3 mx-auto mx-md-0">
              <div class="faq-help-icon">
                <i class="bi bi-headset text-warning fs-3"></i>
              </div>
              <div>
                <h4 class="h6 fw-bold mb-1" style="color: var(--heading-color);">Still have questions about dosage or formulations?</h4>
                <p class="small text-muted mb-0">Our certified Ayurvedic consultants are here to guide your wellness routine.</p>
              </div>
            </div>
            <a href="#contact" class="btn btn-secondary mx-auto mx-md-0">
              <i class="bi bi-chat-dots-fill me-1"></i> Consult an Expert
            </a>
          </div>

        </div>
      </div>

      <!-- JSON-LD SEO FAQ Schema -->
      @php
        $faqSchema = [
          '@context' => 'https://schema.org',
          '@type'    => 'FAQPage',
          'mainEntity' => $faqs->map(function($f) {
            return [
              '@type' => 'Question',
              'name'  => $f->question,
              'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => $f->answer,
              ]
            ];
          })->toArray()
        ];
      @endphp
      <script type="application/ld+json">
        {!! json_encode($faqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
      </script>
    @else
      <div class="text-center py-4 text-muted">
        <p>No frequently asked questions published yet.</p>
      </div>
    @endif

  </div>
</section>

<!-- 9. Contact Us Section (Deep Navy with Gold Accents) -->
<section class="contact-section" id="contact" aria-label="Contact Yuvar Dhan">
  <div class="container-custom">

    <div class="section-header text-center mb-5">
      <span class="section-tag">Get in Touch</span>
      <h2 class="section-title text-white">We'd Love to Hear From You</h2>
      <p class="section-desc" style="color: var(--silver-color); max-width: 650px; margin: 0 auto;">
        Have questions about our sacred formulations, order inquiries, or holistic wellness advice? Reach out to our dedicated Vedic wellness consultants.
      </p>
    </div>

    <div class="row g-4 align-items-stretch">
      
      <!-- Contact Info Cards Column -->
      <div class="col-12 col-lg-5 d-flex">
        <div class="contact-info-panel w-100 h-100 d-flex flex-column justify-content-between p-4 p-md-5">
          <div>
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(216, 188, 141, 0.15); border: 1px solid rgba(216, 188, 141, 0.3);">
              <i class="bi bi-headset text-warning"></i>
              <span class="small fw-bold text-uppercase" style="color: var(--gold-color); letter-spacing: 1px;">Customer Care</span>
            </div>

            <h3 class="h4 fw-bold text-white mb-2">Holistic Support &amp; Consultation</h3>
            <p class="small mb-4" style="color: var(--silver-color); line-height: 1.6;">
              Our Ayurvedic specialists and support team are available Monday through Saturday to answer questions, guide your routine, or assist with your orders.
            </p>

            <div class="contact-item-box mb-3 d-flex align-items-center gap-3 p-3 rounded" style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(216, 188, 141, 0.25);">
              <div class="contact-icon-circle">
                <i class="bi bi-geo-alt-fill text-warning"></i>
              </div>
              <div>
                <span class="contact-item-label d-block text-uppercase fw-bold" style="color: var(--gold-color); font-size: 0.75rem; letter-spacing: 1px; margin-bottom: 2px;">Location</span>
                <span class="text-white small fw-medium">108 Lotus Wellness Way, Green Valley, Mumbai 400001</span>
              </div>
            </div>

            <div class="contact-item-box mb-3 d-flex align-items-center gap-3 p-3 rounded" style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(216, 188, 141, 0.25);">
              <div class="contact-icon-circle">
                <i class="bi bi-telephone-fill text-warning"></i>
              </div>
              <div>
                <span class="contact-item-label d-block text-uppercase fw-bold" style="color: var(--gold-color); font-size: 0.75rem; letter-spacing: 1px; margin-bottom: 2px;">Direct Helpline</span>
                <a href="tel:+918005558332" class="text-white small fw-medium text-decoration-none">+91 (800) 555-VEDA &bull; +91 98765 43210</a>
              </div>
            </div>

            <div class="contact-item-box mb-3 d-flex align-items-center gap-3 p-3 rounded" style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(216, 188, 141, 0.25);">
              <div class="contact-icon-circle">
                <i class="bi bi-envelope-fill text-warning"></i>
              </div>
              <div>
                <span class="contact-item-label d-block text-uppercase fw-bold" style="color: var(--gold-color); font-size: 0.75rem; letter-spacing: 1px; margin-bottom: 2px;">Email Inquiries</span>
                <a href="mailto:support@powerveda.com" class="text-white small fw-medium text-decoration-none">support@powerveda.com</a>
              </div>
            </div>
          </div>

          <div class="pt-3 mt-auto border-top" style="border-color: rgba(255, 255, 255, 0.12) !important;">
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-patch-check-fill text-success fs-5"></i>
              <span class="small fw-semibold text-white">Guaranteed response within 24 business hours</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Form Column -->
      <div class="col-12 col-lg-7 d-flex">
        <div class="contact-form-card w-100 h-100 d-flex flex-column justify-content-between p-4 p-md-5">
          <div>
            <h3 class="h4 fw-bold mb-2" style="color: var(--heading-color);">Send Us a Message</h3>
            <p class="small text-muted mb-4">Please fill out all required fields below and our team will get back to you promptly.</p>

            <div id="contact-alert" class="alert alert-danger d-none py-2 px-3 small mb-4" role="alert"></div>
            <div id="contact-success-alert" class="alert alert-success d-none py-3 px-4 mb-4" role="alert"></div>
          </div>

          <form id="contact-form" action="{{ route('contact.submit') }}" method="POST" onsubmit="handleContactSubmit(event)" class="d-flex flex-column justify-content-between flex-grow-1" novalidate>
            @csrf

            <div class="row g-3">
              <!-- Name -->
              <div class="col-12 col-md-6">
                <label for="contact-name" class="form-label small fw-bold text-uppercase" style="color: var(--heading-color); font-size: 0.78rem;">Full Name <span class="text-danger">*</span></label>
                <div class="contact-input-wrap">
                  <i class="bi bi-person input-icon"></i>
                  <input type="text" class="form-control contact-input" id="contact-name" name="name" placeholder="e.g. Rahul Sharma" autocomplete="name">
                </div>
                <div class="contact-error-text d-none" id="contact-name-error"></div>
              </div>

              <!-- Email -->
              <div class="col-12 col-md-6">
                <label for="contact-email" class="form-label small fw-bold text-uppercase" style="color: var(--heading-color); font-size: 0.78rem;">Email Address <span class="text-danger">*</span></label>
                <div class="contact-input-wrap">
                  <i class="bi bi-envelope input-icon"></i>
                  <input type="email" class="form-control contact-input" id="contact-email" name="email" placeholder="e.g. rahul@example.com" autocomplete="email">
                </div>
                <div class="contact-error-text d-none" id="contact-email-error"></div>
              </div>

              <!-- Contact Number -->
              <div class="col-12 col-md-6">
                <label for="contact-phone" class="form-label small fw-bold text-uppercase" style="color: var(--heading-color); font-size: 0.78rem;">Contact Number <span class="text-danger">*</span></label>
                <div class="contact-input-wrap">
                  <i class="bi bi-telephone input-icon"></i>
                  <input type="tel" class="form-control contact-input" id="contact-phone" name="contactno" placeholder="e.g. +91 98765 43210" autocomplete="tel">
                </div>
                <div class="contact-error-text d-none" id="contact-phone-error"></div>
              </div>

              <!-- Subject -->
              <div class="col-12 col-md-6">
                <label for="contact-subject" class="form-label small fw-bold text-uppercase" style="color: var(--heading-color); font-size: 0.78rem;">Subject <span class="text-danger">*</span></label>
                <div class="contact-input-wrap">
                  <i class="bi bi-chat-left-dots input-icon"></i>
                  <input type="text" class="form-control contact-input" id="contact-subject" name="subject" placeholder="e.g. Dosage inquiry / Order assistance">
                </div>
                <div class="contact-error-text d-none" id="contact-subject-error"></div>
              </div>

              <!-- Message -->
              <div class="col-12">
                <label for="contact-message" class="form-label small fw-bold text-uppercase" style="color: var(--heading-color); font-size: 0.78rem;">Your Message <span class="text-danger">*</span></label>
                <div class="contact-input-wrap textarea-wrap">
                  <i class="bi bi-pencil-square input-icon" style="top: 18px;"></i>
                  <textarea class="form-control contact-input" id="contact-message" name="messages" rows="3" placeholder="Please write your questions or inquiry in detail..." style="padding-top: 14px; min-height: 105px;"></textarea>
                </div>
                <div class="contact-error-text d-none" id="contact-message-error"></div>
              </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-4">
              <button type="submit" class="btn btn-primary w-100 py-3 fw-bold text-uppercase" id="contact-submit-btn" style="letter-spacing: 1px;">
                <span class="spinner-border spinner-border-sm me-2 d-none" id="contact-spinner"></span>
                <i class="bi bi-send-fill me-2"></i> SUBMIT INQUIRY
              </button>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
