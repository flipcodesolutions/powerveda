<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use Illuminate\Database\Seeder;

class CmsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'detail' => '<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 pb-3 border-bottom">
  <div>
    <span class="badge bg-light text-dark border"><i class="bi bi-calendar3 me-1"></i> Last Updated: August 2026</span>
  </div>
  <div>
    <span class="badge bg-success"><i class="bi bi-shield-lock-fill me-1"></i> 256-Bit SSL Encrypted</span>
  </div>
</div>

<p class="policy-text">
  At <strong>Power Veda</strong> (an associated men’s wellness brand of <strong>M.C.D.C.R. Vaidraj Disease Eradication Center</strong>, serving patients since 2006), we are committed to safeguarding the personal information and confidentiality of our valued customers. This Privacy Policy details how we collect, utilize, store, and protect your information when you visit our website or make a purchase.
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
<div class="policy-highlight-box mb-4">
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
</div>',
            ],
            [
                'title' => 'Refund Policy',
                'slug' => 'refund-policy',
                'detail' => '<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 pb-3 border-bottom">
  <div>
    <span class="badge bg-light text-dark border"><i class="bi bi-calendar3 me-1"></i> Last Updated: August 2026</span>
  </div>
  <div>
    <span class="badge bg-success"><i class="bi bi-check2-circle me-1"></i> 30-Day Guarantee Protected</span>
  </div>
</div>

<div class="policy-highlight-box mb-4">
  <h5 class="fw-bold mb-1" style="color: var(--heading-color);">🌱 The Power Veda Pure Wellness Guarantee</h5>
  <p class="mb-0 small text-muted">
    We stand firmly behind the bio-potency and purity of our handcrafted formulations. If you are not satisfied with your experience, our support team will ensure a smooth refund or replacement process.
  </p>
</div>

<h2 class="policy-section-title">
  <i class="bi bi-shield-check"></i> 1. Refund &amp; Exchange Eligibility
</h2>
<p class="policy-text">You are eligible for a full refund or immediate replacement under the following conditions:</p>
<ul class="policy-list">
  <li><strong>Damaged or Leaked Package:</strong> If the glass jar, seal, or safety cap is damaged upon delivery.</li>
  <li><strong>Wrong Item Received:</strong> If the delivered formulation differs from your confirmed invoice order.</li>
  <li><strong>Quality Concern:</strong> If the product shows any defect or packaging seal breach.</li>
  <li><strong>30-Day Window:</strong> Refund/return requests must be initiated within <strong>30 days</strong> from the recorded delivery date.</li>
</ul>

<h2 class="policy-section-title">
  <i class="bi bi-wallet2"></i> 2. Refund Processing &amp; Timelines
</h2>
<p class="policy-text">Once your return request is approved (processed through the authorized banking and accounts of <strong>M.C.D.C.R. Vaidraj Disease Eradication Center</strong>):</p>
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
  <i class="bi bi-arrow-repeat"></i> 4. How to Initiate a Refund in 3 Easy Steps
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
  <a href="mailto:support@powerveda.com?subject=Refund%20Request%20-%20Power%20Veda" class="btn btn-primary">
    <i class="bi bi-envelope-fill me-1"></i> Email Support Team
  </a>
</div>',
            ],
            [
                'title' => 'Return Policy',
                'slug' => 'return-policy',
                'detail' => '<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 pb-3 border-bottom">
  <div>
    <span class="badge bg-light text-dark border"><i class="bi bi-calendar3 me-1"></i> Last Updated: August 2026</span>
  </div>
  <div>
    <span class="badge bg-success"><i class="bi bi-arrow-counterclockwise me-1"></i> 30-Day Easy Returns</span>
  </div>
</div>

<p class="policy-text">
  At <strong>Power Veda</strong> (associated with <strong>M.C.D.C.R. Vaidraj Disease Eradication Center</strong>), your confidence in our authentic Ayurvedic remedies is paramount. We offer a transparent, customer-first return and exchange process.
</p>

<h2 class="policy-section-title">
  <i class="bi bi-clock-history"></i> 1. 30-Day Return Window
</h2>
<p class="policy-text">
  You have <strong>30 calendar days</strong> from the date of delivery to request a return or replacement for any botanical product purchased directly through the official Power Veda storefront.
</p>

<h2 class="policy-section-title">
  <i class="bi bi-box-seam"></i> 2. Return Criteria &amp; Conditions
</h2>
<ul class="policy-list">
  <li><strong>Unopened or Gently Sampled:</strong> Unopened packages are accepted immediately. Opened containers are eligible under our 30-Day Satisfaction Guarantee.</li>
  <li><strong>Original Packaging:</strong> Please retain the outer carton, original invoice, and safety cap wherever possible.</li>
  <li><strong>Damaged in Transit:</strong> If your order arrives with broken seals or damaged jars, notify our team within 48 hours for immediate replacement.</li>
</ul>

<h2 class="policy-section-title">
  <i class="bi bi-truck"></i> 3. Free Reverse Pickup Process
</h2>
<p class="policy-text">
  We arrange free doorstep pickup across 26,000+ PIN codes in India. Our courier partner will collect the return package directly from your delivery address:
</p>
<ul class="policy-list">
  <li>Raise a return request via email to <strong>support@powerveda.com</strong> or our helpline.</li>
  <li>Our reverse logistics team generates a pre-paid return label within 24 hours.</li>
  <li>Courier agent picks up the parcel within 1-2 business days.</li>
</ul>

<h2 class="policy-section-title">
  <i class="bi bi-arrow-left-right"></i> 4. Replacement or Refund Selection
</h2>
<p class="policy-text">
  Upon return verification, you can choose between:
</p>
<ul class="policy-list">
  <li><strong>Instant Replacement:</strong> A brand new sealed unit dispatched immediately via express courier.</li>
  <li><strong>Full Money-Back Refund:</strong> Credited to your original payment method (or UPI/Bank for COD orders) within 24-48 hours.</li>
</ul>

<div class="p-3 rounded bg-light border mt-4">
  <p class="mb-1"><strong>Returns Department:</strong> Power Veda Logistics Center</p>
  <p class="mb-1"><strong>Email:</strong> returns@powerveda.com / support@powerveda.com</p>
  <p class="mb-0"><strong>Helpline:</strong> +91 (800) 555-VEDA (Mon - Sat, 9:00 AM - 7:00 PM IST)</p>
</div>',
            ],
            [
                'title' => 'Shipping Policy',
                'slug' => 'shipping-policy',
                'detail' => '<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 pb-3 border-bottom">
  <div>
    <span class="badge bg-light text-dark border"><i class="bi bi-calendar3 me-1"></i> Last Updated: August 2026</span>
  </div>
  <div>
    <span class="badge bg-success"><i class="bi bi-truck-flatbed me-1"></i> Express Pan-India Delivery</span>
  </div>
</div>

<div class="policy-highlight-box mb-4">
  <h5 class="fw-bold mb-1" style="color: var(--heading-color);">🚚 Free Express Shipping on Orders Above ₹999</h5>
  <p class="mb-0 small text-muted">
    Enjoy complimentary express courier shipping across India on all eligible cart orders above ₹999. A flat nominal shipping charge of ₹99 applies to smaller orders.
  </p>
</div>

<h2 class="policy-section-title">
  <i class="bi bi-speedometer2"></i> 1. Processing &amp; Dispatch Timelines
</h2>
<p class="policy-text">
  All orders are freshly prepared, quality inspected, and dispatched within <strong>24 hours</strong> of order placement (excluding Sundays and national holidays).
</p>

<h2 class="policy-section-title">
  <i class="bi bi-geo-alt"></i> 2. Estimated Delivery Timelines
</h2>
<ul class="policy-list">
  <li><strong>Metro Cities (Mumbai, Delhi NCR, Bengaluru, Chennai, Hyderabad, Kolkata):</strong> 2 to 3 business days.</li>
  <li><strong>Tier 2 &amp; Tier 3 Cities:</strong> 3 to 5 business days.</li>
  <li><strong>Remote &amp; North-Eastern Regions:</strong> 5 to 7 business days.</li>
</ul>

<h2 class="policy-section-title">
  <i class="bi bi-shield-check"></i> 3. Express Courier Partners
</h2>
<p class="policy-text">
  We partner exclusively with top-tier express logistics providers including <strong>BlueDart, Delhivery, DTDC, and XpressBees</strong> to ensure timely, temperature-controlled delivery.
</p>

<h2 class="policy-section-title">
  <i class="bi bi-box2"></i> 4. Discreet &amp; Eco-Friendly Packaging
</h2>
<p class="policy-text">
  We respect your personal privacy. All Power Veda formulations are packed in <strong>plain, discreet, tamper-proof boxes</strong> without any sensitive product descriptions printed on the outer label.
</p>

<h2 class="policy-section-title">
  <i class="bi bi-pin-map"></i> 5. Live Order Tracking
</h2>
<p class="policy-text">
  As soon as your package is dispatched, you will receive an automated SMS and WhatsApp notification containing your official AWB tracking code and direct live tracking link.
</p>

<div class="p-3 rounded bg-light border mt-4">
  <p class="mb-1"><strong>Logistics Helpdesk:</strong> shipping@powerveda.com</p>
  <p class="mb-0"><strong>Helpline:</strong> +91 (800) 555-VEDA (Mon - Sat: 9:00 AM - 7:00 PM IST)</p>
</div>',
            ],
            [
                'title' => 'Terms and Conditions',
                'slug' => 'terms-and-conditions',
                'detail' => '<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 pb-3 border-bottom">
  <div>
    <span class="badge bg-light text-dark border"><i class="bi bi-calendar3 me-1"></i> Last Updated: August 2026</span>
  </div>
  <div>
    <span class="badge bg-success"><i class="bi bi-patch-check-fill me-1"></i> Official Legal Document</span>
  </div>
</div>

<p class="policy-text">
  Welcome to <strong>Power Veda</strong>. Power Veda is an associated men’s wellness brand of <strong>M.C.D.C.R. Vaidraj Disease Eradication Center</strong>, an established Ayurvedic healthcare organization serving patients since 2006. By accessing our website, browsing our catalog, or purchasing our premium botanical products, you agree to comply with and be bound by the following terms and conditions.
</p>

<h2 class="policy-section-title">
  <i class="bi bi-1-circle-fill"></i> 1. Acceptance of Terms &amp; Business Association
</h2>
<p class="policy-text">
  These Terms &amp; Conditions govern your use of the Power Veda web platform and all associated services. Power Veda operates with the support and experience of M.C.D.C.R. Vaidraj Disease Eradication Center in areas including Ayurvedic wellness knowledge, product development, healthcare guidance, quality-focused processes, customer support, and business operations.
</p>

<h2 class="policy-section-title">
  <i class="bi bi-2-circle-fill"></i> 2. Botanical Wellness &amp; Health Disclaimer
</h2>
<p class="policy-text">
  All Power Veda formulations are crafted with pure natural botanicals and manufactured under strict AYUSH guidelines with healthcare heritage backed by M.C.D.C.R. Vaidraj Disease Eradication Center.
</p>
<div class="policy-highlight-box mb-4">
  <strong style="color: var(--heading-color);">Important Medical Disclaimer:</strong> The statements and products on this website have not been evaluated as medical pharmaceuticals to diagnose, treat, cure, or prevent any clinical disease. Consult your qualified physician before beginning any new botanical wellness regimen if you are pregnant, nursing, or undergoing clinical treatment.
</div>

<h2 class="policy-section-title">
  <i class="bi bi-3-circle-fill"></i> 3. Ordering, Pricing, Billing &amp; Payment Processing
</h2>
<ul class="policy-list">
  <li><strong>Pricing:</strong> All prices listed are in Indian Rupees (₹ INR) and include applicable GST taxes.</li>
  <li><strong>Payment &amp; Operational Processing:</strong> Power Veda is an associated men’s wellness brand of M.C.D.C.R. Vaidraj Disease Eradication Center. Certain operational services of Power Veda, including banking, payment processing, billing, invoices, customer support, logistics or other commercial activities, may be managed through <strong>M.C.D.C.R. Vaidraj Disease Eradication Center and its authorized business accounts</strong>, wherever applicable.</li>
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
</div>',
            ],
        ];

        foreach ($pages as $page) {
            CmsPage::updateOrCreate(
                ['slug' => $page['slug']],
                [
                    'title' => $page['title'],
                    'detail' => $page['detail'],
                ]
            );
        }
    }
}
