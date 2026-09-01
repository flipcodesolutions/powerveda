@extends('visitor.layouts.app')

@section('title', 'My Account & Orders - Power Veda')
@section('meta_description', 'Manage your Power Veda orders, tracking status, profile details, and delivery addresses in your personalized wellness account.')

@section('content')
<!-- My Account Page Section -->
<section class="account-page-section py-5 bg-white" style="min-height: 80vh;">
  <div class="container-custom">

    <!-- Page Title Header -->
    <div class="account-header mb-4 pb-2">
      <h1 class="h2 fw-bold text-dark mb-1" style="font-family: var(--font-heading); letter-spacing: -0.5px;">My Account</h1>
      <p class="text-muted small mb-0">Manage your orders, profile, and preferences.</p>
    </div>

    <!-- Main Account Grid: Sidebar Navigation + Content Area -->
    <div class="row g-4 g-lg-5 align-items-start">

      <!-- Left Sidebar Navigation (Vertical Pills) -->
      <div class="col-12 col-md-4 col-lg-3">
        <div class="account-nav-sidebar pe-md-3 border-end">
          <ul class="nav flex-column account-nav-pills gap-1" id="accountTabs" role="tablist">
            
            <!-- 1. Overview Tab -->
            <li class="nav-item" role="presentation">
              <button class="nav-link account-nav-btn active w-100 text-start" id="tab-btn-overview" data-bs-toggle="pill" data-bs-target="#account-tab-overview" type="button" role="tab" aria-controls="account-tab-overview" aria-selected="true">
                Overview
              </button>
            </li>

            <!-- 2. Order History Tab -->
            <li class="nav-item" role="presentation">
              <button class="nav-link account-nav-btn w-100 text-start" id="tab-btn-orders" data-bs-toggle="pill" data-bs-target="#account-tab-orders" type="button" role="tab" aria-controls="account-tab-orders" aria-selected="false">
                Order History
              </button>
            </li>

            <!-- 3. Profile Details Tab -->
            <li class="nav-item" role="presentation">
              <button class="nav-link account-nav-btn w-100 text-start" id="tab-btn-profile" data-bs-toggle="pill" data-bs-target="#account-tab-profile" type="button" role="tab" aria-controls="account-tab-profile" aria-selected="false">
                Profile Details
              </button>
            </li>

            <!-- 4. Addresses Tab -->
            <li class="nav-item" role="presentation">
              <button class="nav-link account-nav-btn w-100 text-start" id="tab-btn-addresses" data-bs-toggle="pill" data-bs-target="#account-tab-addresses" type="button" role="tab" aria-controls="account-tab-addresses" aria-selected="false">
                Addresses
              </button>
            </li>

            <!-- 5. Dynamic Auth Option: Log Out or Sign In -->
            <li class="nav-item pt-2 mt-2 border-top" role="presentation">
              <button class="nav-link account-nav-btn w-100 text-start {{ auth()->check() ? 'd-none' : '' }}" id="account-sidebar-signin-btn" type="button" data-bs-toggle="modal" data-bs-target="#authModal">
                Sign In / Register
              </button>
              <button class="nav-link account-nav-btn w-100 text-start text-danger {{ auth()->check() ? '' : 'd-none' }}" id="account-sidebar-logout-btn" type="button" onclick="handleLogout()">
                Log Out
              </button>
            </li>

          </ul>
        </div>
      </div>

      <!-- Right Main Content Panel (Tab Panes) -->
      <div class="col-12 col-md-8 col-lg-9">
        <div class="tab-content" id="accountTabContent">

          <!-- ========================================================
               TAB 1: OVERVIEW
               ======================================================== -->
          <div class="tab-pane fade show active" id="account-tab-overview" role="tabpanel" aria-labelledby="tab-btn-overview" tabindex="0">
            
            <!-- Greeting -->
            <div class="mb-4">
              <h2 class="h3 fw-bold text-dark mb-1" style="font-family: var(--font-heading);">
                Welcome back, <span id="overview-display-name">{{ auth()->check() ? explode(' ', auth()->user()->name)[0] : 'Sarah' }}</span>
              </h2>
              <p class="text-muted small mb-0">Here's an overview of your account.</p>
            </div>

            <!-- Two Cards: Recent Order + Profile Summary -->
            <div class="row g-4 mb-4">

              <!-- Card 1: Recent Order -->
              <div class="col-12 col-lg-6">
                <div class="card h-100 border rounded-3 p-4 shadow-sm account-summary-card">
                  
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="h5 fw-bold text-dark mb-0">Recent Order</h3>
                    <a href="javascript:void(0)" class="small text-decoration-none fw-semibold" style="color: #0d6efd;" onclick="switchAccountTab('orders')">
                      View All
                    </a>
                  </div>

                  @if(isset($orders) && $orders->isNotEmpty())
                    @php $latestOrder = $orders->first(); @endphp
                    <div class="small text-muted mb-2">
                      Order <strong class="text-dark">#{{ $latestOrder->order_number }}</strong> &bull; Placed on {{ $latestOrder->created_at->format('d M Y') }}
                    </div>

                    <div class="small mb-3">
                      Status: <span class="badge {{ $latestOrder->status_badge_class }} py-1 px-2 fw-semibold">{{ $latestOrder->status }}</span>
                    </div>

                    @if($latestOrder->items->isNotEmpty())
                      @php $firstItem = $latestOrder->items->first(); @endphp
                      <div class="d-flex align-items-center gap-3 p-2 rounded-2 bg-light border">
                        <img src="{{ $firstItem->photo_url }}" alt="{{ $firstItem->product_name }}" class="rounded border" style="width: 64px; height: 64px; object-fit: cover;">
                        <div class="flex-grow-1">
                          <strong class="d-block text-dark small">{{ $firstItem->product_name }}</strong>
                          <span class="text-muted small d-block">Qty: {{ $firstItem->qty }} @if($latestOrder->items->count() > 1) &bull; +{{ $latestOrder->items->count() - 1 }} more item(s) @endif</span>
                          <span class="fw-bold text-dark small">₹{{ number_format($latestOrder->total_amount, 0) }}</span>
                        </div>
                      </div>
                    @endif
                  @else
                    <div class="text-center py-4 text-muted">
                      <i class="bi bi-bag-check fs-2 text-muted d-block mb-2"></i>
                      <p class="small mb-2">You have not placed any orders yet.</p>
                      <a href="{{ route('home') }}#shop" class="btn btn-sm btn-primary">Start Shopping</a>
                    </div>
                  @endif

                </div>
              </div>

              <!-- Card 2: Profile -->
              <div class="col-12 col-lg-6">
                <div class="card h-100 border rounded-3 p-4 shadow-sm account-summary-card">
                  
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="h5 fw-bold text-dark mb-0">Profile</h3>
                    <a href="javascript:void(0)" class="small text-decoration-none fw-semibold" style="color: #0d6efd;" onclick="switchAccountTab('profile')">
                      Edit
                    </a>
                  </div>

                  <div class="d-flex flex-column gap-2 text-secondary small pt-1">
                    <div class="fw-bold text-dark fs-6" id="overview-full-name">
                      {{ auth()->check() ? auth()->user()->name : 'User' }}
                    </div>
                    <div id="overview-email" class="text-muted">
                      {{ auth()->check() ? auth()->user()->email : '' }}
                    </div>
                    <div id="overview-phone" class="text-muted">
                      {{ auth()->check() ? auth()->user()->contactNo : '' }}
                    </div>
                  </div>

                  <div class="mt-4 pt-2 border-top d-flex justify-content-between align-items-center">
                    <span class="small text-muted">Role: <strong class="text-dark">{{ auth()->check() ? auth()->user()->role : 'User' }}</strong></span>
                    @if(auth()->check() && auth()->user()->isAdmin())
                      <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-primary py-1 px-2" style="font-size: 0.75rem;">
                        <i class="bi bi-speedometer2"></i> Admin Panel
                      </a>
                    @endif
                  </div>

                </div>
              </div>

            </div>

          </div>

          <!-- ========================================================
               TAB 2: ORDER HISTORY
               ======================================================== -->
          <div class="tab-pane fade" id="account-tab-orders" role="tabpanel" aria-labelledby="tab-btn-orders" tabindex="0">
            
            <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
              <div>
                <h2 class="h3 fw-bold text-dark mb-1" style="font-family: var(--font-heading);">Order History</h2>
                <p class="text-muted small mb-0">Track real-time shipment status, download invoices, or re-order your favorite formulations.</p>
              </div>
              <span class="badge bg-light text-dark border px-3 py-2 fs-6">
                {{ isset($orders) ? $orders->count() : 0 }} Total {{ (isset($orders) && $orders->count() === 1) ? 'Order' : 'Orders' }}
              </span>
            </div>

            @if(isset($orders) && $orders->isNotEmpty())
              @foreach($orders as $order)
                <div class="card border rounded-3 p-4 mb-4 shadow-sm">
                  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pb-3 border-bottom mb-3">
                    <div>
                      <span class="badge bg-light text-dark border fs-6 me-2">#{{ $order->order_number }}</span>
                      <span class="text-muted small">&bull; Placed on {{ $order->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    <span class="badge {{ $order->status_badge_class }} py-2 px-3 fw-semibold">
                      @if(strtolower($order->status) === 'delivered')
                        <i class="bi bi-check-circle-fill me-1"></i> Delivered
                      @elseif(strtolower($order->status) === 'in transit')
                        <i class="bi bi-truck me-1"></i> In Transit
                      @elseif(strtolower($order->status) === 'cancelled')
                        <i class="bi bi-x-circle me-1"></i> Cancelled
                      @else
                        <i class="bi bi-hourglass-split me-1"></i> Processing
                      @endif
                    </span>
                  </div>

                  <!-- Items in Order -->
                  @foreach($order->items as $item)
                    <div class="d-flex align-items-center gap-3 p-2 rounded-2 bg-light border mb-2">
                      <img src="{{ $item->photo_url }}" alt="{{ $item->product_name }}" class="rounded border" style="width: 58px; height: 58px; object-fit: cover;">
                      <div class="flex-grow-1">
                        <strong class="d-block text-dark small">{{ $item->product_name }}</strong>
                        <span class="text-muted small">Qty: {{ $item->qty }} &bull; ₹{{ number_format($item->price, 0) }} each</span>
                      </div>
                      <div class="fw-bold text-dark">₹{{ number_format($item->item_total, 0) }}</div>
                    </div>
                  @endforeach

                  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pt-2 border-top mt-2">
                    <div>
                      <span class="text-muted small">Delivery Address:</span>
                      <span class="small fw-medium text-dark ms-1">{{ $order->formatted_address }}</span>
                      <div class="mt-1">
                        <span class="text-muted small">Total Paid:</span>
                        <strong class="text-dark ms-1 fs-6">₹{{ number_format($order->total_amount, 0) }}</strong>
                        <span class="badge bg-light text-dark border ms-2">{{ $order->payment_method }}</span>
                      </div>
                    </div>
                    <div class="d-flex gap-2">
                      <button class="btn btn-sm btn-outline-secondary" onclick="showToast('Downloading Tax Invoice for #{{ $order->order_number }}...', 'info')">
                        <i class="bi bi-file-earmark-arrow-down"></i> Invoice
                      </button>
                      <button class="btn btn-sm btn-primary" onclick="showToast('Order #{{ $order->order_number }} is currently {{ $order->status }}.', 'info')">
                        <i class="bi bi-geo-alt-fill"></i> Track
                      </button>
                    </div>
                  </div>
                </div>
              @endforeach
            @else
              <div class="card border rounded-3 p-5 text-center shadow-sm">
                <div class="py-4">
                  <i class="bi bi-bag-x fs-1 text-muted d-block mb-3"></i>
                  <h4 class="fw-bold text-dark mb-2">No Orders Placed Yet</h4>
                  <p class="text-muted small mb-4">When you place orders for Power Veda formulations, they will appear here with live tracking &amp; tax invoices.</p>
                  <a href="{{ route('home') }}#shop" class="btn btn-primary">
                    <i class="bi bi-bag-plus-fill me-1"></i> Browse Formulations
                  </a>
                </div>
              </div>
            @endif

          </div>

          <!-- ========================================================
               TAB 3: PROFILE DETAILS
               ======================================================== -->
          <div class="tab-pane fade" id="account-tab-profile" role="tabpanel" aria-labelledby="tab-btn-profile" tabindex="0">
            
            <div class="mb-4">
              <h2 class="h3 fw-bold text-dark mb-1" style="font-family: var(--font-heading);">Profile Details</h2>
              <p class="text-muted small mb-0">Update your account information, primary phone, or security credentials.</p>
            </div>

            <div class="card border rounded-3 p-4 shadow-sm" style="max-width: 680px;">
              <div id="profile-update-alert" class="alert alert-success d-none py-2 px-3 small mb-3"></div>

              <form id="profile-update-form" onsubmit="handleProfileUpdateSubmit(event)">
                @csrf
                <div class="row g-3">
                  <div class="col-12">
                    <label for="profile-name-input" class="form-label small fw-bold text-uppercase text-muted">Full Name</label>
                    <input type="text" class="form-control" id="profile-name-input" name="name" value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                  </div>

                  <div class="col-12 col-md-6">
                    <label for="profile-email-input" class="form-label small fw-bold text-uppercase text-muted">Email Address</label>
                    <input type="email" class="form-control" id="profile-email-input" name="email" value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
                  </div>

                  <div class="col-12 col-md-6">
                    <label for="profile-phone-input" class="form-label small fw-bold text-uppercase text-muted">Contact Phone Number</label>
                    <input type="tel" class="form-control" id="profile-phone-input" name="contactNo" value="{{ auth()->check() ? auth()->user()->contactNo : '' }}" required>
                  </div>

                  <div class="col-12">
                    <label for="profile-password-input" class="form-label small fw-bold text-uppercase text-muted">New Password <span class="text-muted fw-normal">(Leave blank to keep current)</span></label>
                    <input type="password" class="form-control" id="profile-password-input" name="password" placeholder="••••••••">
                  </div>

                  <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold" id="profile-save-btn">
                      <span class="spinner-border spinner-border-sm me-2 d-none" id="profile-spinner"></span>
                      Save Changes
                    </button>
                  </div>
                </div>
              </form>
            </div>

          </div>

          <!-- ========================================================
               TAB 4: ADDRESSES
               ======================================================== -->
          <div class="tab-pane fade" id="account-tab-addresses" role="tabpanel" aria-labelledby="tab-btn-addresses" tabindex="0">
            
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
              <div>
                <h2 class="h3 fw-bold text-dark mb-1" style="font-family: var(--font-heading);">Saved Addresses</h2>
                <p class="text-muted small mb-0">Manage your shipping and billing delivery destinations.</p>
              </div>
              <button type="button" class="btn btn-outline-primary btn-sm px-3 fw-semibold" onclick="openAddAddressModal()">
                <i class="bi bi-plus-circle me-1"></i> Add New Address
              </button>
            </div>

            <!-- Addresses List Container -->
            <div class="row g-3" id="addresses-list-container">
              @forelse($addresses as $addr)
                <div class="col-12 col-md-6" id="address-col-{{ $addr->id }}">
                  <div class="card border rounded-3 p-4 shadow-sm h-100 position-relative address-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <div class="d-flex align-items-center gap-1 flex-wrap">
                        @if($addr->is_default)
                          <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 small fw-semibold">
                            <i class="bi bi-check2"></i> Default Delivery
                          </span>
                        @else
                          <button type="button" class="btn btn-link text-muted p-0 text-decoration-none small" onclick="handleSetDefaultAddress({{ $addr->id }})">
                            <i class="bi bi-circle me-1"></i> Set Default
                          </button>
                        @endif
                        @if($addr->type)
                          <span class="badge bg-light text-secondary border px-2 py-1 small">{{ $addr->type }}</span>
                        @endif
                      </div>
                      <div class="d-flex align-items-center gap-3">
                        <button type="button" class="btn btn-link text-primary p-0 text-decoration-none small fw-semibold" onclick="openEditAddressModal({{ json_encode($addr) }})">Edit</button>
                        <button type="button" class="btn btn-link text-danger p-0 text-decoration-none small fw-semibold" onclick="handleDeleteAddress({{ $addr->id }})">Delete</button>
                      </div>
                    </div>
                    <strong class="text-dark d-block mt-2 fs-6">{{ $addr->recipient_name }}</strong>
                    <p class="text-muted small mb-2" style="line-height: 1.6;">
                      {{ $addr->address_line_1 }}@if($addr->address_line_2), {{ $addr->address_line_2 }}@endif,<br>
                      {{ $addr->city }}, {{ $addr->state }} - {{ $addr->pincode }}
                    </p>
                    <div class="small text-muted mt-auto pt-2">
                      <i class="bi bi-telephone me-1 text-success"></i> <span>{{ $addr->contactNo }}</span>
                    </div>
                  </div>
                </div>
              @empty
                <div class="col-12" id="no-addresses-placeholder">
                  <div class="text-center py-5 border rounded-3 bg-light">
                    <i class="bi bi-geo-alt fs-1 text-muted d-block mb-2"></i>
                    <h5 class="fw-bold text-dark">No Saved Addresses</h5>
                    <p class="text-muted small mb-3">You haven't added any delivery addresses yet.</p>
                    <button type="button" class="btn btn-primary btn-sm px-4 fw-semibold" onclick="openAddAddressModal()">
                      <i class="bi bi-plus-circle me-1"></i> Add Address
                    </button>
                  </div>
                </div>
              @endforelse
            </div>

          </div>

        </div>
      </div>

    </div>

  </div>
</section>

<!-- Add / Edit Address Modal -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content auth-modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
      <div class="modal-header auth-modal-header border-0 pb-0">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-geo-alt-fill fs-4" style="color: var(--gold-color);"></i>
          <h5 class="modal-title fw-bold text-white" id="addressModalLabel">Add New Address</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4 bg-white">
        <div id="address-modal-alert" class="alert alert-danger d-none py-2 px-3 small mb-3"></div>

        <form id="address-form" onsubmit="handleAddressFormSubmit(event)">
          <input type="hidden" id="address-id" value="">

          <div class="row g-3">
            <div class="col-12 col-md-6">
              <label for="address-recipient" class="form-label small fw-bold text-uppercase text-muted">Recipient Full Name *</label>
              <input type="text" class="form-control" id="address-recipient" placeholder="e.g. Gohil Ravirajsinh" required>
            </div>

            <div class="col-12 col-md-6">
              <label for="address-contact" class="form-label small fw-bold text-uppercase text-muted">Contact Phone Number *</label>
              <input type="tel" class="form-control" id="address-contact" placeholder="e.g. +91 9979404044" required>
            </div>

            <div class="col-12">
              <label for="address-line1" class="form-label small fw-bold text-uppercase text-muted">Flat / House No. / Building / Street *</label>
              <input type="text" class="form-control" id="address-line1" placeholder="e.g. Flat 402, Lotus Residency" required>
            </div>

            <div class="col-12">
              <label for="address-line2" class="form-label small fw-bold text-uppercase text-muted">Area / Landmark / Street 2 (Optional)</label>
              <input type="text" class="form-control" id="address-line2" placeholder="e.g. Near Green Park">
            </div>

            <div class="col-12 col-md-4">
              <label for="address-city" class="form-label small fw-bold text-uppercase text-muted">City *</label>
              <input type="text" class="form-control" id="address-city" placeholder="Mumbai" required>
            </div>

            <div class="col-12 col-md-4">
              <label for="address-state" class="form-label small fw-bold text-uppercase text-muted">State *</label>
              <input type="text" class="form-control" id="address-state" placeholder="Maharashtra" required>
            </div>

            <div class="col-12 col-md-4">
              <label for="address-pincode" class="form-label small fw-bold text-uppercase text-muted">Pincode *</label>
              <input type="text" class="form-control" id="address-pincode" placeholder="400001" required>
            </div>

            <div class="col-12 col-md-6">
              <label for="address-type" class="form-label small fw-bold text-uppercase text-muted">Address Type</label>
              <select class="form-select" id="address-type">
                <option value="Home">Home (All day delivery)</option>
                <option value="Work">Work / Office (9 AM - 6 PM)</option>
                <option value="Other">Other</option>
              </select>
            </div>

            <div class="col-12 col-md-6 d-flex align-items-center pt-md-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="address-is-default">
                <label class="form-check-label small fw-semibold" for="address-is-default">
                  Set as default address
                </label>
              </div>
            </div>

            <div class="col-12 mt-4">
              <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" id="address-submit-btn">
                <span class="spinner-border spinner-border-sm me-2 d-none" id="address-spinner"></span>
                SAVE ADDRESS
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  let userAddresses = @json($addresses);

  function switchAccountTab(tabKey) {
    const tabBtn = document.getElementById(`tab-btn-${tabKey}`);
    if (tabBtn) {
      const tab = new bootstrap.Tab(tabBtn);
      tab.show();
      window.scrollTo({ top: 120, behavior: 'smooth' });
    }
  }

  // Handle Profile Update Submission
  async function handleProfileUpdateSubmit(event) {
    event.preventDefault();
    const alertEl = document.getElementById('profile-update-alert');
    const spinner = document.getElementById('profile-spinner');
    const saveBtn = document.getElementById('profile-save-btn');

    const name = document.getElementById('profile-name-input').value.trim();
    const email = document.getElementById('profile-email-input').value.trim();
    const contactNo = document.getElementById('profile-phone-input').value.trim();
    const password = document.getElementById('profile-password-input').value;

    if (spinner) spinner.classList.remove('d-none');
    if (saveBtn) saveBtn.disabled = true;

    try {
      const res = await fetch('/user/profile', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({ name, email, contactNo, password: password || undefined })
      });

      const data = await res.json();
      if (res.ok && data.success) {
        currentUser = data.user;
        localStorage.setItem('powerveda_user', JSON.stringify(data.user));
        updateAccountUI();

        // Update Overview Card
        const overviewName = document.getElementById('overview-display-name');
        const overviewFullName = document.getElementById('overview-full-name');
        const overviewEmail = document.getElementById('overview-email');
        const overviewPhone = document.getElementById('overview-phone');

        if (overviewName) overviewName.innerText = (data.user.name || '').split(' ')[0];
        if (overviewFullName) overviewFullName.innerText = data.user.name;
        if (overviewEmail) overviewEmail.innerText = data.user.email;
        if (overviewPhone) overviewPhone.innerText = data.user.contactNo;

        if (alertEl) {
          alertEl.innerText = data.message || 'Profile updated successfully!';
          alertEl.classList.remove('d-none');
        }
        showToast(data.message || 'Profile updated successfully!', 'success');
      } else {
        const msg = (data.errors && Object.values(data.errors).flat()[0]) || data.message || 'Failed to update profile.';
        showToast(msg, 'error');
      }
    } catch (err) {
      showToast('Network error while updating profile.', 'error');
    } finally {
      if (spinner) spinner.classList.add('d-none');
      if (saveBtn) saveBtn.disabled = false;
    }
  }

  // Render Addresses Grid in DOM
  function renderAddressesGrid() {
    const container = document.getElementById('addresses-list-container');
    if (!container) return;

    if (!userAddresses || userAddresses.length === 0) {
      container.innerHTML = `
        <div class="col-12" id="no-addresses-placeholder">
          <div class="text-center py-5 border rounded-3 bg-light">
            <i class="bi bi-geo-alt fs-1 text-muted d-block mb-2"></i>
            <h5 class="fw-bold text-dark">No Saved Addresses</h5>
            <p class="text-muted small mb-3">You haven't added any delivery addresses yet.</p>
            <button type="button" class="btn btn-primary btn-sm px-4 fw-semibold" onclick="openAddAddressModal()">
              <i class="bi bi-plus-circle me-1"></i> Add Address
            </button>
          </div>
        </div>
      `;
      return;
    }

    container.innerHTML = userAddresses.map(addr => `
      <div class="col-12 col-md-6" id="address-col-${addr.id}">
        <div class="card border rounded-3 p-4 shadow-sm h-100 position-relative address-card">
          <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="d-flex align-items-center gap-1 flex-wrap">
              ${addr.is_default ? `
                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 small fw-semibold">
                  <i class="bi bi-check2"></i> Default Delivery
                </span>
              ` : `
                <button type="button" class="btn btn-link text-muted p-0 text-decoration-none small" onclick="handleSetDefaultAddress(${addr.id})">
                  <i class="bi bi-circle me-1"></i> Set Default
                </button>
              `}
              ${addr.type ? `<span class="badge bg-light text-secondary border px-2 py-1 small">${addr.type}</span>` : ''}
            </div>
            <div class="d-flex align-items-center gap-3">
              <button type="button" class="btn btn-link text-primary p-0 text-decoration-none small fw-semibold" onclick='openEditAddressModal(${JSON.stringify(addr).replace(/'/g, "&#39;")})'>Edit</button>
              <button type="button" class="btn btn-link text-danger p-0 text-decoration-none small fw-semibold" onclick="handleDeleteAddress(${addr.id})">Delete</button>
            </div>
          </div>
          <strong class="text-dark d-block mt-2 fs-6">${escapeHtml(addr.recipient_name)}</strong>
          <p class="text-muted small mb-2" style="line-height: 1.6;">
            ${escapeHtml(addr.address_line_1)}${addr.address_line_2 ? ', ' + escapeHtml(addr.address_line_2) : ''},<br>
            ${escapeHtml(addr.city)}, ${escapeHtml(addr.state)} - ${escapeHtml(addr.pincode)}
          </p>
          <div class="small text-muted mt-auto pt-2">
            <i class="bi bi-telephone me-1 text-success"></i> <span>${escapeHtml(addr.contactNo)}</span>
          </div>
        </div>
      </div>
    `).join('');
  }

  function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>"']/g, function(m) {
      return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[m];
    });
  }

  // Open Add Modal
  function openAddAddressModal() {
    document.getElementById('addressModalLabel').innerText = 'Add New Address';
    document.getElementById('address-id').value = '';
    document.getElementById('address-recipient').value = (currentUser ? currentUser.name : '');
    document.getElementById('address-contact').value = (currentUser ? currentUser.contactNo : '');
    document.getElementById('address-line1').value = '';
    document.getElementById('address-line2').value = '';
    document.getElementById('address-city').value = '';
    document.getElementById('address-state').value = '';
    document.getElementById('address-pincode').value = '';
    document.getElementById('address-type').value = 'Home';
    document.getElementById('address-is-default').checked = userAddresses.length === 0;

    const alertEl = document.getElementById('address-modal-alert');
    if (alertEl) alertEl.classList.add('d-none');

    const modal = new bootstrap.Modal(document.getElementById('addressModal'));
    modal.show();
  }

  // Open Edit Modal
  function openEditAddressModal(addr) {
    document.getElementById('addressModalLabel').innerText = 'Edit Delivery Address';
    document.getElementById('address-id').value = addr.id;
    document.getElementById('address-recipient').value = addr.recipient_name || '';
    document.getElementById('address-contact').value = addr.contactNo || '';
    document.getElementById('address-line1').value = addr.address_line_1 || '';
    document.getElementById('address-line2').value = addr.address_line_2 || '';
    document.getElementById('address-city').value = addr.city || '';
    document.getElementById('address-state').value = addr.state || '';
    document.getElementById('address-pincode').value = addr.pincode || '';
    document.getElementById('address-type').value = addr.type || 'Home';
    document.getElementById('address-is-default').checked = !!addr.is_default;

    const alertEl = document.getElementById('address-modal-alert');
    if (alertEl) alertEl.classList.add('d-none');

    const modal = new bootstrap.Modal(document.getElementById('addressModal'));
    modal.show();
  }

  // Handle Form Submission (Create or Update)
  async function handleAddressFormSubmit(event) {
    event.preventDefault();
    const alertEl = document.getElementById('address-modal-alert');
    const spinner = document.getElementById('address-spinner');
    const submitBtn = document.getElementById('address-submit-btn');

    const id = document.getElementById('address-id').value;
    const recipient_name = document.getElementById('address-recipient').value.trim();
    const contactNo = document.getElementById('address-contact').value.trim();
    const address_line_1 = document.getElementById('address-line1').value.trim();
    const address_line_2 = document.getElementById('address-line2').value.trim();
    const city = document.getElementById('address-city').value.trim();
    const state = document.getElementById('address-state').value.trim();
    const pincode = document.getElementById('address-pincode').value.trim();
    const type = document.getElementById('address-type').value;
    const is_default = document.getElementById('address-is-default').checked;

    if (spinner) spinner.classList.remove('d-none');
    if (submitBtn) submitBtn.disabled = true;
    if (alertEl) alertEl.classList.add('d-none');

    const url = id ? `/user/addresses/${id}` : '/user/addresses';
    const method = id ? 'PUT' : 'POST';

    try {
      const res = await fetch(url, {
        method: method,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({
          recipient_name, contactNo, address_line_1, address_line_2,
          city, state, pincode, type, is_default
        })
      });

      const data = await res.json();
      if (res.ok && data.success) {
        userAddresses = data.addresses || [];
        renderAddressesGrid();

        const modalEl = document.getElementById('addressModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();

        showToast(data.message || 'Address saved successfully!', 'success');
      } else {
        const errorMsg = (data.errors && Object.values(data.errors).flat()[0]) || data.message || 'Failed to save address.';
        if (alertEl) {
          alertEl.innerText = errorMsg;
          alertEl.classList.remove('d-none');
        }
        showToast(errorMsg, 'error');
      }
    } catch (err) {
      if (alertEl) {
        alertEl.innerText = 'Network error while saving address.';
        alertEl.classList.remove('d-none');
      }
      showToast('Network error while saving address.', 'error');
    } finally {
      if (spinner) spinner.classList.add('d-none');
      if (submitBtn) submitBtn.disabled = false;
    }
  }

  // Handle Set Default
  async function handleSetDefaultAddress(id) {
    try {
      const res = await fetch(`/user/addresses/${id}/default`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': getCsrfToken()
        }
      });
      const data = await res.json();
      if (res.ok && data.success) {
        userAddresses = data.addresses || [];
        renderAddressesGrid();
        showToast(data.message || 'Default address updated!', 'success');
      } else {
        showToast(data.message || 'Failed to set default address.', 'error');
      }
    } catch (err) {
      showToast('Network error while updating default address.', 'error');
    }
  }

  // Handle Delete Address
  async function handleDeleteAddress(id) {
    if (!confirm('Are you sure you want to delete this address?')) return;

    try {
      const res = await fetch(`/user/addresses/${id}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': getCsrfToken()
        }
      });
      const data = await res.json();
      if (res.ok && data.success) {
        userAddresses = data.addresses || [];
        renderAddressesGrid();
        showToast(data.message || 'Address deleted successfully!', 'success');
      } else {
        showToast(data.message || 'Failed to delete address.', 'error');
      }
    } catch (err) {
      showToast('Network error while deleting address.', 'error');
    }
  }

  // Parse URL query parameter (e.g. /account?tab=orders)
  document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const tabParam = params.get('tab');
    if (tabParam && ['overview', 'orders', 'profile', 'addresses'].includes(tabParam)) {
      switchAccountTab(tabParam);
    }
  });
</script>
@endpush
