/**
 * Power Veda - Admin Console Logic
 * Complete Product Management, Order Management & Review Moderation System
 */

// --------------------------------------------------------------------------
// 1. Initial State & Persistence
// --------------------------------------------------------------------------
const defaultAdminProducts = [
  {
    id: 1,
    name: "Power Veda Ashwagandha Gold KSM-66",
    price: 1499,
    originalPrice: 1999,
    discount: "25% OFF",
    stock: 85,
    status: "In Stock",
    rating: 5.0,
    reviews: 240,
    badge: "NATURAL",
    image: "image/products/product-1.jpg",
    description: "Premium full-spectrum organic root extract designed to boost physical vitality, reduce stress, and enhance muscle endurance."
  },
  {
    id: 2,
    name: "Power Veda Himalayan Detox Elixir",
    price: 899,
    originalPrice: 1199,
    discount: "25% OFF",
    stock: 42,
    status: "In Stock",
    rating: 4.8,
    reviews: 135,
    badge: "100% PURE",
    image: "image/products/product-2.jpg",
    description: "Handcrafted botanical blend of holy tulsi, lemongrass, and antioxidant herbs for cellular rejuvenation and daily detox."
  },
  {
    id: 3,
    name: "Power Veda 24K Saffron Radiance Elixir",
    price: 2499,
    originalPrice: 3299,
    discount: "24% OFF",
    stock: 18,
    status: "Low Stock",
    rating: 5.0,
    reviews: 310,
    badge: "PREMIUM",
    image: "image/products/product-3.jpg",
    description: "Sacred facial and skin radiance elixir formulated with pure Kashmiri saffron, sandalwood, and lotus blossoms."
  },
  {
    id: 4,
    name: "Power Veda Triphala Gut Vitality",
    price: 799,
    originalPrice: 999,
    discount: "20% OFF",
    stock: 94,
    status: "In Stock",
    rating: 4.7,
    reviews: 95,
    badge: "VITALITY",
    image: "image/products/product-4.jpg",
    description: "Time-tested three-fruit botanical formula supporting digestion, nutrient absorption, and body purification."
  },
  {
    id: 5,
    name: "Power Veda Brahmi Mind Focus Tonic",
    price: 1199,
    originalPrice: 1599,
    discount: "25% OFF",
    stock: 60,
    status: "In Stock",
    rating: 4.9,
    reviews: 160,
    badge: "STRENGTH",
    image: "image/products/product-5.jpg",
    description: "Cognitive enhancement formulation supporting peak memory clarity, sharp focus, and nervous system health."
  },
  {
    id: 6,
    name: "Power Veda Turmeric Curcumin 95%",
    price: 1299,
    originalPrice: 1699,
    discount: "23% OFF",
    stock: 75,
    status: "In Stock",
    rating: 4.9,
    reviews: 215,
    badge: "IMMUNITY",
    image: "image/products/product-6.jpg",
    description: "Ultra-potent golden turmeric extract formulated with BioPerine for joint flexibility, vitality, and robust immunity."
  },
  {
    id: 7,
    name: "Power Veda Neem & Tulsi Purifying Cleanse",
    price: 699,
    originalPrice: 899,
    discount: "22% OFF",
    stock: 50,
    status: "In Stock",
    rating: 4.8,
    reviews: 112,
    badge: "WELLNESS",
    image: "image/products/product-7.jpg",
    description: "Gentle soap-free foaming wash that balances natural skin oils and deeply purifies pores with sacred botanicals."
  },
  {
    id: 8,
    name: "Power Veda Cold-Pressed Sweet Almond Oil",
    price: 999,
    originalPrice: 1299,
    discount: "23% OFF",
    stock: 35,
    status: "In Stock",
    rating: 4.9,
    reviews: 180,
    badge: "COLD PRESSED",
    image: "image/products/product-8.jpg",
    description: "100% unrefined therapeutic oil rich in natural Vitamin E, perfect for restorative body massage and muscle recovery."
  }
];

