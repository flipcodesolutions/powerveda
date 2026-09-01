@extends('admin.layouts.app')

@section('page_title', 'Dashboard Overview')

@section('content')
<section class="admin-tab-content" id="tab-overview">
  
  <!-- Metrics Row -->
  <div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="admin-stat-card stat-primary">
        <div>
          <div class="admin-stat-label">Total Revenue</div>
          <div class="admin-stat-val" id="stat-revenue">₹{{ number_format($totalRevenue ?? 0, 0) }}</div>
          <div class="admin-stat-trend text-success"><i class="bi bi-graph-up-arrow"></i> Active Storefront</div>
        </div>
        <div class="admin-stat-icon"><i class="bi bi-currency-rupee"></i></div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
      <div class="admin-stat-card stat-success">
        <div>
          <div class="admin-stat-label">Total Orders</div>
          <div class="admin-stat-val" id="stat-orders">{{ $ordersCount ?? 0 }}</div>
          <div class="admin-stat-trend text-success"><i class="bi bi-truck"></i> Real-time Orders</div>
        </div>
        <div class="admin-stat-icon"><i class="bi bi-bag-check"></i></div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
      <div class="admin-stat-card stat-gold">
        <div>
          <div class="admin-stat-label">Active Products</div>
          <div class="admin-stat-val" id="stat-products">{{ $productsCount }}</div>
          <div class="admin-stat-trend" style="color: #735737;"><i class="bi bi-shield-check"></i> 100% Lab Tested</div>
        </div>
        <div class="admin-stat-icon"><i class="bi bi-box-seam"></i></div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
      <a href="{{ route('admin.contacts.index') }}" class="text-decoration-none">
        <div class="admin-stat-card stat-primary">
          <div>
            <div class="admin-stat-label">Inquiries &amp; Messages</div>
            <div class="admin-stat-val" id="stat-contacts">{{ $contactsCount }}</div>
            <div class="admin-stat-trend {{ $unreadContactsCount > 0 ? 'text-danger fw-bold' : 'text-success' }}">
              <i class="bi bi-chat-left-dots"></i> {{ $unreadContactsCount }} Unread {{ $unreadContactsCount === 1 ? 'Message' : 'Messages' }}
            </div>
          </div>
          <div class="admin-stat-icon"><i class="bi bi-chat-left-text-fill"></i></div>
        </div>
      </a>
    </div>
  </div>

  <!-- Quick Actions & Highlights -->
  <div class="row g-4 mb-4">
    <div class="col-12 col-lg-8">
      <div class="admin-panel-card mb-0">
        <div class="admin-panel-header">
          <h3 class="admin-panel-title">Recent Customer Orders</h3>
          <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-outline-primary">View All Orders</a>
        </div>
        <div class="table-responsive">
          <table class="table admin-table align-middle">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentOrders as $rOrder)
                <tr>
                  <td><strong style="color: #061E43;">#{{ $rOrder->order_number }}</strong></td>
                  <td>{{ $rOrder->recipient_name }}</td>
                  <td>{{ $rOrder->items->count() }} {{ $rOrder->items->count() === 1 ? 'item' : 'items' }}</td>
                  <td><strong>₹{{ number_format($rOrder->total_amount, 0) }}</strong></td>
                  <td><span class="badge-status {{ $rOrder->status_badge_class }}">{{ $rOrder->status }}</span></td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">No customer orders placed yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-4">
      <div class="admin-panel-card mb-0 h-100">
        <div class="admin-panel-header">
          <h3 class="admin-panel-title">Quick Management</h3>
        </div>
        <div class="p-3 d-flex flex-column gap-2">
          <a href="{{ route('admin.products.create') }}" class="btn btn-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2 text-decoration-none">
            <i class="bi bi-plus-circle-fill"></i> Add New Product
          </a>
          <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary w-100 py-2 d-flex align-items-center justify-content-center gap-2 text-decoration-none">
            <i class="bi bi-chat-left-text-fill text-primary"></i> View Contact Inquiries
            @if($unreadContactsCount > 0)
              <span class="badge bg-danger ms-1">{{ $unreadContactsCount }}</span>
            @endif
          </a>
          <a href="{{ route('admin.reviews.create') }}" class="btn btn-outline-secondary w-100 py-2 d-flex align-items-center justify-content-center gap-2 text-decoration-none">
            <i class="bi bi-star-fill text-warning"></i> Add Customer Review
          </a>
          <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary w-100 py-2 d-flex align-items-center justify-content-center gap-2 text-decoration-none">
            <i class="bi bi-box-seam"></i> Browse Product Catalog
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Contact Inquiries Table Row -->
  @if($recentContacts->count() > 0)
    <div class="row g-4 mb-4">
      <div class="col-12">
        <div class="admin-panel-card mb-0">
          <div class="admin-panel-header">
            <h3 class="admin-panel-title">Recent Contact Messages &amp; Consultations</h3>
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-primary">View All Messages</a>
          </div>
          <div class="table-responsive">
            <table class="table admin-table">
              <thead>
                <tr>
                  <th>Sender</th>
                  <th>Contact Info</th>
                  <th>Subject</th>
                  <th>Status</th>
                  <th>Received</th>
                  <th class="text-end">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($recentContacts as $c)
                  <tr>
                    <td><strong>{{ $c->name }}</strong></td>
                    <td>
                      <small class="d-block text-muted">{{ $c->email }}</small>
                      <small class="text-secondary">{{ $c->contactno }}</small>
                    </td>
                    <td><span class="fw-medium text-dark">{{ $c->subject }}</span></td>
                    <td>
                      @if($c->status === 'Unread')
                        <span class="badge bg-danger">Unread</span>
                      @else
                        <span class="badge bg-secondary">Read</span>
                      @endif
                    </td>
                    <td class="text-muted small">{{ $c->created_at->diffForHumans() }}</td>
                    <td class="text-end">
                      <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-primary">Open Inbox</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  @endif

</section>
@endsection
