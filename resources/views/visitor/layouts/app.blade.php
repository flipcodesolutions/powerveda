<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Yuvar Dhan - Premium Wellness, Strength & Vitality')</title>
  <meta name="description" content="@yield('meta_description', 'Discover Yuvar Dhan: Premium wellness formulations designed to support strength, vitality, and a healthier lifestyle. 100% natural, pure, and trustworthy.')">
  <meta name="keywords" content="@yield('meta_keywords', 'Yuvar Dhan, wellness, strength, vitality, natural, Ayurvedic, health supplements, pure formulations')">
  <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">

  <!-- Google Fonts: Playfair Display, Syne & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Bootstrap Icons CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Custom Brand Stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  @stack('styles')
</head>

<body data-bs-spy="scroll" data-bs-target="#mainNavbar" data-bs-offset="90">

  <!-- Top Announcement Bar -->
  @include('visitor.partials.announcement')

  <!-- Sticky Header Navigation -->
  @include('visitor.partials.header')

  <!-- Main Content View -->
  <main>
    @yield('content')
  </main>

  <!-- Site Footer -->
  @include('visitor.partials.footer')

  <!-- Mobile Offcanvas Drawer -->
  @include('visitor.partials.mobile-drawer')

  <!-- Authentication Modal -->
  @include('visitor.partials.auth-modal')

  <!-- My Orders Modal -->
  @include('visitor.partials.orders-modal')

  <!-- Checkout & Place Order Modal -->
  @include('visitor.partials.checkout-modal')

  <!-- Toast Notification Container -->
  <div class="toast-container-custom" id="toast-container" aria-live="polite" aria-atomic="true"></div>

  <!-- Floating Back to Top Button -->
  <button type="button" class="back-to-top-btn" id="back-to-top" aria-label="Back to top">
    <i class="bi bi-arrow-up"></i>
  </button>

  <!-- Bootstrap 5 Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <!-- Custom JavaScript Logic -->
  <script src="{{ asset('js/script.js') }}"></script>
  @stack('scripts')
</body>

</html>