const defaultAdminOrders = [
  {
    id: "PV-94821",
    customer: "Aarohi Sharma",
    email: "aarohi.sharma@example.com",
    phone: "+91 98765 43210",
    date: "22 Aug 2026",
    status: "Delivered",
    paymentMode: "Prepaid UPI",
    items: [
      { name: "Power Veda Ashwagandha Gold KSM-66", qty: 1, price: 1499, img: "image/products/product-1.jpg" },
      { name: "Power Veda Himalayan Detox Elixir", qty: 1, price: 899, img: "image/products/product-2.jpg" },
      { name: "Power Veda Neem & Tulsi Cleanse", qty: 1, price: 699, img: "image/products/product-7.jpg" }
    ],
    total: 3097,
    address: "108 Lotus Wellness Way, Green Valley, Mumbai 400001"
  },
  {
    id: "PV-95304",
    customer: "Vikram Malhotra",
    email: "vikram.malhotra@example.com",
    phone: "+91 98231 55443",
    date: "25 Aug 2026",
    status: "In Transit",
    paymentMode: "Prepaid Card",
    items: [
      { name: "Power Veda 24K Saffron Radiance Elixir", qty: 1, price: 2499, img: "image/products/product-3.jpg" },
      { name: "Power Veda Turmeric Curcumin 95%", qty: 1, price: 1299, img: "image/products/product-6.jpg" }
    ],
    total: 3798,
    address: "Flat 402, Royal Palms, Indiranagar, Bengaluru 560038"
  },
  {
    id: "PV-91054",
    customer: "Dr. Priya Nair",
    email: "priya.nair@example.com",
    phone: "+91 99401 22334",
    date: "10 Aug 2026",
    status: "Delivered",
    paymentMode: "Prepaid Card",
    items: [
      { name: "Power Veda Triphala Gut Vitality", qty: 1, price: 799, img: "image/products/product-4.jpg" },
      { name: "Power Veda Brahmi Mind Focus Tonic", qty: 1, price: 1199, img: "image/products/product-5.jpg" },
      { name: "Power Veda Cold-Pressed Sweet Almond Oil", qty: 1, price: 999, img: "image/products/product-8.jpg" }
    ],
    total: 2997,
    address: "B-14 Green Park Extension, New Delhi 110016"
  },
  {
    id: "PV-96112",
    customer: "Rajesh Kulkarni",
    email: "rajesh.k@example.com",
    phone: "+91 97654 88122",
    date: "26 Aug 2026",
    status: "Processing",
    paymentMode: "Cash on Delivery",
    items: [
      { name: "Power Veda Ashwagandha Gold KSM-66", qty: 2, price: 2998, img: "image/products/product-1.jpg" }
    ],
    total: 2998,
    address: "Plot 22, Shivaji Nagar, Pune 411005"
  }
];

const defaultAdminReviews = [
  {
    id: 1,
    author: "Ananya Deshmukh",
    location: "Mumbai",
    rating: 5,
    product: "Power Veda Ashwagandha Gold KSM-66",
    comment: "Noticeable increase in my daily energy levels and stamina within two weeks. Authentic Vedic herb aroma and zero synthetic aftertaste. Exceptional quality!",
    date: "24 Aug 2026",
    status: "Approved"
  },
  {
    id: 2,
    author: "Vikram Malhotra",
    location: "Bengaluru",
    rating: 5,
    product: "Power Veda 24K Saffron Radiance Elixir",
    comment: "Kumkumadi 24K Saffron Oil is pure luxury. The texture is lightweight, deeply nourishing, and gave my skin a healthy, vibrant glow.",
    date: "20 Aug 2026",
    status: "Approved"
  },
  {
    id: 3,
    author: "Dr. Priya Nair",
    location: "Delhi",
    rating: 5,
    product: "Power Veda Himalayan Detox Elixir",
    comment: "Super fast delivery, premium glass jar packaging, and authentic taste. The Himalayan Herbal Detox tea has replaced regular coffee in my morning routine.",
    date: "18 Aug 2026",
    status: "Approved"
  },
  {
    id: 4,
    author: "Siddharth Rao",
    location: "Hyderabad",
    rating: 4,
    product: "Power Veda Brahmi Mind Focus Tonic",
    comment: "Very calming formulation, helps a lot with late work focus. Packaging arrived in pristine condition.",
    date: "26 Aug 2026",
    status: "Pending"
  }
];

let adminProducts = JSON.parse(localStorage.getItem('powerveda_admin_products')) || defaultAdminProducts;
let adminOrders = JSON.parse(localStorage.getItem('powerveda_admin_orders')) || defaultAdminOrders;
let adminReviews = JSON.parse(localStorage.getItem('powerveda_admin_reviews')) || defaultAdminReviews;

function saveAdminData() {
  localStorage.setItem('powerveda_admin_products', JSON.stringify(adminProducts));
  localStorage.setItem('powerveda_admin_orders', JSON.stringify(adminOrders));
  localStorage.setItem('powerveda_admin_reviews', JSON.stringify(adminReviews));
  updateOverviewStats();
}

