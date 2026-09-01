@extends('visitor.layouts.app')

@section('title', 'Refund & Return Policy | Power Veda - Strength & Vitality')
@section('meta_description', 'Refund & Return Policy - Power Veda. Learn about our 30-day wellness guarantee, hassle-free returns, replacement terms, and refund timelines.')

@section('content')
<!-- Policy Hero Header -->
<section class="policy-hero-section">
  <div class="container-custom">
    <div class="policy-breadcrumb">
      <a href="{{ route('home') }}"><i class="bi bi-house-door me-1"></i> Home</a>
      <span>/</span>
      <span class="text-white">Refund &amp; Return Policy</span>
    </div>
    <h1 class="display-5 fw-bold text-white mb-2" style="font-family: var(--font-heading);">
      Refund &amp; <span style="color: var(--gold-color);">Return Policy</span>
    </h1>
    <p class="mb-0" style="color: var(--silver-color); max-width: 650px;">
      100% Satisfaction &amp; 30-Day Pure Wellness Guarantee. We are committed to your complete satisfaction and vitality.
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
              <span class="badge bg-success"><i class="bi bi-check2-circle me-1"></i> 30-Day Guarantee Protected</span>
            </div>
          </div>

          <div class="policy-highlight-box">
            <h5 class="fw-bold mb-1" style="color: var(--heading-color);">🌱 The Power Veda Pure Wellness Guarantee</h5>
            <p class="mb-0 small text-muted">
              We stand firmly behind the bio-potency and purity of our handcrafted formulations. If you are not satisfied with your experience, our support team will ensure a smooth refund or replacement process.
            </p>
          </div>

          <h2 class="policy-section-title">
            <i class="bi bi-shield-check"></i> 1. Return &amp; Exchange Eligibility
          </h2>
          <p class="policy-text">You are eligible for a full refund or immediate replacement under the following conditions:</p>
          <ul class="policy-list">
            <li><strong>Damaged or Leaked Package:</strong> If the glass jar, seal, or safety cap is damaged upon delivery.</li>
            <li><strong>Wrong Item Received:</strong> If the delivered formulation differs from your confirmed invoice order.</li>
            <li><strong>Quality Concern:</strong> If the product shows any defect or packaging seal breach.</li>
            <li><strong>30-Day Window:</strong> Return requests must be initiated within <strong>30 days</strong> from the recorded delivery date.</li>
          </ul>

          <h2 class="policy-section-title">
            <i class="bi bi-wallet2"></i> 2. Refund Processing &amp; Timelines
          </h2>
          <p class="policy-text">Once your return request is approved:</p>
          <ul class="policy-list">
            <li><strong>UPI &amp; Net Banking:</strong> Refunds are credited within <strong>24 to 48 hours</strong> directly to the original bank account.</li>
            <li><strong>Credit / Debit Cards:</strong> Refunds reflect on your card statement within <strong>3 to 5 business days</strong> depending on your issuing bank.</li>
            <li><strong>Cash on Delivery (COD):</strong> Refunds are transferred via instant IMPS/UPI upon providing bank verification details.</li>
          </ul>

          <h2 class="policy-section-title">
            <i class="bi bi-x-circle"></i> 3. Order Cancellation Policy
          </h2>
          <p class="policy-text">
            Orders can be canceled free of charge at any time <strong>prior to courier dispatch</strong>. Once your order has been handed over to BlueDart or Delhivery express couriers, please receive the parcel and initiate a standard return.
          </p>

          <h2 class="policy-section-title">
            <i class="bi bi-arrow-repeat"></i> 4. How to Initiate a Return in 3 Easy Steps
          </h2>
          <div class="row g-3 mb-4">
            <div class="col-md-4">
              <div class="p-3 rounded border text-center h-100 bg-light">
                <div class="fs-2 mb-2 text-warning"><i class="bi bi-chat-left-text-fill"></i></div>
                <h6 class="fw-bold">Step 1: Contact Support</h6>
                <p class="small text-muted mb-0">Email support@powerveda.com with your Order ID (#PV-XXXXX) &amp; photo of the package.</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="p-3 rounded border text-center h-100 bg-light">
                <div class="fs-2 mb-2 text-warning"><i class="bi bi-box-seam-fill"></i></div>
                <h6 class="fw-bold">Step 2: Free Pickup</h6>
                <p class="small text-muted mb-0">Our courier team will arrange a hassle-free doorstep pickup from your address.</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="p-3 rounded border text-center h-100 bg-light">
                <div class="fs-2 mb-2 text-success"><i class="bi bi-cash-stack"></i></div>
                <h6 class="fw-bold">Step 3: Instant Refund</h6>
                <p class="small text-muted mb-0">Full refund is credited directly to your payment source within 24-48 hours.</p>
              </div>
            </div>
          </div>

          <h2 class="policy-section-title">
            <i class="bi bi-headset"></i> 5. Need Immediate Assistance?
          </h2>
          <p class="policy-text">Our wellness support specialists are ready to help you:</p>
          <div class="p-3 rounded bg-light border d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
              <p class="mb-1"><strong>Direct Support Desk:</strong> support@powerveda.com</p>
              <p class="mb-0"><strong>Toll-Free Helpline:</strong> +91 (800) 555-VEDA (9:00 AM - 7:00 PM IST)</p>
            </div>
            <a href="mailto:support@powerveda.com?subject=Return%20Request%20-%20Power%20Veda" class="btn btn-primary">
              <i class="bi bi-envelope-fill"></i> Email Support Team
            </a>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>
@endsection
