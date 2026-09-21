@extends('admin.layouts.app')

@section('page_title', 'Customer Orders & Shipments')

@section('content')
<section class="admin-tab-content" id="tab-orders">

  <!-- 1. Summary Metric Chips -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <a href="{{ route('admin.orders') }}" class="text-decoration-none">
        <div class="admin-stat-card stat-primary p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="admin-stat-label">Total Orders</div>
              <div class="admin-stat-val fs-3">{{ $stats['total_orders'] ?? $orders->total() }}</div>
            </div>
            <div class="admin-stat-icon" style="width: 42px; height: 42px; font-size: 1.25rem;">
              <i class="bi bi-box-seam"></i>
            </div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-3">
      <a href="{{ route('admin.orders', ['payment_status' => 'Paid']) }}" class="text-decoration-none">
        <div class="admin-stat-card stat-success p-3 {{ request('payment_status') === 'Paid' ? 'border border-2 border-success shadow-sm' : '' }}">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="admin-stat-label">Paid Orders</div>
              <div class="admin-stat-val fs-3 text-success">{{ $stats['paid_orders'] ?? 0 }}</div>
            </div>
            <div class="admin-stat-icon" style="width: 42px; height: 42px; font-size: 1.25rem;">
              <i class="bi bi-check-circle-fill"></i>
            </div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-3">
      <a href="{{ route('admin.orders', ['payment_status' => 'Pending']) }}" class="text-decoration-none">
        <div class="admin-stat-card stat-gold p-3 {{ request('payment_status') === 'Pending' ? 'border border-2 border-warning shadow-sm' : '' }}">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="admin-stat-label">Pending Payment</div>
              <div class="admin-stat-val fs-3" style="color: #92400E;">{{ $stats['pending_payment'] ?? 0 }}</div>
            </div>
            <div class="admin-stat-icon" style="width: 42px; height: 42px; font-size: 1.25rem;">
              <i class="bi bi-hourglass-split"></i>
            </div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-3">
      <a href="{{ route('admin.orders', ['payment_status' => 'Failed']) }}" class="text-decoration-none">
        <div class="admin-stat-card p-3 {{ request('payment_status') === 'Failed' ? 'border border-2 border-danger shadow-sm' : '' }}" style="border-top: 4px solid #DC2626;">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="admin-stat-label">Failed Payment</div>
              <div class="admin-stat-val fs-3 text-danger">{{ $stats['failed_payment'] ?? 0 }}</div>
            </div>
            <div class="admin-stat-icon" style="width: 42px; height: 42px; font-size: 1.25rem; background-color: rgba(220, 38, 38, 0.1); color: #DC2626;">
              <i class="bi bi-x-circle-fill"></i>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>

  <!-- 2. Orders Panel Card -->
  <div class="admin-panel-card">
    
    <!-- Panel Header with Title & Quick Tabs -->
    <div class="admin-panel-header flex-wrap gap-3">
      <div class="d-flex align-items-center gap-2">
        <i class="bi bi-truck fs-4 text-primary"></i>
        <h3 class="admin-panel-title mb-0">Customer Orders &amp; Shipments</h3>
      </div>

      <!-- Quick Order Status Tabs -->
      <div class="btn-group btn-group-sm">
        <a href="{{ route('admin.orders', array_merge(request()->except(['status', 'page']), ['status' => 'all'])) }}" 
           class="btn btn-outline-secondary {{ (!request('status') || request('status') === 'all') ? 'active' : '' }}">All</a>
        <a href="{{ route('admin.orders', array_merge(request()->except(['status', 'page']), ['status' => 'Processing'])) }}" 
           class="btn btn-outline-secondary {{ request('status') === 'Processing' ? 'active' : '' }}">Processing</a>
        <a href="{{ route('admin.orders', array_merge(request()->except(['status', 'page']), ['status' => 'In Transit'])) }}" 
           class="btn btn-outline-secondary {{ request('status') === 'In Transit' ? 'active' : '' }}">In Transit</a>
        <a href="{{ route('admin.orders', array_merge(request()->except(['status', 'page']), ['status' => 'Delivered'])) }}" 
           class="btn btn-outline-secondary {{ request('status') === 'Delivered' ? 'active' : '' }}">Delivered</a>
        <a href="{{ route('admin.orders', array_merge(request()->except(['status', 'page']), ['status' => 'Cancelled'])) }}" 
           class="btn btn-outline-secondary {{ request('status') === 'Cancelled' ? 'active' : '' }}">Cancelled</a>
      </div>
    </div>

    <!-- Filter Bar Form: Date Range, Payment Status, Payment Method, Search -->
    <div class="p-3 bg-light border-bottom">
      <form method="GET" action="{{ route('admin.orders') }}" class="row g-2 align-items-end" id="admin-orders-filter-form">
        @if(request('status') && request('status') !== 'all')
          <input type="hidden" name="status" value="{{ request('status') }}">
        @endif

        <!-- 1. Search Query -->
        <div class="col-12 col-md-3">
          <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-search me-1"></i> Search</label>
          <input type="text" name="search" class="form-control form-control-sm" placeholder="Order ID, Customer, Phone, Txn..." value="{{ request('search') }}">
        </div>

        <!-- 2. Date Range: From Date -->
        <div class="col-6 col-sm-4 col-md-2">
          <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-calendar-event me-1"></i> From Date</label>
          <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
        </div>

        <!-- 3. Date Range: To Date -->
        <div class="col-6 col-sm-4 col-md-2">
          <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-calendar-check me-1"></i> To Date</label>
          <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
        </div>

        <!-- 4. Payment Status Filter -->
        <div class="col-6 col-sm-4 col-md-2">
          <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-credit-card me-1"></i> Payment Status</label>
          <select name="payment_status" class="form-select form-select-sm">
            <option value="all" {{ (!request('payment_status') || request('payment_status') === 'all') ? 'selected' : '' }}>All Payments</option>
            <option value="Paid" {{ request('payment_status') === 'Paid' ? 'selected' : '' }}>Paid</option>
            <option value="Pending" {{ request('payment_status') === 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Failed" {{ request('payment_status') === 'Failed' ? 'selected' : '' }}>Failed</option>
          </select>
        </div>

        <!-- 5. Payment Method Filter -->
        <div class="col-6 col-sm-4 col-md-2">
          <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-wallet2 me-1"></i> Payment Method</label>
          <select name="payment_method" class="form-select form-select-sm">
            <option value="all" {{ (!request('payment_method') || request('payment_method') === 'all') ? 'selected' : '' }}>All Methods</option>
            <option value="PhonePe" {{ request('payment_method') === 'PhonePe' ? 'selected' : '' }}>PhonePe</option>
            <option value="Cash on Delivery" {{ request('payment_method') === 'Cash on Delivery' ? 'selected' : '' }}>Cash on Delivery</option>
            <option value="Prepaid UPI" {{ request('payment_method') === 'Prepaid UPI' ? 'selected' : '' }}>Prepaid UPI / Online</option>
          </select>
        </div>

        <!-- 6. Action Buttons -->
        <div class="col-12 col-md-1 d-flex gap-1">
          <button type="submit" class="btn btn-primary btn-sm flex-grow-1" title="Apply Filters">
            <i class="bi bi-funnel-fill"></i> Filter
          </button>
          @if(request('search') || request('date_from') || request('date_to') || (request('payment_status') && request('payment_status') !== 'all') || (request('payment_method') && request('payment_method') !== 'all') || (request('status') && request('status') !== 'all'))
            <a href="{{ route('admin.orders') }}" class="btn btn-outline-danger btn-sm" title="Clear All Filters">
              <i class="bi bi-x-circle"></i>
            </a>
          @endif
        </div>
      </form>

      <!-- Active Filters Indicator Bar -->
      @if(request('search') || request('date_from') || request('date_to') || (request('payment_status') && request('payment_status') !== 'all') || (request('payment_method') && request('payment_method') !== 'all') || (request('status') && request('status') !== 'all'))
        <div class="d-flex align-items-center gap-2 flex-wrap mt-2 pt-2 border-top">
          <span class="small text-muted fw-bold"><i class="bi bi-filter"></i> Active Filters:</span>
          @if(request('status') && request('status') !== 'all')
            <span class="badge bg-secondary d-flex align-items-center gap-1">
              Status: {{ request('status') }}
              <a href="{{ route('admin.orders', request()->except(['status', 'page'])) }}" class="text-white text-decoration-none">&times;</a>
            </span>
          @endif
          @if(request('payment_status') && request('payment_status') !== 'all')
            <span class="badge bg-info text-dark d-flex align-items-center gap-1">
              Payment: {{ request('payment_status') }}
              <a href="{{ route('admin.orders', request()->except(['payment_status', 'page'])) }}" class="text-dark text-decoration-none">&times;</a>
            </span>
          @endif
          @if(request('payment_method') && request('payment_method') !== 'all')
            <span class="badge bg-primary d-flex align-items-center gap-1">
              Method: {{ request('payment_method') }}
              <a href="{{ route('admin.orders', request()->except(['payment_method', 'page'])) }}" class="text-white text-decoration-none">&times;</a>
            </span>
          @endif
          @if(request('date_from'))
            <span class="badge bg-light text-dark border d-flex align-items-center gap-1">
              From: {{ \Carbon\Carbon::parse(request('date_from'))->format('d M Y') }}
              <a href="{{ route('admin.orders', request()->except(['date_from', 'page'])) }}" class="text-dark text-decoration-none">&times;</a>
            </span>
          @endif
          @if(request('date_to'))
            <span class="badge bg-light text-dark border d-flex align-items-center gap-1">
              To: {{ \Carbon\Carbon::parse(request('date_to'))->format('d M Y') }}
              <a href="{{ route('admin.orders', request()->except(['date_to', 'page'])) }}" class="text-dark text-decoration-none">&times;</a>
            </span>
          @endif
          @if(request('search'))
            <span class="badge bg-light text-dark border d-flex align-items-center gap-1">
              Search: "{{ request('search') }}"
              <a href="{{ route('admin.orders', request()->except(['search', 'page'])) }}" class="text-dark text-decoration-none">&times;</a>
            </span>
          @endif
          <a href="{{ route('admin.orders') }}" class="small text-danger text-decoration-none ms-auto fw-semibold">
            <i class="bi bi-arrow-counterclockwise"></i> Reset All
          </a>
        </div>
      @endif
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mx-4 mt-3 mb-0" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="table-responsive">
      <table class="table admin-table align-middle">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Date Placed</th>
            <th>Items</th>
            <th>Total</th>
            <th>Payment</th>
            <th>Status</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody id="orders-table-body">
          @forelse($orders as $order)
            <tr>
              <td>
                <strong style="color: #061E43;">#{{ $order->order_number }}</strong>
              </td>
              <td>
                <strong class="d-block text-dark">{{ $order->recipient_name }}</strong>
                <span class="text-muted small">{{ $order->contactNo }}</span>
                @if($order->user)
                  <span class="text-muted small d-block" style="font-size: 0.75rem;">({{ $order->user->email }})</span>
                @endif
              </td>
              <td>
                <span class="small d-block text-dark">{{ $order->created_at->format('d M Y') }}</span>
                <span class="text-muted small" style="font-size: 0.75rem;">{{ $order->created_at->format('h:i A') }}</span>
              </td>
              <td>
                <span class="badge bg-light text-dark border">
                  {{ $order->items->count() }} {{ $order->items->count() === 1 ? 'item' : 'items' }}
                </span>
              </td>
              <td>
                <strong class="text-dark">₹{{ number_format($order->total_amount, 0) }}</strong>
              </td>
              <td>
                <div class="d-flex flex-column gap-1">
                  <span class="badge {{ $order->payment_method === 'PhonePe' ? 'bg-primary-subtle text-primary border border-primary-subtle' : 'bg-light text-secondary border' }} small" style="font-size: 0.72rem;">
                    {{ $order->payment_method }}
                  </span>
                  @if($order->payment_status === 'Paid')
                    <span class="badge bg-success" style="font-size: 0.65rem;">Paid</span>
                  @elseif($order->payment_status === 'Failed')
                    <span class="badge bg-danger" style="font-size: 0.65rem;">Failed</span>
                  @else
                    <span class="badge bg-secondary" style="font-size: 0.65rem;">Pending</span>
                  @endif
                  @if($order->transaction_id)
                    <span class="small text-muted font-monospace" style="font-size: 0.65rem;" title="Txn ID: {{ $order->transaction_id }}">
                      Txn: {{ Str::limit($order->transaction_id, 14) }}
                    </span>
                  @endif
                </div>
              </td>
              <td>
                <span class="badge-status {{ $order->status_badge_class }}">
                  <i class="bi bi-circle-fill" style="font-size: 0.45rem;"></i> {{ $order->status }}
                </span>
              </td>
              <td class="text-end">
                <button type="button" class="action-btn-sm me-1" onclick="viewOrderDetails('{{ $order->id }}')" title="View Details">
                  <i class="bi bi-eye"></i>
                </button>
                <button type="button" class="action-btn-sm me-1" onclick="promptUpdateOrderStatus('{{ $order->id }}')" title="Change Status">
                  <i class="bi bi-arrow-clockwise"></i>
                </button>
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete Order #{{ $order->order_number }}?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="action-btn-sm text-danger" title="Delete Order">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-5 text-muted">
                <i class="bi bi-box-seam fs-2 d-block mb-2 text-muted"></i>
                <p class="mb-2">No customer orders found matching your filter criteria.</p>
                @if(request('search') || request('date_from') || request('date_to') || request('payment_status') || request('payment_method') || request('status'))
                  <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-outline-primary mt-1">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Clear Filters
                  </a>
                @endif
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($orders->hasPages())
      <div class="p-3 border-top d-flex justify-content-end">
        {{ $orders->links() }}
      </div>
    @endif

  </div>
</section>
@endsection

@push('scripts')
<script>
  window.serverOrders = @json($orders->items());
</script>
@endpush
