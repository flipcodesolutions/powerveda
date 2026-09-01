@extends('visitor.layouts.app')

@section('title', 'Terms & Conditions | Power Veda - Strength & Vitality')
@section('meta_description', 'Terms & Conditions - Power Veda. Read our user agreement, purchasing conditions, product disclaimer, and operational guidelines.')

@section('content')
<!-- Policy Hero Header -->
<section class="policy-hero-section">
  <div class="container-custom">
    <div class="policy-breadcrumb">
      <a href="{{ route('home') }}"><i class="bi bi-house-door me-1"></i> Home</a>
      <span>/</span>
      <span class="text-white">Terms &amp; Conditions</span>
    </div>
    <h1 class="display-5 fw-bold text-white mb-2" style="font-family: var(--font-heading);">
      Terms &amp; <span style="color: var(--gold-color);">Conditions</span>
    </h1>
    <p class="mb-0" style="color: var(--silver-color); max-width: 650px;">
      Please review our operational terms, user obligations, and purchasing policies prior to ordering Power Veda formulations.
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
              <span class="badge bg-success"><i class="bi bi-patch-check-fill me-1"></i> Official Legal Document</span>
            </div>
          </div>

          <p class="policy-text">
            Welcome to <strong>Power Veda</strong> (operated by Power Veda Wellness Private Limited). By accessing our website, browsing our catalog, or purchasing our premium botanical products, you agree to comply with and be bound by the following terms and conditions.
          </p>

          <h2 class="policy-section-title">
            <i class="bi bi-1-circle-fill"></i> 1. Acceptance of Terms
          </h2>
          <p class="policy-text">
            These Terms &amp; Conditions govern your use of the Power Veda web platform and all associated services. If you do not agree with any part of these terms, you must discontinue your use of our platform immediately. We reserve the right to amend these terms at any time without prior individual notice.
          </p>

          <h2 class="policy-section-title">
            <i class="bi bi-2-circle-fill"></i> 2. Botanical Wellness &amp; Health Disclaimer
          </h2>
          <p class="policy-text">
            All Power Veda formulations (including Ashwagandha Gold KSM-66, Saffron Radiance Elixirs, and Herbal Tonics) are crafted with pure natural botanicals and manufactured under strict AYUSH guidelines.
          </p>
          <div class="policy-highlight-box">
            <strong style="color: var(--heading-color);">Important Medical Disclaimer:</strong> The statements and products on this website have not been evaluated as medical pharmaceuticals to diagnose, treat, cure, or prevent any clinical disease. Consult your qualified physician before beginning any new botanical wellness regimen if you are pregnant, nursing, or undergoing clinical treatment.
          </div>

          <h2 class="policy-section-title">
            <i class="bi bi-3-circle-fill"></i> 3. Ordering, Pricing &amp; Payments
          </h2>
          <ul class="policy-list">
            <li><strong>Pricing:</strong> All prices listed are in Indian Rupees (₹ INR) and include applicable GST taxes.</li>
            <li><strong>Payment Security:</strong> Transactions are securely processed through encrypted 256-Bit SSL gateways supporting UPI, Net Banking, Credit/Debit Cards, and Cash on Delivery (COD where eligible).</li>
            <li><strong>Order Confirmation:</strong> An automated SMS and email notification will be dispatched upon successful order verification.</li>
          </ul>

          <h2 class="policy-section-title">
            <i class="bi bi-4-circle-fill"></i> 4. Intellectual Property Rights
          </h2>
          <p class="policy-text">
            The Power Veda name, emblem, logo, bespoke packaging aesthetics, custom imagery, formulations, and website architecture are the exclusive intellectual property of Power Veda Wellness Pvt Ltd. Unauthorized reproduction, scraping, or commercial exploitation is strictly prohibited under international copyright laws.
          </p>

          <h2 class="policy-section-title">
            <i class="bi bi-5-circle-fill"></i> 5. Limitation of Liability
          </h2>
          <p class="policy-text">
            Power Veda shall not be liable for any indirect, incidental, or consequential damages resulting from the use or inability to use our products, beyond the actual invoice purchase value paid by the customer for the specific product.
          </p>

          <h2 class="policy-section-title">
            <i class="bi bi-6-circle-fill"></i> 6. Contact &amp; Grievance Redressal
          </h2>
          <p class="policy-text">
            For legal inquiries, operational queries, or customer grievances regarding these terms:
          </p>
          <div class="p-3 rounded bg-light border">
            <p class="mb-1"><strong>Grievance Officer:</strong> Power Veda Legal &amp; Compliance Cell</p>
            <p class="mb-1"><strong>Email:</strong> legal@powerveda.com / support@powerveda.com</p>
            <p class="mb-1"><strong>Helpline:</strong> +91 (800) 555-VEDA (Mon - Sat, 9:00 AM - 7:00 PM IST)</p>
            <p class="mb-0"><strong>Address:</strong> 108 Lotus Wellness Way, Green Valley, Mumbai 400001, Maharashtra, India</p>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>
@endsection
