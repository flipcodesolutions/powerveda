<!-- Admin Sidebar Navigation -->
<aside class="admin-sidebar">
  <div class="admin-sidebar-brand">
    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none d-flex align-items-center">
      <img src="{{ asset('image/logo.png') }}" alt="Power Veda Logo">
      <div class="d-flex flex-column ps-2 border-start border-secondary">
        <span style="color: var(--gold-color, #D8BC8D); font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Admin Console</span>
        <span style="color: #ffffff; font-size: 0.8rem; font-weight: 700;">HQ Management</span>
      </div>
    </a>
  </div>

  <ul class="admin-nav-list">
    <li class="admin-nav-item">
      <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <div>
          <i class="bi bi-grid-1x2-fill nav-icon"></i>
          <span>Dashboard Overview</span>
        </div>
        <i class="bi bi-chevron-right small text-muted"></i>
      </a>
    </li>
    <li class="admin-nav-item">
      <a href="{{ route('admin.products.index') }}" class="admin-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
        <div>
          <i class="bi bi-box-seam-fill nav-icon"></i>
          <span>Manage Products</span>
        </div>
      </a>
    </li>
    <li class="admin-nav-item">
      <a href="{{ route('admin.orders') }}" class="admin-nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
        <div>
          <i class="bi bi-bag-check-fill nav-icon"></i>
          <span>Customer Orders</span>
        </div>
      </a>
    </li>
    <li class="admin-nav-item">
      <a href="{{ route('admin.reviews.index') }}" class="admin-nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
        <div>
          <i class="bi bi-star-fill nav-icon"></i>
          <span>Manage Reviews</span>
        </div>
      </a>
    </li>
    <li class="admin-nav-item">
      <a href="{{ route('admin.contacts.index') }}" class="admin-nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
        <div>
          <i class="bi bi-chat-left-text-fill nav-icon"></i>
          <span>Contact Messages</span>
        </div>
        @php
          $unreadContactCount = \App\Models\Contact::where('status', 'Unread')->count();
        @endphp
        @if($unreadContactCount > 0)
          <span class="badge bg-danger rounded-pill" style="font-size: 0.7rem;">{{ $unreadContactCount }}</span>
        @endif
      </a>
    </li>
    <li class="admin-nav-item">
      <a href="{{ route('admin.cms.index') }}" class="admin-nav-link {{ request()->routeIs('admin.cms.*') ? 'active' : '' }}">
        <div>
          <i class="bi bi-file-earmark-richtext-fill nav-icon"></i>
          <span>Policy CMS Pages</span>
        </div>
      </a>
    </li>
  </ul>

  <div class="admin-sidebar-footer d-flex flex-column gap-2">
    <a href="{{ route('home') }}" class="btn-storefront">
      <i class="bi bi-arrow-left"></i> View Live Storefront
    </a>
    <form action="{{ route('admin.logout') }}" method="POST" class="w-100">
      @csrf
      <button type="submit" class="btn btn-sm btn-outline-secondary w-100 text-start d-flex align-items-center gap-2 text-white-50" style="font-size: 0.8rem; border-color: rgba(255,255,255,0.15); padding: 0.5rem 0.75rem; border-radius: 8px;">
        <i class="bi bi-box-arrow-right text-danger"></i>
        <span>Sign Out (Admin)</span>
      </button>
    </form>
  </div>
</aside>
