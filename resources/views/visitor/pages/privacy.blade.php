@extends('visitor.layouts.app')

@section('title', 'Privacy Policy | Power Veda - Strength & Vitality')
@section('meta_description', 'Privacy Policy - Power Veda. Learn how we protect your personal information, handle secure transactions, and safeguard your wellness data.')

@section('content')
<!-- Policy Hero Header -->
<section class="policy-hero-section">
  <div class="container-custom">
    <div class="policy-breadcrumb">
      <a href="{{ route('home') }}"><i class="bi bi-house-door me-1"></i> Home</a>
      <span>/</span>
      <span class="text-white">Privacy Policy</span>
    </div>
    <h1 class="display-5 fw-bold text-white mb-2" style="font-family: var(--font-heading);">
      Privacy <span style="color: var(--gold-color);">Policy</span>
    </h1>
    <p class="mb-0" style="color: var(--silver-color); max-width: 650px;">
      Your privacy is sacred to us. Learn how Power Veda protects and responsibly handles your personal and payment data.
    </p>
  </div>
</section>

<!-- Policy Content Section -->
<section class="py-5" style="background-color: var(--body-bg);">
  <div class="container-custom">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        
        <div class="policy-card">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 pb-3 border-bottom">
            <div>
              <span class="badge bg-light text-dark border"><i class="bi bi-calendar3 me-1"></i> Last Updated: August 2026</span>
            </div>
            <div>
              <span class="badge bg-success"><i class="bi bi-shield-lock-fill me-1"></i> 256-Bit SSL Encrypted</span>
            </div>
          </div>

          <p class="policy-text">
            At <strong>Power Veda</strong>, we are committed to safeguarding the personal information of our valued customers. This Privacy Policy details how we collect, utilize, store, and protect your information when you visit our website or make a purchase.
          </p>

          <h2 class="policy-section-title">
            <i class="bi bi-person-lines-fill"></i> 1. Information We Collect
          </h2>
          <p class="policy-text">We collect information necessary to fulfill your orders and enhance your wellness journey:</p>
          <ul class="policy-list">
            <li><strong>Contact Information:</strong> Your full name, delivery address, phone number, and email address.</li>
            <li><strong>Order History &amp; Preferences:</strong> Purchased formulations, order status, and delivery logs.</li>
            <li><strong>Device &amp; Usage Data:</strong> IP address, browser type, device information, and interaction metrics to optimize website speed.</li>
          </ul>

          <h2 class="policy-section-title">
            <i class="bi bi-gear-wide-connected"></i> 2. How We Use Your Information
          </h2>
          <p class="policy-text">Your information is used strictly for legitimate business and wellness fulfillment purposes:</p>
          <ul class="policy-list">
            <li>Processing, packaging, and dispatching your orders via verified express logistics partners.</li>
            <li>Sending transactional updates, tracking codes, and digital tax invoices.</li>
            <li>Providing customer support and responding promptly to wellness queries.</li>
            <li>Notifying you about seasonal discounts, exclusive product drops (only if you subscribe to our newsletter).</li>
          </ul>

          <h2 class="policy-section-title">
            <i class="bi bi-shield-shaded"></i> 3. Data Protection &amp; Payment Security
          </h2>
          <div class="policy-highlight-box">
            <strong style="color: var(--heading-color);">Bank-Grade Security:</strong> All financial transactions on Power Veda are secured by 256-Bit SSL encryption. We <strong>never</strong> store your Credit/Debit Card numbers or CVV details on our servers. All payments are processed through RBI-compliant, PCI-DSS certified payment gateways.
          </div>

          <h2 class="policy-section-title">
            <i class="bi bi-cookie"></i> 4. Cookies &amp; Tracking Technologies
          </h2>
          <p class="policy-text">
            We use functional cookies to remember your shopping cart items, preserve your active login session, and provide a seamless checkout flow. You can adjust your browser settings to refuse cookies, though certain cart features may be limited.
          </p>

          <h2 class="policy-section-title">
            <i class="bi bi-share-fill"></i> 5. Zero Third-Party Data Selling
          </h2>
          <p class="policy-text">
            We uphold a strict zero-spam, zero-selling policy. Power Veda does <strong>not sell, rent, or lease</strong> your personal details to third-party marketing firms under any circumstances.
          </p>

          <h2 class="policy-section-title">
            <i class="bi bi-envelope-at-fill"></i> 6. Privacy Inquiries
          </h2>
          <p class="policy-text">
            If you have any questions regarding your data privacy, or wish to request data removal or profile updates:
          </p>
          <div class="p-3 rounded bg-light border">
            <p class="mb-1"><strong>Data Privacy Officer:</strong> Power Veda Information Security Cell</p>
            <p class="mb-1"><strong>Email:</strong> privacy@powerveda.com</p>
            <p class="mb-0"><strong>Helpline:</strong> +91 (800) 555-VEDA</p>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>
@endsection
