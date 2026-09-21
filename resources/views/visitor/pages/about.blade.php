@extends('visitor.layouts.app')

@section('title', 'About Us | Power Veda - Traditional Ayurveda. Modern Men\'s Wellness.')
@section('meta_description', 'Power Veda is a specialized men\'s wellness brand associated with M.C.D.C.R. Vaidraj Disease Eradication Center (serving since 2006), delivering authentic Ayurvedic wellness solutions.')
@section('meta_keywords', 'Power Veda, About Power Veda, M.C.D.C.R. Vaidraj Disease Eradication Center, Ayurvedic men\'s wellness, vitality, stamina, authentic Ayurveda, Vaidraj')

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
      <i class="bi bi-patch-check-fill me-1"></i> Healthcare Heritage Since 2006
    </div>
    <h1 class="display-5 fw-bold text-white mb-2" style="font-family: var(--font-heading);">
      About <span style="color: var(--gold-color);">Power Veda</span>
    </h1>
    <p class="mb-0" style="color: var(--silver-color); max-width: 700px; font-size: 1.1rem; line-height: 1.6;">
      <strong>Traditional Ayurveda. Modern Men’s Wellness.</strong> Formulations thoughtfully engineered to support modern men through time-tested Vedic wisdom and healthcare experience.
    </p>
  </div>
</section>