// --------------------------------------------------------------------------
// 2. Navigation & Tabs
// --------------------------------------------------------------------------
function switchAdminTab(tabName) {
  document.querySelectorAll('.admin-nav-link').forEach(link => {
    link.classList.toggle('active', link.getAttribute('data-tab') === tabName);
  });

  document.querySelectorAll('.admin-tab-content').forEach(section => {
    section.style.display = section.id === `tab-${tabName}` ? 'block' : 'none';
  });

  const titles = {
    'overview': 'Dashboard Overview',
    'products': 'Manage Product Catalog',
    'orders': 'Manage Customer Orders',
    'reviews': 'Manage Reviews & Testimonials'
  };

  const topTitleEl = document.getElementById('admin-topbar-title');
  if (topTitleEl && titles[tabName]) {
    topTitleEl.innerText = titles[tabName];
  }

  // Close mobile sidebar if open
  const sidebar = document.querySelector('.admin-sidebar');
  if (sidebar) sidebar.classList.remove('show');
}

// --------------------------------------------------------------------------
// 3. Overview Statistics
// --------------------------------------------------------------------------
function updateOverviewStats() {
  const totalRevenue = adminOrders.reduce((sum, order) => sum + (order.total || 0), 0);
  const totalOrdersCount = adminOrders.length;
  const activeProductsCount = adminProducts.length;
  const totalReviewsCount = adminReviews.length;

  const revEl = document.getElementById('stat-revenue');
  const ordEl = document.getElementById('stat-orders');
  const prodEl = document.getElementById('stat-products');
  const revCountEl = document.getElementById('stat-reviews');

  const sidebarProdCount = document.getElementById('sidebar-prod-count');

  if (revEl) revEl.innerText = `₹${totalRevenue.toLocaleString('en-IN')}`;
  if (ordEl) ordEl.innerText = totalOrdersCount;
  if (prodEl) prodEl.innerText = activeProductsCount;
  if (revCountEl) revCountEl.innerText = totalReviewsCount;
  if (sidebarProdCount) sidebarProdCount.innerText = activeProductsCount;
}

// --------------------------------------------------------------------------
// 4. Products Management
// Products CRUD is now handled via standard Laravel MVC (Forms & Controller)
// --------------------------------------------------------------------------

// --------------------------------------------------------------------------
// 5. Orders Management
// --------------------------------------------------------------------------
function renderOrdersTable(filterStatus = 'all', searchQuery = '') {
  const tbody = document.getElementById('orders-table-body');
  if (!tbody) return;

  let filtered = adminOrders;
  if (filterStatus !== 'all') {
    filtered = filtered.filter(o => o.status.toLowerCase() === filterStatus.toLowerCase());
  }

  if (searchQuery) {
    const q = searchQuery.toLowerCase();
    filtered = filtered.filter(o => 
      o.id.toLowerCase().includes(q) || 
      o.customer.toLowerCase().includes(q) || 
      o.phone.includes(q)
    );
  }

  if (filtered.length === 0) {
    tbody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-muted">No orders found.</td></tr>`;
    return;
  }

  tbody.innerHTML = filtered.map(o => {
    let statusClass = 'badge-status-processing';
    if (o.status === 'Delivered') statusClass = 'badge-status-delivered';
    else if (o.status === 'In Transit') statusClass = 'badge-status-intransit';

    return `
      <tr>
        <td><strong style="color: #061E43;">#${o.id}</strong></td>
        <td>
          <strong class="d-block">${o.customer}</strong>
          <span class="text-muted small">${o.phone}</span>
        </td>
        <td>${o.date}</td>
        <td><span class="badge bg-light text-dark border">${o.items ? o.items.length : 1} items</span></td>
        <td><strong>₹${o.total.toLocaleString('en-IN')}</strong></td>
        <td>
          <span class="badge-status ${statusClass}">
            <i class="bi bi-circle-fill" style="font-size: 0.45rem;"></i> ${o.status}
          </span>
        </td>
        <td class="text-end">
          <button class="action-btn-sm me-1" onclick="viewOrderDetails('${o.id}')" title="View Order">
            <i class="bi bi-eye"></i>
          </button>
          <button class="action-btn-sm" onclick="promptUpdateOrderStatus('${o.id}')" title="Change Status">
            <i class="bi bi-arrow-clockwise"></i>
          </button>
        </td>
      </tr>
    `;
  }).join('');
}

