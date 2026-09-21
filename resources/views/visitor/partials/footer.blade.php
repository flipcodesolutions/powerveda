<!-- Footer Section (Deep Navy #061E43) -->
<footer class="site-footer" id="contact">
  <div class="container-custom">
    <div class="row g-4">

      <!-- Brand Col -->
      <div class="col-12 col-md-6 col-lg-4">
        <div class="d-flex align-items-center mb-3">
          <img src="{{ asset('image/logo.png') }}" alt="Power Veda Logo" class="footer-logo mb-0">
          <div class="ps-3 ms-2 border-start" style="border-color: rgba(216, 188, 141, 0.4) !important;">
            <span class="d-block"
              style="color: var(--gold-color); font-size: 0.76rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; line-height: 1.2;">
              Power Veda's
            </span>
            <span class="d-block text-white"
              style="font-size: 0.84rem; font-weight: 800; letter-spacing: 0.6px; line-height: 1.15;">
              Strength &amp; Vitality
            </span>
          </div>
        </div>
        <p class="footer-brand-text">
          Power Veda is a specialized men’s wellness brand associated with <strong>M.C.D.C.R. Vaidraj Disease Eradication Center</strong> (serving since 2006), delivering authentic Ayurvedic formulations engineered for vitality, stamina, and balance.
        </p>
        <div class="footer-social-group">
          <a href="https://facebook.com" class="social-icon-btn" target="_blank" rel="noopener noreferrer"
            aria-label="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="https://instagram.com" class="social-icon-btn" target="_blank" rel="noopener noreferrer"
            aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="https://linkedin.com" class="social-icon-btn" target="_blank" rel="noopener noreferrer"
            aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
          <a href="https://youtube.com" class="social-icon-btn" target="_blank" rel="noopener noreferrer"
            aria-label="YouTube"><i class="bi bi-youtube"></i></a>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="col-6 col-md-6 col-lg-2">
        <h4 class="footer-col-title">Quick Links</h4>
        <ul class="footer-links-list">
          <li><a href="{{ route('home') }}#home"><i class="bi bi-chevron-right small"></i> Home</a></li>
          @if((isset($products) ? $products->count() : \App\Models\Product::count()) > 1)
            <li><a href="{{ route('home') }}#shop"><i class="bi bi-chevron-right small"></i> Shop</a></li>
          @endif
          <li><a href="{{ route('home') }}#why-us"><i class="bi bi-chevron-right small"></i> Why Power Veda</a></li>
          <li><a href="{{ route('about') }}"><i class="bi bi-chevron-right small"></i> About Us</a></li>
          <li><a href="{{ route('home') }}#reviews"><i class="bi bi-chevron-right small"></i> Reviews</a></li>
          <li><a href="{{ route('home') }}#faqs"><i class="bi bi-chevron-right small"></i> FAQs</a></li>
          <li><a href="{{ route('home') }}#contact"><i class="bi bi-chevron-right small"></i> Contact</a></li>
        </ul>
      </div>

      <!-- Policies & Commitments -->
      <div class="col-6 col-md-6 col-lg-3">
        <h4 class="footer-col-title">Policies &amp; Trust</h4>
        <ul class="footer-links-list">
          <li><a href="{{ route('terms') }}"><i class="bi bi-file-earmark-text text-warning"></i> Terms &amp; Conditions</a></li>
          <li><a href="{{ route('privacy') }}"><i class="bi bi-shield-lock text-warning"></i> Privacy Policy</a></li>
          <li><a href="{{ route('refund') }}"><i class="bi bi-arrow-counterclockwise text-warning"></i> Refund &amp; Return Policy</a></li>
          <li><a href="{{ route('about') }}"><i class="bi bi-info-circle text-warning"></i> About Brand &amp; Heritage</a></li>
          <li><a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 text-warning"></i> Admin Portal</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="col-12 col-md-6 col-lg-3">
        <h4 class="footer-col-title">Contact</h4>
        <div class="footer-contact-row">
          <i class="bi bi-geo-alt-fill"></i>
          <span>108 Lotus Wellness Way, Green Valley, Mumbai 400001</span>
        </div>
        <div class="footer-contact-row">
          <i class="bi bi-telephone-fill"></i>
          <a href="tel:+918005558332" class="text-white text-decoration-none">+91 (800) 555-VEDA</a>
        </div>
        <div class="footer-contact-row">
          <i class="bi bi-envelope-fill"></i>
          <a href="mailto:support@powerveda.com" class="text-white text-decoration-none">support@powerveda.com</a>
        </div>
        <div class="footer-contact-row">
          <i class="bi bi-clock-fill"></i>
          <span>Mon - Sat: 9:00 AM - 7:00 PM IST</span>
        </div>
      </div>

    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom-bar d-flex flex-wrap justify-content-between align-items-center gap-3">
      <div>
        &copy; {{ date('Y') }} Power Veda &bull; Associated wellness brand of M.C.D.C.R. Vaidraj Disease Eradication Center (Est. 2006). All rights reserved. &bull; 
        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-warning fw-bold mx-1"><i class="bi bi-shield-lock"></i> Admin Portal</a>
      </div>
      <div class="d-flex gap-3 fs-5" style="color: var(--silver-color);">
        <i class="bi bi-shield-lock-fill" title="256-Bit SSL Secure"></i>
        <i class="bi bi-credit-card-fill" title="UPI &amp; Cards Accepted"></i>
      </div>
    </div>

  </div>
</footer>
