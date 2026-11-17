<!-- Authentication Modal (Login & Register Tabs) -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg overflow-hidden rounded-3">

      <!-- Modal Header with Brand & Tabs -->
      <div class="auth-modal-header text-center">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="d-flex align-items-center">
            <img src="{{ asset('image/logo.png') }}" alt="Yuvar Dhan Logo" width="160" height="38">
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <ul class="nav nav-tabs auth-nav-tabs justify-content-center" id="authTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link auth-nav-link active" id="login-tab" data-bs-toggle="tab"
              data-bs-target="#login-panel" type="button" role="tab" aria-controls="login-panel" aria-selected="true">
              Sign In
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link auth-nav-link" id="register-tab" data-bs-toggle="tab"
              data-bs-target="#register-panel" type="button" role="tab" aria-controls="register-panel"
              aria-selected="false">
              Create Account
            </button>
          </li>
        </ul>
      </div>

      <!-- Modal Body -->
      <div class="modal-body p-4">
        <div class="tab-content" id="authTabsContent">

          <!-- Login Tab Pane -->
          <div class="tab-pane fade show active" id="login-panel" role="tabpanel" aria-labelledby="login-tab">
            <div id="login-alert" class="alert alert-danger d-none py-2 px-3 small mb-3" role="alert"></div>

            <form id="login-form" action="{{ route('login') }}" method="POST" onsubmit="handleLoginSubmit(event)">
              @csrf
              <div class="auth-input-group">
                <i class="bi bi-envelope input-icon"></i>
                <input type="text" id="login-email" name="login" placeholder="Email or Contact Number" required
                  autocomplete="username">
              </div>

              <div class="auth-input-group">
                <i class="bi bi-lock input-icon"></i>
                <input type="password" id="login-password" name="password" placeholder="Enter Password" required
                  autocomplete="current-password">
                <button type="button" class="auth-toggle-pwd"
                  onclick="togglePasswordVisibility('login-password', this)" title="Show/Hide Password">
                  <i class="bi bi-eye"></i>
                </button>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me" name="remember" checked>
                  <label class="form-check-label small" for="remember-me" style="color: var(--text-color);">
                    Remember Me
                  </label>
                </div>
                <a href="javascript:void(0)" class="small text-decoration-none"
                  style="color: var(--secondary-color); font-weight: 600;"
                  onclick="showToast('Password reset link sent to your registered email.', 'info')">
                  Forgot Password?
                </a>
              </div>

              <button type="submit" class="btn btn-primary w-100 py-2 mb-3" id="login-submit-btn">
                <span class="spinner-border spinner-border-sm me-2 d-none" id="login-spinner"></span>
                <i class="bi bi-box-arrow-in-right"></i> SIGN IN TO Yuvar Dhan
              </button>

              <div class="auth-divider">
                <span>or quick access</span>
              </div>

              <div class="d-flex gap-2">
                <button type="button"
                  class="btn btn-outline-secondary w-100 py-2 d-flex align-items-center justify-content-center gap-2"
                  style="font-size: 0.85rem; font-weight: 600;"
                  onclick="switchAuthTab('register')">
                  <i class="bi bi-person-plus text-warning"></i> New Customer? Register
                </button>
              </div>
            </form>
          </div>

          <!-- Register Tab Pane -->
          <div class="tab-pane fade" id="register-panel" role="tabpanel" aria-labelledby="register-tab">
            <div id="register-alert" class="alert alert-danger d-none py-2 px-3 small mb-3" role="alert"></div>

            <form id="register-form" action="{{ route('register') }}" method="POST" onsubmit="handleRegisterSubmit(event)">
              @csrf
              <div class="auth-input-group">
                <i class="bi bi-person input-icon"></i>
                <input type="text" id="reg-name" name="name" placeholder="Full Name (e.g. Rahul Sharma)" required autocomplete="name">
              </div>

              <div class="auth-input-group">
                <i class="bi bi-envelope input-icon"></i>
                <input type="email" id="reg-email" name="email" placeholder="Email Address (e.g. rahul@example.com)" required autocomplete="email">
              </div>

              <div class="auth-input-group">
                <i class="bi bi-telephone input-icon"></i>
                <input type="tel" id="reg-phone" name="contactNo" placeholder="Contact Number (e.g. +91 98765 43210)" required autocomplete="tel">
              </div>

              <div class="auth-input-group">
                <i class="bi bi-lock input-icon"></i>
                <input type="password" id="reg-password" name="password" placeholder="Create Password (min 6 characters)" required minlength="6"
                  autocomplete="new-password">
                <button type="button" class="auth-toggle-pwd" onclick="togglePasswordVisibility('reg-password', this)"
                  title="Show/Hide Password">
                  <i class="bi bi-eye"></i>
                </button>
              </div>

              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="reg-agree" required checked>
                <label class="form-check-label small" for="reg-agree" style="color: var(--text-color);">
                  I agree to Yuvar Dhan <a href="{{ route('terms') }}" class="text-decoration-none fw-bold"
                    style="color: var(--secondary-color);">Terms of Service</a> &amp; Natural Wellness Pledge.
                </label>
              </div>

              <button type="submit" class="btn btn-primary w-100 py-2 mb-2" id="register-submit-btn">
                <span class="spinner-border spinner-border-sm me-2 d-none" id="register-spinner"></span>
                <i class="bi bi-person-plus-fill"></i> CREATE Yuvar Dhan ACCOUNT
              </button>
            </form>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>
