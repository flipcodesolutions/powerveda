@extends('visitor.layouts.app')

@section('title', 'About Us | YUVARDHAN – Strength & Vitality')
@section('meta_description', 'Learn about YUVARDHAN, a men\'s wellness brand focused on thoughtfully developed wellness products designed to complement modern lifestyles, associated with M.C.D.C.R. Vaidraj Disease Eradication Center (serving patients since 2022).')
@section('meta_keywords', 'YUVARDHAN, About YUVARDHAN, Strength and Vitality, M.C.D.C.R. Vaidraj Disease Eradication Center, men\'s wellness, vitality, Ayurvedic healthcare, modern lifestyle')

@section('content')
<!-- About Hero Section -->
<section class="policy-hero-section">
  <div class="container-custom">
    <div class="policy-breadcrumb">
      <a href="{{ route('home') }}"><i class="bi bi-house-door me-1"></i> Home</a>
      <span>/</span>
      <span class="text-white">About Us</span>
    </div>
    <div class="hero-tag mb-2 d-inline-block" style="background: rgba(216, 188, 141, 0.15); border: 1px solid var(--gold-color); color: var(--gold-color); padding: 4px 14px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">
      <i class="bi bi-patch-check-fill me-1"></i> Serving Patients Since 2022
    </div>
    <h1 class="display-5 fw-bold text-white mb-2" style="font-family: var(--font-heading);">
      About <span style="color: var(--gold-color);">YUVARDHAN</span>
    </h1>
    <p class="mb-0" style="color: var(--silver-color); max-width: 720px; font-size: 1.1rem; line-height: 1.6;">
      <strong>Strength &amp; Vitality.</strong> Thoughtfully developed men’s wellness products designed to complement modern lifestyles through quality, transparency, and care.
    </p>
  </div>
</section>

