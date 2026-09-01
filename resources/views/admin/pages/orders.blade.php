@extends('admin.layouts.app')

@section('page_title', 'Customer Orders & Shipments')

@section('content')
<section class="admin-tab-content" id="tab-orders">
  <div class="admin-panel-card">
    <div class="admin-panel-header flex-wrap gap-3">
      <div class="d-flex align-items-center gap-3 flex-wrap flex-grow-1">
        <h3 class="admin-panel-title mb-0">Customer Orders &amp; Shipments</h3>
        <form method="GET" action="{{ route('admin.orders') }}" class="admin-search-input" id="admin-orders-search-form">
          <i class="bi bi-search"></i>
          <input type="text" name="search" id="admin-order-search" placeholder="Search Order ID, Name, Phone..." value="{{ request('search') }}">
          @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
          @endif
        </form>
      </div>

      <div class="btn-group btn-group-sm">
        <a href="{{ route('admin.orders', ['search' => request('search')]) }}" class="btn btn-outline-secondary {{ (!request('status') || request('status') === 'all') ? 'active' : '' }}">All</a>
        <a href="{{ route('admin.orders', ['status' => 'Processing', 'search' => request('search')]) }}" class="btn btn-outline-secondary {{ request('status') === 'Processing' ? 'active' : '' }}">Processing</a>
        <a href="{{ route('admin.orders', ['status' => 'In Transit', 'search' => request('search')]) }}" class="btn btn-outline-secondary {{ request('status') === 'In Transit' ? 'active' : '' }}">In Transit</a>
        <a href="{{ route('admin.orders', ['status' => 'Delivered', 'search' => request('search')]) }}" class="btn btn-outline-secondary {{ request('status') === 'Delivered' ? 'active' : '' }}">Delivered</a>
        <a href="{{ route('admin.orders', ['status' => 'Cancelled', 'search' => request('search')]) }}" class="btn btn-outline-secondary {{ request('status') === 'Cancelled' ? 'active' : '' }}">Cancelled</a>
      </div>
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
                <span class="badge bg-light text-secondary border small" style="font-size: 0.72rem;">
                  {{ $order->payment_method }}
                </span>
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
                <p class="mb-0">No customer orders found matching current criteria.</p>
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