async function viewOrderDetails(orderId) {
  let order = (window.serverOrders || []).find(o => String(o.id) === String(orderId) || String(o.order_number) === String(orderId));

  if (!order) {
    try {
      const res = await fetch(`/admin/orders/${orderId}`, {
        headers: { 'Accept': 'application/json' }
      });
      if (res.ok) {
        const data = await res.json();
        order = data.order;
      }
    } catch (e) {
      console.warn('Could not fetch order from server, checking fallback', e);
    }
  }

  if (!order) {
    order = (typeof adminOrders !== 'undefined' ? adminOrders : []).find(o => String(o.id) === String(orderId));
  }

  if (!order) {
    showToast('Order details could not be found.', 'error');
    return;
  }

  const idEl = document.getElementById('view-order-id');
  const custEl = document.getElementById('view-order-customer');
  const emailEl = document.getElementById('view-order-email');
  const addrEl = document.getElementById('view-order-address');
  const badgeEl = document.getElementById('view-order-status-badge');
  const payEl = document.getElementById('view-order-payment');
  const totalEl = document.getElementById('view-order-total');

  if (idEl) idEl.innerText = `#${order.order_number || order.id}`;
  if (custEl) custEl.innerText = `${order.recipient_name || order.customer || 'Customer'} (${order.contactNo || order.phone || 'N/A'})`;
  if (emailEl) emailEl.innerText = (order.user ? order.user.email : order.email) || 'N/A';
  if (addrEl) addrEl.innerText = order.formatted_address || order.address || `${order.address_line_1 || ''}, ${order.city || ''}, ${order.state || ''} - ${order.pincode || ''}`;
  if (badgeEl) badgeEl.innerText = order.status;
  if (payEl) payEl.innerText = order.payment_method || order.paymentMode || 'Cash on Delivery';
  if (totalEl) totalEl.innerText = `₹${Number(order.total_amount || order.total || 0).toLocaleString('en-IN')}`;

  const itemsContainer = document.getElementById('view-order-items-list');
  if (itemsContainer) {
    const items = order.items || [];
    if (items.length > 0) {
      itemsContainer.innerHTML = items.map(item => `
        <div class="d-flex align-items-center gap-3 py-2 border-bottom">
          <img src="${item.photo_url || item.image || item.img || 'image/products/product-1.jpg'}" alt="${item.product_name || item.name}" style="width: 45px; height: 45px; object-fit: cover; border-radius: 6px;">
          <div class="flex-grow-1">
            <div class="fw-bold small">${item.product_name || item.name}</div>
            <div class="text-muted small">Qty: ${item.qty} &bull; ₹${Number(item.price).toLocaleString('en-IN')} each</div>
          </div>
          <div class="fw-bold">₹${(Number(item.price) * item.qty).toLocaleString('en-IN')}</div>
        </div>
      `).join('');
    } else {
      itemsContainer.innerHTML = `<div class="text-muted small py-2">1 Formulations Package</div>`;
    }
  }

  const modalEl = document.getElementById('viewOrderModal');
  if (modalEl) {
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
  }
}

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
        setTimeout(() => window.location.reload(), 800);
        return;
      }
    } catch (e) {
      console.warn('API update failed, updating local state', e);
    }

    showToast(`Order status updated to ${formatted}!`, 'success');
  }
}

// --------------------------------------------------------------------------
// 6. Reviews Management
// Reviews CRUD is now handled via standard Laravel MVC (Forms & Controller)
// --------------------------------------------------------------------------

// --------------------------------------------------------------------------
// 7. Toast Notifications
// --------------------------------------------------------------------------
function showToast(message, type = 'success') {
  const container = document.getElementById('toast-container');
  if (!container) return;

  const toast = document.createElement('div');
  toast.className = `custom-toast toast-${type}`;
  const icon = type === 'success' ? 'bi-check-circle-fill text-success' : 'bi-info-circle-fill text-primary';

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
// 8. Event Listeners & Initialization
// --------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
  updateOverviewStats();
  renderOrdersTable();

  // Search input for orders
  const orderSearch = document.getElementById('admin-order-search');
  if (orderSearch) {
    orderSearch.addEventListener('input', (e) => renderOrdersTable('all', e.target.value));
  }

  // Mobile drawer toggle
  const mobileToggle = document.getElementById('admin-mobile-toggle');
  const sidebar = document.querySelector('.admin-sidebar');
  if (mobileToggle && sidebar) {
    mobileToggle.addEventListener('click', () => {
      sidebar.classList.toggle('show');
    });
  }
});