<!-- Main About Content Section -->
<section class="py-5" style="background-color: var(--body-bg);">
  <div class="container-custom">
    <div class="row justify-content-center">
      <div class="col-lg-11 col-xl-10">
        
        <!-- 1. YUVARDHAN – Strength & Vitality -->
        <div class="policy-card mb-4 shadow-sm border-0" style="border-radius: var(--radius-md);">
          <div class="row align-items-center g-4">
            <div class="col-lg-7">
              <span class="badge bg-primary text-warning border border-warning px-3 py-2 rounded-pill mb-3" style="font-size: 0.8rem; letter-spacing: 0.8px;">
                <i class="bi bi-shield-fill-check me-1"></i> MEN'S WELLNESS BRAND
              </span>
              <h2 class="fw-bold mb-3" style="color: var(--heading-color); font-size: 1.85rem; font-family: var(--font-heading);">
                YUVARDHAN – Strength &amp; Vitality
              </h2>
              <p class="policy-text mb-3" style="font-size: 1.02rem;">
                <strong>YUVARDHAN</strong> is a men's wellness brand focused on providing thoughtfully developed wellness products designed to complement modern lifestyles. Our brand aims to make quality-focused men's wellness products accessible through a convenient and reliable online shopping experience.
              </p>
              <p class="policy-text mb-0" style="font-size: 1.02rem;">
                We believe that wellness is an important part of everyday life. With this belief, <strong>YUVARDHAN</strong> aims to offer products that support general wellness, vitality and a balanced lifestyle.
              </p>
            </div>
            <div class="col-lg-5">
              <div class="about-visual-wrap">
                <img src="{{ asset('image/about.jpg') }}" alt="YUVARDHAN Wellness Heritage" class="about-img" style="height: 320px; width: 100%; object-fit: cover; border-radius: var(--radius-md);">
                <div class="about-heritage-badge" style="bottom: -15px; right: 10px; padding: 0.9rem 1.25rem;">
                  <div class="about-badge-number" style="font-size: 1.7rem;">2022</div>
                  <div class="about-badge-label" style="font-size: 0.7rem;">Serving Patients</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 2. Our Brand -->
        <div class="policy-card mb-4 shadow-sm border-0" style="border-radius: var(--radius-md);">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div style="width: 44px; height: 44px; background: rgba(6, 30, 67, 0.08); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary-color); font-size: 1.4rem;">
              <i class="bi bi-gem"></i>
            </div>
            <div>
              <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Brand Identity &amp; Approach</span>
              <h3 class="fw-bold mb-0" style="color: var(--heading-color); font-size: 1.45rem;">Our Brand</h3>
            </div>
          </div>

          <p class="policy-text mb-3" style="font-size: 1.02rem;">
            <strong>YUVARDHAN</strong> focuses on men's wellness and everyday lifestyle needs. Our approach combines an understanding of traditional wellness practices with the expectations of today's consumers.
          </p>

          <p class="policy-text mb-4" style="font-size: 1.02rem;">
            We aim to build a brand that customers can approach with confidence through transparent product information, responsible communication, quality-conscious sourcing and customer-focused service.
          </p>

          <div class="row g-3">
            <div class="col-md-6 col-lg-3">
              <div class="p-3 rounded-3 h-100 border text-center" style="background: #ffffff; border-color: rgba(6, 30, 67, 0.08) !important;">
                <div class="mb-2 text-warning fs-3"><i class="bi bi-file-earmark-text"></i></div>
                <h6 class="fw-bold mb-1" style="color: var(--heading-color); font-size: 0.95rem;">Transparent Information</h6>
                <p class="small text-muted mb-0">Clear ingredient details and usage guidelines.</p>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="p-3 rounded-3 h-100 border text-center" style="background: #ffffff; border-color: rgba(6, 30, 67, 0.08) !important;">
                <div class="mb-2 text-primary fs-3"><i class="bi bi-chat-heart"></i></div>
                <h6 class="fw-bold mb-1" style="color: var(--heading-color); font-size: 0.95rem;">Responsible Communication</h6>
                <p class="small text-muted mb-0">Realistic expectations and honest messaging.</p>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="p-3 rounded-3 h-100 border text-center" style="background: #ffffff; border-color: rgba(6, 30, 67, 0.08) !important;">
                <div class="mb-2 text-success fs-3"><i class="bi bi-patch-check"></i></div>
                <h6 class="fw-bold mb-1" style="color: var(--heading-color); font-size: 0.95rem;">Quality-Conscious Sourcing</h6>
                <p class="small text-muted mb-0">High-grade botanicals and verified ingredients.</p>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="p-3 rounded-3 h-100 border text-center" style="background: #ffffff; border-color: rgba(6, 30, 67, 0.08) !important;">
                <div class="mb-2 text-info fs-3"><i class="bi bi-headset"></i></div>
                <h6 class="fw-bold mb-1" style="color: var(--heading-color); font-size: 0.95rem;">Customer-Focused Service</h6>
                <p class="small text-muted mb-0">Dedicated support for orders and inquiries.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- 3. Our Product Range -->
        <div class="policy-card mb-4 shadow-sm border-0" style="border-radius: var(--radius-md);">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div style="width: 44px; height: 44px; background: rgba(46, 125, 50, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--green-color); font-size: 1.4rem;">
              <i class="bi bi-box-seam"></i>
            </div>
            <div>
              <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Wellness Formulations</span>
              <h3 class="fw-bold mb-0" style="color: var(--heading-color); font-size: 1.45rem;">Our Product Range</h3>
            </div>
          </div>

          <p class="policy-text mb-3" style="font-size: 1.02rem;">
            <strong>YUVARDHAN</strong> offers products within the men's wellness category. Product details, ingredients, directions for use, pricing and other relevant information are provided on the respective product pages to help customers make informed purchasing decisions.
          </p>

          <p class="policy-text mb-3" style="font-size: 1.02rem;">
            We are committed to presenting our products responsibly and avoiding misleading information or unrealistic expectations.
          </p>

          <div class="mt-3">
            <a href="{{ route('home') }}#shop" class="btn btn-outline-secondary btn-sm px-3 py-2 fw-semibold">
              <i class="bi bi-bag me-1"></i> Browse Our Product Catalog
            </a>
          </div>
        </div>

        <!-- 4. Our Association with M.C.D.C.R. Vaidraj Disease Eradication Center -->
        <div class="policy-card mb-4 shadow-sm border-0" style="border-radius: var(--radius-md); background: linear-gradient(145deg, #ffffff 0%, #fbf9f4 100%);">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div style="width: 44px; height: 44px; background: rgba(6, 30, 67, 0.08); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary-color); font-size: 1.4rem;">
              <i class="bi bi-hospital-fill"></i>
            </div>
            <div>
              <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Healthcare Association</span>
              <h3 class="fw-bold mb-0" style="color: var(--heading-color); font-size: 1.45rem;">Our Association with M.C.D.C.R. Vaidraj Disease Eradication Center</h3>
            </div>
          </div>

          <div class="p-3 mb-3 rounded-3" style="background: rgba(216, 188, 141, 0.15); border-left: 4px solid var(--gold-color);">
            <p class="mb-0 fw-semibold" style="color: var(--heading-color); font-size: 1.05rem;">
              <i class="bi bi-patch-check-fill text-warning me-2"></i>
              YUVARDHAN is associated with <em>M.C.D.C.R. Vaidraj Disease Eradication Center</em>, an Ayurvedic healthcare organization serving patients since 2022.
            </p>
          </div>

          <p class="policy-text mb-0" style="font-size: 1.02rem;">
            This association provides YUVARDHAN with a connection to an organization working in the field of Ayurveda and wellness. We aim to maintain a customer-focused approach while developing our brand and product offerings.
          </p>
        </div>

        <!-- 5. Our Commitment -->
        <div class="policy-card mb-4 shadow-sm border-0" style="border-radius: var(--radius-md);">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div style="width: 44px; height: 44px; background: rgba(216, 188, 141, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--gold-color); font-size: 1.4rem;">
              <i class="bi bi-award-fill"></i>
            </div>
            <div>
              <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Core Principles</span>
              <h3 class="fw-bold mb-0" style="color: var(--heading-color); font-size: 1.45rem;">Our Commitment</h3>
            </div>
          </div>

          <p class="policy-text mb-3" style="font-size: 1.02rem;">
            At <strong>YUVARDHAN</strong>, we are committed to:
          </p>

          <div class="row g-3">
            <div class="col-md-6">
              <div class="d-flex align-items-start gap-2 p-3 rounded-3 border h-100" style="background: #ffffff; border-color: rgba(6, 30, 67, 0.08) !important;">
                <i class="bi bi-check-circle-fill text-success fs-5 mt-1"></i>
                <div>
                  <span class="fw-semibold text-dark d-block">Providing clear and accurate product information.</span>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="d-flex align-items-start gap-2 p-3 rounded-3 border h-100" style="background: #ffffff; border-color: rgba(6, 30, 67, 0.08) !important;">
                <i class="bi bi-check-circle-fill text-success fs-5 mt-1"></i>
                <div>
                  <span class="fw-semibold text-dark d-block">Maintaining a quality-conscious approach to our products.</span>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="d-flex align-items-start gap-2 p-3 rounded-3 border h-100" style="background: #ffffff; border-color: rgba(6, 30, 67, 0.08) !important;">
                <i class="bi bi-check-circle-fill text-success fs-5 mt-1"></i>
                <div>
                  <span class="fw-semibold text-dark d-block">Offering a convenient and transparent online shopping experience.</span>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="d-flex align-items-start gap-2 p-3 rounded-3 border h-100" style="background: #ffffff; border-color: rgba(6, 30, 67, 0.08) !important;">
                <i class="bi bi-check-circle-fill text-success fs-5 mt-1"></i>
                <div>
                  <span class="fw-semibold text-dark d-block">Providing customer support for product and order-related queries.</span>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="d-flex align-items-start gap-2 p-3 rounded-3 border h-100" style="background: #ffffff; border-color: rgba(6, 30, 67, 0.08) !important;">
                <i class="bi bi-check-circle-fill text-success fs-5 mt-1"></i>
                <div>
                  <span class="fw-semibold text-dark d-block">Following responsible marketing and communication practices.</span>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="d-flex align-items-start gap-2 p-3 rounded-3 border h-100" style="background: #ffffff; border-color: rgba(6, 30, 67, 0.08) !important;">
                <i class="bi bi-check-circle-fill text-success fs-5 mt-1"></i>
                <div>
                  <span class="fw-semibold text-dark d-block">Handling customer information with care, in accordance with our <a href="{{ route('privacy') }}" class="text-decoration-underline text-primary">Privacy Policy</a>.</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 6. Online Orders & Payment Processing -->
        <div class="policy-card mb-4 shadow-sm border-0" style="border-radius: var(--radius-md);">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div style="width: 44px; height: 44px; background: rgba(6, 30, 67, 0.08); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary-color); font-size: 1.4rem;">
              <i class="bi bi-credit-card-2-front-fill"></i>
            </div>
            <div>
              <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Transactions &amp; Order Policies</span>
              <h3 class="fw-bold mb-0" style="color: var(--heading-color); font-size: 1.45rem;">Online Orders &amp; Payment Processing</h3>
            </div>
          </div>

          <p class="policy-text mb-3" style="font-size: 1.02rem;">
            Customers can explore our products and place orders through our official website.
          </p>

          <p class="policy-text mb-3" style="font-size: 1.02rem;">
            Online payments for YUVARDHAN orders are processed through the authorized payment and banking arrangements managed by <strong>M.C.D.C.R. Vaidraj Disease Eradication Center</strong>, as applicable to the transaction.
          </p>

          <div class="p-3 mb-3 rounded-3" style="background: rgba(6, 30, 67, 0.04); border-left: 4px solid var(--primary-color);">
            <p class="policy-text mb-0" style="font-size: 0.98rem; color: var(--heading-color);">
              <i class="bi bi-info-circle-fill text-primary me-2"></i>
              For this reason, the merchant or business name displayed on a payment confirmation, bank statement or transaction record may appear under the relevant Vaidraj business name rather than YUVARDHAN.
            </p>
          </div>

          <p class="policy-text mb-0" style="font-size: 0.98rem;">
            All orders are subject to the applicable <a href="{{ route('terms') }}" class="fw-semibold text-primary">Terms &amp; Conditions</a>, <a href="{{ route('shipping') }}" class="fw-semibold text-primary">Shipping Policy</a>, <a href="{{ route('refund') }}" class="fw-semibold text-primary">Return &amp; Refund Policy</a> and <a href="{{ route('privacy') }}" class="fw-semibold text-primary">Privacy Policy</a> published on this website.
          </p>
        </div>

        <!-- 7. Our Vision -->
        <div class="policy-card mb-4 shadow-sm border-0" style="border-radius: var(--radius-md); background: linear-gradient(135deg, rgba(216, 188, 141, 0.15) 0%, rgba(255, 255, 255, 1) 100%); border-left: 5px solid var(--gold-color) !important;">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div style="width: 44px; height: 44px; background: rgba(216, 188, 141, 0.3); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--gold-dark); font-size: 1.4rem;">
              <i class="bi bi-compass-fill"></i>
            </div>
            <div>
              <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Looking Ahead</span>
              <h3 class="fw-bold mb-0" style="color: var(--heading-color); font-size: 1.45rem;">Our Vision</h3>
            </div>
          </div>

          <p class="policy-text mb-0 fw-semibold" style="font-size: 1.08rem; color: var(--heading-color); line-height: 1.7;">
            Our vision is to establish YUVARDHAN as a trusted name in men's wellness by focusing on product quality, transparent communication, customer satisfaction and responsible business practices.
          </p>
        </div>

        <!-- Call to Action Banner -->
        <div class="p-4 p-md-5 rounded-4 text-center text-white position-relative overflow-hidden shadow-sm" style="background: linear-gradient(135deg, var(--primary-color) 0%, #0B3661 100%); border: 1px solid rgba(216, 188, 141, 0.4);">
          <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
            <i class="bi bi-shield-check me-1"></i> QUALITY-CONSCIOUS MEN'S WELLNESS
          </span>
          <h2 class="display-6 fw-bold mb-3 text-white" style="font-family: var(--font-heading);">Explore YUVARDHAN Formulations</h2>
          <p class="mb-4 mx-auto" style="max-width: 620px; color: var(--silver-color); font-size: 1.05rem;">
            Discover thoughtfully developed wellness products designed to support vitality, strength, and a balanced lifestyle.
          </p>
          <div class="d-flex justify-content-center flex-wrap gap-3">
            <a href="{{ route('home') }}#shop" class="btn btn-primary px-4 py-2">
              <i class="bi bi-bag-check-fill me-1"></i> EXPLORE PRODUCTS
            </a>
            <a href="{{ route('home') }}#contact" class="btn btn-wellness px-4 py-2">
              <i class="bi bi-chat-dots-fill me-1"></i> CONTACT SUPPORT
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection
