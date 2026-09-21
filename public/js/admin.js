/**
 * Power Veda - Admin Console Logic
 * Dynamic Server-Driven Order Management, Modals & Toast Notifications
 */

// --------------------------------------------------------------------------
// 1. Order Details Modal (Dynamic Server & Local Fallback)
// --------------------------------------------------------------------------
async function viewOrderDetails(orderId) {
  let order = (window.serverOrders || []).find(o => String(o.id) === String(orderId) || String(o.order_number) === String(orderId));

  if (!order) {
    try {
      const res = await fetch(`/admin/orders/${orderId}`, {
        headers: { 
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });
      if (res.ok) {
        const data = await res.json();
        order = data.order;
      }
    } catch (e) {
      console.warn('Could not fetch order from server:', e);
    }
  }

  if (!order) {
    showToast('Order details could not be found.', 'error');
    return;
  }

  const idEl = document.getElementById('view-order-id');
  const custEl = document.getElementById('view-order-customer');
  const emailEl = document.getElementById('view-order-email');
  const phoneEl = document.getElementById('view-order-phone');
  const addrEl = document.getElementById('view-order-address');
  const badgeEl = document.getElementById('view-order-status-badge');
  const payEl = document.getElementById('view-order-payment');
  const payStatusEl = document.getElementById('view-order-payment-status');
  const txnEl = document.getElementById('view-order-txn');
  const totalEl = document.getElementById('view-order-total');

  if (idEl) idEl.innerText = `#${order.order_number || order.id}`;
  if (custEl) custEl.innerText = order.recipient_name || (order.user ? order.user.name : 'Customer');
  if (emailEl) emailEl.innerText = (order.user ? order.user.email : order.email) || 'N/A';
  if (phoneEl) phoneEl.innerText = order.contactNo || order.phone || 'N/A';
  
  if (addrEl) {
    const fullAddress = order.formatted_address || [
      order.address_line_1,
      order.address_line_2,
      order.city,
      order.state ? `${order.state} - ${order.pincode || ''}` : ''
    ].filter(Boolean).join(', ');
    addrEl.innerText = fullAddress || 'N/A';
  }

  if (badgeEl) {
    badgeEl.innerText = order.status;
    badgeEl.className = 'badge px-3 py-2 ' + (
      order.status === 'Delivered' ? 'bg-success' :
      order.status === 'In Transit' ? 'bg-info text-dark' :
      order.status === 'Cancelled' ? 'bg-danger' : 'bg-primary'
    );
  }

  if (payEl) payEl.innerText = order.payment_method || 'Cash on Delivery';
  if (payStatusEl) {
    payStatusEl.innerText = order.payment_status || 'Pending';
    payStatusEl.className = 'badge ' + (order.payment_status === 'Paid' ? 'bg-success' : (order.payment_status === 'Failed' ? 'bg-danger' : 'bg-secondary'));
  }
  if (txnEl) {
    if (order.transaction_id) {
      txnEl.innerText = `Txn ID: ${order.transaction_id}`;
      txnEl.style.display = 'block';
    } else {
      txnEl.style.display = 'none';
    }
  }

  if (totalEl) totalEl.innerText = `₹${Number(order.total_amount || 0).toLocaleString('en-IN')}`;

  const itemsContainer = document.getElementById('view-order-items-list');
  if (itemsContainer) {
    const items = order.items || [];
    if (items.length > 0) {
      itemsContainer.innerHTML = items.map(item => `
        <div class="d-flex align-items-center gap-3 py-2 border-bottom">
          <img src="${item.photo_url || item.image || '/image/products/product-1.jpg'}" alt="${item.product_name || 'Product'}" style="width: 48px; height: 48px; object-fit: cover; border-radius: 6px;" onerror="this.src='/image/products/product-1.jpg'">
          <div class="flex-grow-1">
            <div class="fw-bold small text-dark">${item.product_name || 'Ayurvedic Formulation'}</div>
            <div class="text-muted small">Qty: ${item.qty} &bull; ₹${Number(item.price).toLocaleString('en-IN')} each</div>
          </div>
          <div class="fw-bold text-dark">₹${(Number(item.price) * item.qty).toLocaleString('en-IN')}</div>
        </div>
      `).join('');
    } else {
      itemsContainer.innerHTML = `<div class="text-muted small py-2">No individual line items registered.</div>`;
    }
  }

  const modalEl = document.getElementById('viewOrderModal');
  if (modalEl) {
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
  }
}

// --------------------------------------------------------------------------
// 2. Order Status Update
// --------------------------------------------------------------------------
async function promptUpdateOrderStatus(orderId) {
  let currentStatus = 'Processing';
  let order = (window.serverOrders || []).find(o => String(o.id) === String(orderId) || String(o.order_number) === String(orderId));
  if (order) currentStatus = order.status;

  const nextStatuses = ["Processing", "In Transit", "Delivered", "Cancelled"];
  const newStatus = prompt(`Update Status for Order #${order ? (order.order_number || order.id) : orderId}:\nEnter: Processing, In Transit, Delivered, or Cancelled`, currentStatus);

  if (newStatus && nextStatuses.map(s => s.toLowerCase()).includes(newStatus.toLowerCase())) {
    const formatted = nextStatuses.find(s => s.toLowerCase() === newStatus.toLowerCase());

    try {
      const res = await fetch(`/admin/orders/${orderId}/status`, {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({ status: formatted })
      });

      const data = await res.json();
      if (res.ok && data.success) {
        showToast(data.message || `Order status updated to ${formatted}!`, 'success');
        setTimeout(() => window.location.reload(), 600);
        return;
      } else {
        showToast(data.message || 'Failed to update order status.', 'error');
      }
    } catch (e) {
      console.error('API update failed:', e);
      showToast('Network error while updating status.', 'error');
    }
  }
}

// --------------------------------------------------------------------------
// 3. Toast Notifications
// --------------------------------------------------------------------------
function showToast(message, type = 'success') {
  const container = document.getElementById('toast-container');
  if (!container) return;

  const toast = document.createElement('div');
  toast.className = `custom-toast toast-${type}`;
  const icon = type === 'success' ? 'bi-check-circle-fill text-success' : 'bi-info-circle-fill text-danger';

  toast.innerHTML = `
    <div class="d-flex align-items-center gap-2">
      <i class="bi ${icon} fs-5"></i>
      <span style="font-size: 0.9rem; font-weight: 600;">${message}</span>
    </div>
    <button type="button" class="btn-close ms-2" style="font-size: 0.75rem;" aria-label="Close"></button>
  `;

  const closeBtn = toast.querySelector('.btn-close');
  closeBtn.addEventListener('click', () => toast.remove());

  container.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateX(100%)';
    setTimeout(() => toast.remove(), 300);
  }, 3500);
}

// --------------------------------------------------------------------------
// 4. Event Listeners & Mobile Sidebar
// --------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
  // Mobile drawer toggle
  const mobileToggle = document.getElementById('admin-mobile-toggle');
  const sidebar = document.querySelector('.admin-sidebar');
  if (mobileToggle && sidebar) {
    mobileToggle.addEventListener('click', () => {
      sidebar.classList.toggle('show');
    });
  }
});
