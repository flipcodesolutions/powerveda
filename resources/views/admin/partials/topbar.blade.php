<!-- Admin Topbar -->
<header class="admin-topbar">
  <div class="d-flex align-items-center gap-3">
    <button type="button" class="admin-mobile-toggle" id="admin-mobile-toggle" aria-label="Toggle Sidebar">
      <i class="bi bi-list"></i>
    </button>
    <h1 class="admin-topbar-title" id="admin-topbar-title">@yield('page_title', 'Dashboard Overview')</h1>
  </div>

  <div class="admin-topbar-actions d-flex align-items-center gap-3">
    <div class="admin-user-pill">
      <div class="admin-user-avatar">
        {{ strtoupper(substr(auth()->user()->name ?? 'PV', 0, 2)) }}
      </div>
      <div>
        <span class="d-block fw-bold" style="font-size: 0.85rem; color: #061E43;">
          {{ auth()->user()->name ?? 'Admin HQ' }}
        </span>
        <span class="d-block text-muted" style="font-size: 0.72rem;">
          {{ auth()->user()->role ?? 'Admin' }} ({{ auth()->user()->email ?? 'admin@powerveda.com' }})
        </span>
      </div>
    </div>

    <!-- Sign Out Form -->
    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
      @csrf
      <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1" title="Sign Out">
        <i class="bi bi-box-arrow-right"></i>
        <span class="d-none d-sm-inline">Sign Out</span>
      </button>
    </form>
  </div>
</header>
