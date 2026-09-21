<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
  <title>Admin Sign In | Power Veda Console</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Base Brand CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

  <style>
    body.admin-login-body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: radial-gradient(circle at 10% 20%, rgba(6, 30, 67, 0.98) 0%, rgba(2, 13, 30, 1) 100%);
      padding: 1.5rem;
      position: relative;
      overflow-x: hidden;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    body.admin-login-body::before {
      content: '';
      position: absolute;
      width: 450px;
      height: 450px;
      background: radial-gradient(circle, rgba(216, 188, 141, 0.12) 0%, rgba(216, 188, 141, 0) 70%);
      top: -100px;
      right: -100px;
      border-radius: 50%;
      pointer-events: none;
    }

    body.admin-login-body::after {
      content: '';
      position: absolute;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(16, 60, 128, 0.15) 0%, rgba(16, 60, 128, 0) 70%);
      bottom: -150px;
      left: -150px;
      border-radius: 50%;
      pointer-events: none;
    }

    .login-card {
      width: 100%;
      max-width: 440px;
      background: rgba(255, 255, 255, 0.04);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(216, 188, 141, 0.2);
      border-radius: 20px;
      padding: 2.5rem 2rem;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.45);
      position: relative;
      z-index: 2;
    }

    .login-brand {
      text-align: center;
      margin-bottom: 2rem;
    }

    .login-brand img {
      max-height: 48px;
      filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.3));
      margin-bottom: 0.75rem;
    }

    .login-brand h1 {
      font-family: 'Syne', sans-serif;
      font-size: 1.4rem;
      font-weight: 800;
      color: #ffffff;
      margin-bottom: 0.25rem;
      letter-spacing: -0.5px;
    }

    .login-brand p {
      font-size: 0.82rem;
      color: var(--gold-color, #D8BC8D);
      font-weight: 600;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin: 0;
    }

    .form-control-custom {
      background: rgba(255, 255, 255, 0.07);
      border: 1px solid rgba(255, 255, 255, 0.15);
      color: #ffffff;
      padding: 0.75rem 1rem 0.75rem 2.75rem;
      border-radius: 10px;
      font-size: 0.9rem;
      transition: all 0.25s ease;
    }

    .form-control-custom:focus {
      background: rgba(255, 255, 255, 0.12);
      border-color: var(--gold-color, #D8BC8D);
      color: #ffffff;
      box-shadow: 0 0 0 3px rgba(216, 188, 141, 0.25);
    }

    .form-control-custom::placeholder {
      color: rgba(255, 255, 255, 0.45);
    }

    .input-icon-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      top: 50%;
      left: 1rem;
      transform: translateY(-50%);
      color: var(--gold-color, #D8BC8D);
      font-size: 1.05rem;
      pointer-events: none;
      z-index: 3;
    }

    .password-toggle-btn {
      position: absolute;
      top: 50%;
      right: 0.75rem;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: rgba(255, 255, 255, 0.5);
      cursor: pointer;
      font-size: 1.05rem;
      padding: 0.25rem;
      z-index: 4;
      transition: color 0.2s ease;
    }

    .password-toggle-btn:hover {
      color: #ffffff;
    }

    .btn-admin-submit {
      background: linear-gradient(135deg, #E0C79B 0%, #C4A46C 100%);
      color: #061E43;
      font-weight: 700;
      font-size: 0.95rem;
      letter-spacing: 0.5px;
      border: none;
      padding: 0.85rem 1.5rem;
      border-radius: 10px;
      width: 100%;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(216, 188, 141, 0.25);
    }

    .btn-admin-submit:hover {
      background: linear-gradient(135deg, #eed5aa 0%, #d4b47a 100%);
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(216, 188, 141, 0.4);
      color: #061E43;
    }

    .btn-admin-submit:active {
      transform: translateY(0);
    }

    .login-footer-link {
      color: rgba(255, 255, 255, 0.6);
      text-decoration: none;
      font-size: 0.82rem;
      transition: color 0.2s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
    }

    .login-footer-link:hover {
      color: var(--gold-color, #D8BC8D);
    }

    .alert-custom-danger {
      background: rgba(220, 53, 69, 0.15);
      border: 1px solid rgba(220, 53, 69, 0.3);
      color: #ff858d;
      border-radius: 10px;
      font-size: 0.85rem;
      padding: 0.75rem 1rem;
    }

    .alert-custom-success {
      background: rgba(40, 167, 69, 0.15);
      border: 1px solid rgba(40, 167, 69, 0.3);
      color: #75e694;
      border-radius: 10px;
      font-size: 0.85rem;
      padding: 0.75rem 1rem;
    }

    .demo-credentials {
      background: rgba(255, 255, 255, 0.03);
      border: 1px dashed rgba(216, 188, 141, 0.25);
      border-radius: 8px;
      padding: 0.6rem 0.8rem;
      margin-top: 1.5rem;
      font-size: 0.75rem;
      color: rgba(255, 255, 255, 0.65);
    }
  </style>
</head>

<body class="admin-login-body">

  <div class="login-card">

    <!-- Brand Header -->
    <div class="login-brand">
      <a href="{{ route('home') }}">
        <img src="{{ asset('image/logo.png') }}" alt="Power Veda Logo">
      </a>
      <h1>Admin Console</h1>
      <p>Authorized Personnel Only</p>
    </div>

    <!-- Error / Success Messages -->
    @if (session('error'))
      <div class="alert alert-custom-danger d-flex align-items-center gap-2 mb-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
        <div>{{ session('error') }}</div>
      </div>
    @endif

    @if (session('success'))
      <div class="alert alert-custom-success d-flex align-items-center gap-2 mb-3" role="alert">
        <i class="bi bi-check-circle-fill flex-shrink-0"></i>
        <div>{{ session('success') }}</div>
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-custom-danger mb-3" role="alert">
        <div class="d-flex align-items-center gap-2 mb-1">
          <i class="bi bi-shield-x flex-shrink-0"></i>
          <strong>Authentication Failed</strong>
        </div>
        <ul class="mb-0 ps-3 small">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Login Form -->
    <form action="{{ route('admin.login.submit') }}" method="POST" autocomplete="on">
      @csrf

      <!-- Email Field -->
      <div class="mb-3">
        <label for="admin-email" class="form-label text-white small fw-semibold mb-1">
          Administrator Email
        </label>
        <div class="input-icon-wrapper">
          <i class="bi bi-envelope input-icon"></i>
          <input type="email" name="email" id="admin-email"
            class="form-control form-control-custom @error('email') is-invalid @enderror"
            placeholder="admin@powerveda.com"
            value="{{ old('email', 'admin@powerveda.com') }}"
            required autofocus autocomplete="username">
        </div>
      </div>

      <!-- Password Field -->
      <div class="mb-3">
        <label for="admin-password" class="form-label text-white small fw-semibold mb-1">
          Password
        </label>
        <div class="input-icon-wrapper">
          <i class="bi bi-shield-lock input-icon"></i>
          <input type="password" name="password" id="admin-password"
            class="form-control form-control-custom @error('password') is-invalid @enderror"
            placeholder="••••••••••••"
            required autocomplete="current-password">
          <button type="button" class="password-toggle-btn" id="password-toggle" aria-label="Toggle Password Visibility">
            <i class="bi bi-eye" id="toggle-icon"></i>
          </button>
        </div>
      </div>

      <!-- Remember Me -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="remember" id="remember"
            {{ old('remember') ? 'checked' : '' }}
            style="background-color: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2);">
          <label class="form-check-label text-white-50 small" for="remember">
            Keep me signed in
          </label>
        </div>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-admin-submit" id="admin-login-btn">
        <i class="bi bi-box-arrow-in-right me-2"></i> Access Admin Console
      </button>
    </form>

    <!-- Credentials Reference Box -->
    <div class="demo-credentials text-center">
      <div class="fw-bold mb-1" style="color: var(--gold-color, #D8BC8D);">
        <i class="bi bi-info-circle me-1"></i> Admin Access Credentials
      </div>
      <div>Email: <code style="color: #fff;">admin@powerveda.com</code></div>
      <div>Password: <code style="color: #fff;">Admin@12345</code></div>
    </div>

    <!-- Back to Storefront Link -->
    <div class="text-center mt-4">
      <a href="{{ route('home') }}" class="login-footer-link">
        <i class="bi bi-arrow-left"></i> Return to Live Storefront
      </a>
    </div>

  </div>

  <script>
    // Password visibility toggle
    document.addEventListener('DOMContentLoaded', function () {
      const toggleBtn = document.getElementById('password-toggle');
      const passwordInput = document.getElementById('admin-password');
      const toggleIcon = document.getElementById('toggle-icon');

      if (toggleBtn && passwordInput && toggleIcon) {
        toggleBtn.addEventListener('click', function () {
          const isPassword = passwordInput.type === 'password';
          passwordInput.type = isPassword ? 'text' : 'password';
          toggleIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
      }
    });
  </script>
</body>

</html>
