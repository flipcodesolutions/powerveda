<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Power Veda Admin Console. Manage botanical formulations, customer orders, and verified customer reviews.">
  <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('page_title', 'Admin Dashboard') | Power Veda HQ</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">

  <!-- Google Fonts: Syne (Headings) & Plus Jakarta Sans (Body) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Brand CSS & Admin Specific CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  @stack('styles')
</head>

<body class="admin-body">

  <!-- 1. Admin Sidebar Navigation -->
  @include('admin.partials.sidebar')

  <!-- 2. Admin Main Content Wrapper -->
  <main class="admin-main">

    <!-- Topbar -->
    @include('admin.partials.topbar')

    <!-- Admin Body Content -->
    <div class="admin-content">
      @yield('content')
    </div>

  </main>

  <!-- Common Modals -->
  @include('admin.partials.order-modal')

  <!-- Toast Notification Container -->
  <div class="toast-container-custom" id="toast-container" aria-live="polite" aria-atomic="true"></div>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Admin Script -->
  <script src="{{ asset('js/admin.js') }}"></script>
  @stack('scripts')
</body>

</html>