<!-- Main About Content Section -->
<section class="py-5" style="background-color: var(--body-bg);">
  <div class="container-custom">
    <div class="row justify-content-center">
      <div class="col-lg-11 col-xl-10">
        
        <!-- Brand Introduction Card -->
        <div class="policy-card mb-4 shadow-sm border-0" style="border-radius: var(--radius-md);">
          <div class="row align-items-center g-4">
            <div class="col-lg-7">
              <span class="badge bg-primary text-warning border border-warning px-3 py-2 rounded-pill mb-3" style="font-size: 0.8rem; letter-spacing: 0.8px;">
                <i class="bi bi-shield-fill-check me-1"></i> SPECIALIZED MEN'S WELLNESS BRAND
              </span>
              <h2 class="fw-bold mb-3" style="color: var(--heading-color); font-size: 1.85rem; font-family: var(--font-heading);">
                Ayurvedic Excellence Designed for the Modern Man
              </h2>
              <p class="policy-text mb-3" style="font-size: 1.02rem;">
                <strong>Power Veda</strong> is a specialized men’s wellness brand committed to supporting modern men with thoughtfully developed Ayurvedic wellness solutions inspired by traditional Indian knowledge and contemporary lifestyle needs.
              </p>
              <p class="policy-text mb-0">
                Power Veda is an <strong>associated wellness brand of M.C.D.C.R. Vaidraj Disease Eradication Center</strong>, an established Ayurvedic healthcare organization serving patients since 2006. With years of experience in Ayurvedic healthcare, wellness consultation and product development, M.C.D.C.R. Vaidraj provides the healthcare experience and organizational foundation behind the Power Veda brand.
              </p>
            </div>
            <div class="col-lg-5">
              <div class="about-visual-wrap">
                <img src="{{ asset('image/about.jpg') }}" alt="Power Veda Botanical Heritage" class="about-img" style="height: 320px; width: 100%; object-fit: cover; border-radius: var(--radius-md);">
                <div class="about-heritage-badge" style="bottom: -15px; right: 10px; padding: 0.9rem 1.25rem;">
                  <div class="about-badge-number" style="font-size: 1.7rem;">2006</div>
                  <div class="about-badge-label" style="font-size: 0.7rem;">Est. Clinical Heritage</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Association with Vaidraj Card -->
        <div class="policy-card mb-4 shadow-sm border-0" style="border-radius: var(--radius-md); background: linear-gradient(145deg, #ffffff 0%, #fbf9f4 100%);">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div style="width: 44px; height: 44px; background: rgba(6, 30, 67, 0.08); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary-color); font-size: 1.4rem;">
              <i class="bi bi-hospital-fill"></i>
            </div>
            <div>
              <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Clinical Heritage &amp; Foundation</span>
              <h3 class="fw-bold mb-0" style="color: var(--heading-color); font-size: 1.45rem;">Our Association with Vaidraj</h3>
            </div>
          </div>

          <div class="p-3 mb-3 rounded-3" style="background: rgba(216, 188, 141, 0.15); border-left: 4px solid var(--gold-color);">
            <p class="mb-0 fw-semibold" style="color: var(--heading-color); font-size: 1.05rem;">
              <i class="bi bi-patch-check-fill text-warning me-2"></i>
              M.C.D.C.R. Vaidraj Disease Eradication Center is the parent/associated healthcare organization behind Power Veda.
            </p>
          </div>

          <p class="policy-text">
            Power Veda operates with the support and experience of <strong>M.C.D.C.R. Vaidraj</strong> in areas including Ayurvedic wellness knowledge, product development, healthcare guidance, quality-focused processes, customer support and business operations.
          </p>

          <p class="policy-text">
            Accordingly, certain operational services of Power Veda, including <strong>banking, payment processing, billing, customer support, logistics or other commercial activities, may be managed through M.C.D.C.R. Vaidraj Disease Eradication Center and its authorized business accounts</strong>, wherever applicable.
          </p>

          <p class="policy-text mb-0">
            This association allows Power Veda to provide customers with the reliability and operational experience of an established Ayurvedic healthcare organization while maintaining a dedicated focus on men’s wellness.
          </p>
        </div>

        <!-- Our Purpose & Focus Pillars Card -->
        <div class="policy-card mb-4 shadow-sm border-0" style="border-radius: var(--radius-md);">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div style="width: 44px; height: 44px; background: rgba(46, 125, 50, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--green-color); font-size: 1.4rem;">
              <i class="bi bi-bullseye"></i>
            </div>
            <div>
              <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Why We Exist</span>
              <h3 class="fw-bold mb-0" style="color: var(--heading-color); font-size: 1.45rem;">Our Purpose</h3>
            </div>
          </div>

          <p class="policy-text mb-4">
            Modern lifestyles can affect men’s energy, stamina, confidence, stress levels and overall wellbeing. Power Veda was created to provide men with convenient, Ayurveda-inspired wellness solutions designed to become part of a healthier daily routine.
          </p>

          <h5 class="fw-bold mb-3" style="color: var(--heading-color); font-size: 1.05rem;">Our Core Focus Areas:</h5>
          
          <div class="row g-3">
            <div class="col-md-6 col-lg-4">
              <div class="p-3 rounded-3 h-100 border" style="background: #ffffff; border-color: rgba(6, 30, 67, 0.08) !important; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div class="d-flex align-items-center gap-2 mb-2">
                  <span class="badge bg-warning text-dark p-2 rounded-circle"><i class="bi bi-heart-pulse-fill"></i></span>
                  <strong class="text-dark" style="font-size: 0.95rem;">Overall Wellness &amp; Vitality</strong>
                </div>
                <p class="small text-muted mb-0">Holistic support to restore vigor, cellular stamina, and sustained day-long vitality.</p>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="p-3 rounded-3 h-100 border" style="background: #ffffff; border-color: rgba(6, 30, 67, 0.08) !important; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div class="d-flex align-items-center gap-2 mb-2">
                  <span class="badge bg-primary text-white p-2 rounded-circle"><i class="bi bi-lightning-charge-fill"></i></span>
                  <strong class="text-dark" style="font-size: 0.95rem;">Energy &amp; Stamina Support</strong>
                </div>
                <p class="small text-muted mb-0">Combating chronic fatigue and daily burnout with potent standardized adaptogens.</p>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="p-3 rounded-3 h-100 border" style="background: #ffffff; border-color: rgba(6, 30, 67, 0.08) !important; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div class="d-flex align-items-center gap-2 mb-2">
                  <span class="badge bg-success text-white p-2 rounded-circle"><i class="bi bi-peace-fill"></i></span>
                  <strong class="text-dark" style="font-size: 0.95rem;">Stress &amp; Lifestyle Wellness</strong>
                </div>
                <p class="small text-muted mb-0">Helping men manage mental stress, improve sleep quality, and maintain inner calm.</p>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="p-3 rounded-3 h-100 border" style="background: #ffffff; border-color: rgba(6, 30, 67, 0.08) !important; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div class="d-flex align-items-center gap-2 mb-2">
                  <span class="badge bg-danger text-white p-2 rounded-circle"><i class="bi bi-fire"></i></span>
                  <strong class="text-dark" style="font-size: 0.95rem;">Strength &amp; Performance</strong>
                </div>
                <p class="small text-muted mb-0">Formulations targeted to physical resilience, stamina, and peak performance.</p>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="p-3 rounded-3 h-100 border" style="background: #ffffff; border-color: rgba(6, 30, 67, 0.08) !important; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div class="d-flex align-items-center gap-2 mb-2">
                  <span class="badge bg-secondary text-white p-2 rounded-circle"><i class="bi bi-flower1"></i></span>
                  <strong class="text-dark" style="font-size: 0.95rem;">Daily Ayurvedic Solutions</strong>
                </div>
                <p class="small text-muted mb-0">Convenient, easy-to-consume natural botanicals designed for modern routines.</p>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="p-3 rounded-3 h-100 border" style="background: #ffffff; border-color: rgba(6, 30, 67, 0.08) !important; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div class="d-flex align-items-center gap-2 mb-2">
                  <span class="badge bg-dark text-white p-2 rounded-circle"><i class="bi bi-box-seam-fill"></i></span>
                  <strong class="text-dark" style="font-size: 0.95rem;">Discreet &amp; Convenient</strong>
                </div>
                <p class="small text-muted mb-0">100% confidential packaging, tamper-proof delivery, and dedicated customer care.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Our Approach & Backed by Experience Card -->
        <div class="policy-card mb-4 shadow-sm border-0" style="border-radius: var(--radius-md);">
          <div class="row g-4">
            <div class="col-lg-6 border-end-lg">
              <div class="d-flex align-items-center gap-2 mb-3">
                <div style="width: 44px; height: 44px; background: rgba(216, 188, 141, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--gold-color); font-size: 1.4rem;">
                  <i class="bi bi-compass-fill"></i>
                </div>
                <div>
                  <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Our Philosophy</span>
                  <h3 class="fw-bold mb-0" style="color: var(--heading-color); font-size: 1.35rem;">Our Approach</h3>
                </div>
              </div>
              <p class="policy-text mb-3">
                At Power Veda, we believe men’s wellness should be <strong>approached responsibly</strong>. Our products are developed with a focus on carefully selected ingredients, quality standards and practical usage for modern lifestyles.
              </p>
              <p class="policy-text mb-0">
                We do not believe in unrealistic promises or overnight solutions. Our goal is to build a trusted men’s wellness brand backed by the experience and heritage of <strong>M.C.D.C.R. Vaidraj Disease Eradication Center</strong>.
              </p>
            </div>

            <div class="col-lg-6">
              <div class="d-flex align-items-center gap-2 mb-3">
                <div style="width: 44px; height: 44px; background: rgba(6, 30, 67, 0.08); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary-color); font-size: 1.4rem;">
                  <i class="bi bi-award-fill"></i>
                </div>
                <div>
                  <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Clinical Legacy</span>
                  <h3 class="fw-bold mb-0" style="color: var(--heading-color); font-size: 1.35rem;">Backed by Experience</h3>
                </div>
              </div>
              <p class="policy-text mb-3">
                Through our association with M.C.D.C.R. Vaidraj Disease Eradication Center, Power Veda benefits from an Ayurvedic healthcare ecosystem established in <strong>2006</strong>, with experience in patient care, wellness consultation and Ayurvedic products.
              </p>
              <div class="p-3 rounded-3" style="background: var(--body-bg); border: 1px dashed rgba(6, 30, 67, 0.2);">
                <strong style="color: var(--primary-color); font-size: 0.95rem;" class="d-block mb-1">
                  <i class="bi bi-stars text-warning me-1"></i> Power Veda Promise
                </strong>
                <span class="fw-bold" style="color: var(--heading-color); font-size: 1.05rem;">Traditional Ayurveda. Modern Men’s Wellness.</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Official Business Association Notice Box -->
        <div class="policy-highlight-box mb-4 shadow-sm" style="background: #ffffff; border-left: 5px solid var(--gold-color); border-radius: var(--radius-md); padding: 1.75rem; border: 1px solid var(--border-color); border-left-width: 5px !important;">
          <div class="d-flex align-items-start gap-3">
            <div style="font-size: 1.6rem; color: var(--gold-color); line-height: 1;">
              <i class="bi bi-info-circle-fill"></i>
            </div>
            <div>
              <h4 class="fw-bold mb-2" style="color: var(--heading-color); font-size: 1.15rem;">
                Official Business Association &amp; Commercial Disclosure
              </h4>
              <p class="policy-text mb-0" style="font-size: 0.95rem; line-height: 1.65;">
                <strong>Power Veda is an associated men’s wellness brand of M.C.D.C.R. Vaidraj Disease Eradication Center.</strong> Certain payments, invoices, banking transactions and operational services may therefore be processed under the authorized business name and banking details of <strong>M.C.D.C.R. Vaidraj Disease Eradication Center</strong>, wherever applicable.
              </p>
            </div>
          </div>
        </div>

        <!-- Call to Action Banner -->
        <div class="p-4 p-md-5 rounded-4 text-center text-white position-relative overflow-hidden shadow-sm" style="background: linear-gradient(135deg, var(--primary-color) 0%, #0B3661 100%); border: 1px solid rgba(216, 188, 141, 0.4);">
          <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
            <i class="bi bi-shield-check me-1"></i> 100% PURE &bull; LAB TESTED &bull; AYUSH COMPLIANT
          </span>
          <h2 class="display-6 fw-bold mb-3" style="font-family: var(--font-heading);">Experience the Power of Vedic Formulation</h2>
          <p class="mb-4 mx-auto" style="max-width: 620px; color: var(--silver-color); font-size: 1.05rem;">
            Explore our thoughtfully developed Ayurvedic solutions crafted to elevate energy, stamina, and overall vitality naturally.
          </p>
          <div class="d-flex justify-content-center flex-wrap gap-3">
            <a href="{{ route('home') }}#shop" class="btn btn-primary px-4 py-2">
              <i class="bi bi-bag-check-fill me-1"></i> SHOP FORMULATIONS
            </a>
            <a href="{{ route('home') }}#contact" class="btn btn-wellness px-4 py-2">
              <i class="bi bi-chat-dots-fill me-1"></i> CONSULT WELLNESS EXPERTS
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection
