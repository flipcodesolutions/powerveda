/**
 * Yuvar Dhan - Premium Wellness & Strength
 * JavaScript Interactive Functionality (Static Product DOM Integration)
 */

/**
 * Yuvar Dhan - Helper Functions
 */
function escapeHtml(str) {
  if (str === null || str === undefined) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

// --------------------------------------------------------------------------
// 1. Products Database Definition (Used for Cart & Quick View)
// --------------------------------------------------------------------------
let productsData = [
  {
    id: 1,
    name: "Yuvar Dhan Ashwagandha Gold KSM-66",
    price: 1499,
    originalPrice: 1999,
    discount: "25% OFF",
    rating: 5.0,
    reviews: 240,
    badge: "NATURAL",
    image: "/image/products/product-1.jpg",
    description: "Premium full-spectrum organic root extract designed to boost physical vitality, reduce stress, and enhance muscle endurance."
  },
  {
    id: 2,
    name: "Yuvar Dhan Himalayan Detox Elixir",
    price: 899,
    originalPrice: 1199,
    discount: "25% OFF",
    rating: 4.8,
    reviews: 135,
    badge: "100% PURE",
    image: "/image/products/product-2.jpg",
    description: "Handcrafted botanical blend of holy tulsi, lemongrass, and antioxidant herbs for cellular rejuvenation and daily detox."
  },
  {
    id: 3,
    name: "Yuvar Dhan 24K Saffron Radiance Elixir",
    price: 2499,
    originalPrice: 3299,
    discount: "24% OFF",
    rating: 5.0,
    reviews: 310,
    badge: "PREMIUM",
    image: "/image/products/product-3.jpg",
    description: "Sacred facial and skin radiance elixir formulated with pure Kashmiri saffron, sandalwood, and lotus blossoms."
  },
  {
    id: 4,
    name: "Yuvar Dhan Triphala Gut Vitality",
    price: 799,
    originalPrice: 999,
    discount: "20% OFF",
    rating: 4.7,
    reviews: 95,
    badge: "VITALITY",
    image: "/image/products/product-4.jpg",
    description: "Time-tested three-fruit botanical formula supporting digestion, nutrient absorption, and body purification."
  },
  {
    id: 5,
    name: "Yuvar Dhan Brahmi Mind Focus Tonic",
    price: 1199,
    originalPrice: 1599,
    discount: "25% OFF",
    rating: 4.9,
    reviews: 160,
    badge: "STRENGTH",
    image: "/image/products/product-5.jpg",
    description: "Cognitive enhancement formulation supporting peak memory clarity, sharp focus, and nervous system health."
  },
  {
    id: 6,
    name: "Yuvar Dhan Turmeric Curcumin 95%",
    price: 1299,
    originalPrice: 1699,
    discount: "23% OFF",
    rating: 4.9,
    reviews: 215,
    badge: "IMMUNITY",
    image: "/image/products/product-6.jpg",
    description: "Ultra-potent golden turmeric extract formulated with BioPerine for joint flexibility, vitality, and robust immunity."
  },
  {
    id: 7,
    name: "Yuvar Dhan Neem & Tulsi Purifying Cleanse",
    price: 699,
    originalPrice: 899,
    discount: "22% OFF",
    rating: 4.8,
    reviews: 112,
    badge: "WELLNESS",
    image: "/image/products/product-7.jpg",
    description: "Gentle soap-free foaming wash that balances natural skin oils and deeply purifies pores with sacred botanicals."
  },
  {
    id: 8,
    name: "Yuvar Dhan Cold-Pressed Sweet Almond Oil",
    price: 999,
    originalPrice: 1299,
    discount: "23% OFF",
    rating: 4.9,
    reviews: 180,
    badge: "COLD PRESSED",
    image: "/image/products/product-8.jpg",
    description: "100% unrefined therapeutic oil rich in natural Vitamin E, perfect for restorative body massage and muscle recovery."
  }
];

// --------------------------------------------------------------------------
// 2. State (Cart)
// --------------------------------------------------------------------------
let cart = JSON.parse(localStorage.getItem('powerveda_cart')) || [];

function saveCart() {
  localStorage.setItem('powerveda_cart', JSON.stringify(cart));
  updateCartCounters();
  renderCartDrawer();
  renderCartPage();
}

// --------------------------------------------------------------------------
// 3. Cart Operations (LocalStorage for Guests, MySQL Database for Logged-In Users)
// --------------------------------------------------------------------------
async function addToCart(productOrId, qty = 1, explicitData = null) {
  let product = null;

  if (explicitData && explicitData.name) {
    product = {
      id: explicitData.id || productOrId,
      name: explicitData.name,
      price: parseFloat(explicitData.price) || 0,
      image: explicitData.image || '/image/products/product-1.jpg'
    };
  } else if (typeof productOrId === 'object' && productOrId !== null && productOrId.name) {
    product = {
      id: productOrId.id,
      name: productOrId.name,
      price: parseFloat(productOrId.price) || 0,
      image: productOrId.image || productOrId.photo_url || '/image/products/product-1.jpg'
    };
  } else {
    const productId = parseInt(productOrId, 10);
    // 1. Check in productsData
    if (typeof productsData !== 'undefined' && Array.isArray(productsData)) {
      product = productsData.find(p => p.id === productId || p.id == productOrId);
    }
    // 2. Check in window.dbProducts
    if (!product && typeof window !== 'undefined' && Array.isArray(window.dbProducts)) {
      const dbP = window.dbProducts.find(p => p.id === productId || p.id == productOrId);
      if (dbP) {
        const pImg = dbP.photo_url || (dbP.photo ? (dbP.photo.startsWith('http') ? dbP.photo : (dbP.photo.startsWith('/') ? dbP.photo : '/' + dbP.photo)) : '/image/products/product-1.jpg');
        product = {
          id: dbP.id,
          name: dbP.name,
          price: parseFloat(dbP.price) || 0,
          image: pImg
        };
      }
    }
    // 3. Check in DOM directly from cards
    if (!product && typeof document !== 'undefined') {
      const cardEl = document.querySelector(`.product-card[data-id="${productId}"], [data-product-id="${productId}"], .hero-product-card`);
      if (cardEl) {
        const titleEl = cardEl.querySelector('.product-title, h3, h4');
        const priceEl = cardEl.querySelector('.price-discounted, .fw-bold, .fs-5');
        const imgEl = cardEl.querySelector('img');
        if (titleEl) {
          const rawPrice = priceEl ? priceEl.innerText.replace(/[^0-9.]/g, '') : '0';
          product = {
            id: productId || productOrId,
            name: titleEl.innerText.trim(),
            price: parseFloat(rawPrice) || 0,
            image: imgEl ? imgEl.getAttribute('src') : '/image/products/product-1.jpg'
          };
        }
      }
    }
  }

  if (!product) {
    console.warn('addToCart: Product not found for ID', productOrId);
    // Safe fallback to ensure adding always succeeds
    product = {
      id: productOrId,
      name: 'Yuvar Dhan Formulation',
      price: 999,
      image: '/image/products/product-1.jpg'
    };
  }

  const existing = cart.find(item => item.id == product.id);
  if (existing) {
    existing.qty += qty;
  } else {
    cart.push({
      id: product.id,
      name: product.name,
      price: product.price,
      image: product.image,
      qty: qty
    });
  }

  saveCart();
  showToast(`${product.name} added to cart!`, 'success');

  // If user is logged in, persist directly in MySQL database
  if (currentUser) {
    try {
      const res = await fetch('/cart/add', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({
          product_id: product.id,
          qty: qty,
          name: product.name,
          price: product.price,
          image: product.image
        })
      });
      if (res.ok) {
        const data = await res.json();
        if (data.items) {
          cart = data.items;
          saveCart();
        }
      }
    } catch (e) {
      console.debug('Failed to sync added cart item with server:', e);
    }
  }
}

async function updateCartQty(productId, delta) {
  const item = cart.find(i => i.id == productId);
  if (!item) return;

  item.qty += delta;
  if (item.qty <= 0) {
    removeFromCart(productId);
    return;
  }
  saveCart();

  // If user is logged in, update directly in database
  if (currentUser) {
    try {
      const res = await fetch('/cart/update', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({
          product_id: productId,
          qty: item.qty
        })
      });
      if (res.ok) {
        const data = await res.json();
        if (data.items) {
          cart = data.items;
          saveCart();
        }
      }
    } catch (e) {
      console.debug('Failed to sync updated cart quantity with server:', e);
    }
  }
}

async function removeFromCart(productId) {
  const item = cart.find(i => i.id == productId);
  cart = cart.filter(i => i.id != productId);
  saveCart();
  if (item) {
    showToast(`${item.name} removed from cart.`, 'info');
  }

  // If user is logged in, remove directly from database
  if (currentUser) {
    try {
      const res = await fetch('/cart/remove', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({
          product_id: productId
        })
      });
      if (res.ok) {
        const data = await res.json();
        if (data.items) {
          cart = data.items;
          saveCart();
        }
      }
    } catch (e) {
      console.debug('Failed to sync item removal with server:', e);
    }
  }
}

async function clearCart() {
  cart = [];
  saveCart();
  showToast('Cart cleared', 'info');

  // If user is logged in, clear database cart
  if (currentUser) {
    try {
      await fetch('/cart/clear', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': getCsrfToken()
        }
      });
    } catch (e) {
      console.debug('Failed to sync clear cart with server:', e);
    }
  }
}

async function syncGuestCartWithServer() {
  if (!currentUser) return;
  try {
    const res = await fetch('/cart/sync', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken()
      },
      body: JSON.stringify({ items: cart })
    });
    if (res.ok) {
      const data = await res.json();
      if (data.items) {
        cart = data.items;
        saveCart();
      }
    }
  } catch (e) {
    console.debug('Cart sync error:', e);
  }
}

function updateCartCounters() {
  const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
  document.querySelectorAll('.badge-cart-val').forEach(el => {
    el.innerText = totalItems;
  });
}

function renderCartDrawer() {
  const container = document.getElementById('cart-items-list');
  const footer = document.getElementById('cart-footer');
  if (!container) return;

  if (cart.length === 0) {
    container.innerHTML = `
      <div class="text-center py-5 px-3">
        <i class="bi bi-bag-x fs-1 text-muted mb-3 d-block"></i>
        <h5 class="fw-bold" style="color: var(--heading-color);">Your Cart is Empty</h5>
        <p class="text-muted small">Explore our pure wellness range to experience strength & vitality.</p>
        <a class="btn btn-primary btn-sm mt-2" href="/cart">
          Go to Cart Page
        </a>
      </div>
    `;
    if (footer) footer.style.display = 'none';
    return;
  }

  if (footer) footer.style.display = 'block';

  let subtotal = 0;
  container.innerHTML = cart.map(item => {
    const itemTotal = item.price * item.qty;
    subtotal += itemTotal;
    const imgSrc = item.image ? (item.image.startsWith('http') || item.image.startsWith('/') ? item.image : '/' + item.image) : '/image/products/product-1.jpg';
    return `
      <div class="cart-item">
        <img src="${imgSrc}" alt="${escapeHtml(item.name)}" class="cart-item-img">
        <div class="cart-item-info">
          <div class="cart-item-title">${escapeHtml(item.name)}</div>
          <div class="cart-item-price">₹${item.price.toLocaleString('en-IN')}</div>
          <div class="cart-qty-control">
            <button class="cart-qty-btn" onclick="updateCartQty(${item.id}, -1)">-</button>
            <span class="cart-qty-val">${item.qty}</span>
            <button class="cart-qty-btn" onclick="updateCartQty(${item.id}, 1)">+</button>
          </div>
        </div>
        <button class="cart-item-remove" onclick="removeFromCart(${item.id})" title="Remove">
          <i class="bi bi-trash3"></i>
        </button>
      </div>
    `;
  }).join('');

  const shipping = subtotal >= 999 || subtotal === 0 ? 0 : 99;
  const total = subtotal + shipping;

  const subtotalEl = document.getElementById('cart-subtotal');
  const shippingEl = document.getElementById('cart-shipping');
  const totalEl = document.getElementById('cart-total');

  if (subtotalEl) subtotalEl.innerText = `₹${subtotal.toLocaleString('en-IN')}`;
  if (shippingEl) shippingEl.innerText = shipping === 0 ? 'FREE' : `₹${shipping}`;
  if (totalEl) totalEl.innerText = `₹${total.toLocaleString('en-IN')}`;
}

// --------------------------------------------------------------------------
// 3.1 Dedicated Cart Page Renderer
// --------------------------------------------------------------------------
function renderCartPage() {
  const loadedContent = document.getElementById('cart-page-loaded-content');
  const emptyState = document.getElementById('cart-page-empty-state');
  const tableBody = document.getElementById('cart-page-table-tbody');
  const mobileCards = document.getElementById('cart-page-mobile-cards');
  
  if (!loadedContent && !emptyState && !tableBody) return;

  const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
  const itemsWordEl = document.getElementById('cart-items-word');
  if (itemsWordEl) {
    itemsWordEl.innerText = totalItems === 1 ? 'item' : 'items';
  }

  if (cart.length === 0) {
    if (loadedContent) loadedContent.classList.add('d-none');
    if (emptyState) emptyState.classList.remove('d-none');
    return;
  }

  if (loadedContent) loadedContent.classList.remove('d-none');
  if (emptyState) emptyState.classList.add('d-none');

  let subtotal = 0;

  // Render Desktop Table Rows
  if (tableBody) {
    tableBody.innerHTML = cart.map(item => {
      const itemTotal = item.price * item.qty;
      subtotal += itemTotal;
      const imgSrc = item.image ? (item.image.startsWith('http') || item.image.startsWith('/') ? item.image : '/' + item.image) : '/image/products/product-1.jpg';
      const detailUrl = item.slug ? `/product/${item.slug}` : `/product/${item.id}`;

      return `
        <tr>
          <td class="py-3 ps-4">
            <div class="d-flex align-items-center gap-3">
              <a href="${detailUrl}">
                <img src="${imgSrc}" alt="${escapeHtml(item.name)}" class="rounded-3 border object-fit-cover shadow-xs" style="width: 64px; height: 64px; object-fit: cover;">
              </a>
              <div>
                <a href="${detailUrl}" class="d-block fw-bold text-decoration-none" style="color: var(--heading-color); font-size: 0.95rem;">
                  ${escapeHtml(item.name)}
                </a>
                <span class="badge bg-light text-secondary border small mt-1" style="font-size: 0.68rem;">100% Pure Formulation</span>
              </div>
            </div>
          </td>
          <td class="py-3">
            <span class="fw-bold" style="color: var(--heading-color);">₹${item.price.toLocaleString('en-IN')}</span>
          </td>
          <td class="py-3 text-center">
            <div class="cart-qty-control d-inline-flex" style="background: #FFFFFF;">
              <button type="button" class="cart-qty-btn" onclick="updateCartQty(${item.id}, -1)" aria-label="Decrease quantity">-</button>
              <span class="cart-qty-val">${item.qty}</span>
              <button type="button" class="cart-qty-btn" onclick="updateCartQty(${item.id}, 1)" aria-label="Increase quantity">+</button>
            </div>
          </td>
          <td class="py-3 text-end">
            <span class="fw-bold fs-6" style="color: var(--heading-color);">₹${itemTotal.toLocaleString('en-IN')}</span>
          </td>
          <td class="py-3 pe-4 text-end">
            <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-circle" onclick="removeFromCart(${item.id})" title="Remove ${escapeHtml(item.name)}" style="width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;">
              <i class="bi bi-trash3"></i>
            </button>
          </td>
        </tr>
      `;
    }).join('');
  } else {
    subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
  }

  // Render Mobile Cards
  if (mobileCards) {
    mobileCards.innerHTML = cart.map(item => {
      const itemTotal = item.price * item.qty;
      const imgSrc = item.image ? (item.image.startsWith('http') || item.image.startsWith('/') ? item.image : '/' + item.image) : '/image/products/product-1.jpg';
      const detailUrl = item.slug ? `/product/${item.slug}` : `/product/${item.id}`;

      return `
        <div class="p-3 rounded-3 border bg-white shadow-xs">
          <div class="d-flex align-items-start gap-3 mb-3">
            <a href="${detailUrl}">
              <img src="${imgSrc}" alt="${escapeHtml(item.name)}" class="rounded-3 border" style="width: 60px; height: 60px; object-fit: cover;">
            </a>
            <div class="flex-grow-1">
              <a href="${detailUrl}" class="d-block fw-bold text-decoration-none small" style="color: var(--heading-color);">
                ${escapeHtml(item.name)}
              </a>
              <span class="text-muted small">₹${item.price.toLocaleString('en-IN')} each</span>
            </div>
            <button type="button" class="btn btn-sm text-danger border-0 p-1" onclick="removeFromCart(${item.id})" title="Remove">
              <i class="bi bi-trash3 fs-6"></i>
            </button>
          </div>
          <div class="d-flex justify-content-between align-items-center pt-2 border-top">
            <div class="cart-qty-control" style="background: #FAFAFA;">
              <button type="button" class="cart-qty-btn" onclick="updateCartQty(${item.id}, -1)">-</button>
              <span class="cart-qty-val">${item.qty}</span>
              <button type="button" class="cart-qty-btn" onclick="updateCartQty(${item.id}, 1)">+</button>
            </div>
            <div>
              <span class="small text-muted me-1">Subtotal:</span>
              <strong class="text-dark">₹${itemTotal.toLocaleString('en-IN')}</strong>
            </div>
          </div>
        </div>
      `;
    }).join('');
  }

  const shipping = subtotal >= 999 || subtotal === 0 ? 0 : 99;
  const total = subtotal + shipping;

  const subtotalEl = document.getElementById('cart-page-subtotal');
  const shippingEl = document.getElementById('cart-page-shipping');
  const totalEl = document.getElementById('cart-page-total');
  const freeShippingMsgEl = document.getElementById('free-shipping-msg');
  const freeShippingProgressEl = document.getElementById('free-shipping-progress');

  if (subtotalEl) subtotalEl.innerText = `₹${subtotal.toLocaleString('en-IN')}`;
  if (shippingEl) shippingEl.innerText = shipping === 0 ? 'FREE' : `₹${shipping}`;
  if (totalEl) totalEl.innerText = `₹${total.toLocaleString('en-IN')}`;

  if (freeShippingMsgEl && freeShippingProgressEl) {
    if (subtotal >= 999) {
      freeShippingMsgEl.innerHTML = `🎉 <strong>Congratulations!</strong> You qualify for <strong>FREE Express Shipping</strong> across India!`;
      freeShippingProgressEl.style.width = '100%';
      freeShippingProgressEl.className = 'progress-bar bg-success';
    } else {
      const remaining = 999 - subtotal;
      freeShippingProgressEl.style.width = `${Math.min(100, Math.round((subtotal / 999) * 100))}%`;
      freeShippingProgressEl.className = 'progress-bar bg-warning';
      freeShippingMsgEl.innerHTML = `Add <strong class="text-primary">₹${remaining.toLocaleString('en-IN')}</strong> more to unlock <strong>FREE Express Shipping</strong>!`;
    }
  }
}

// --------------------------------------------------------------------------
// 4. Product Details Navigation
// --------------------------------------------------------------------------
function openQuickView(productIdOrSlug) {
  let product = null;
  if (typeof window !== 'undefined' && Array.isArray(window.dbProducts)) {
    product = window.dbProducts.find(p => p.id === parseInt(productIdOrSlug, 10) || p.slug === productIdOrSlug);
  }
  if (product && product.slug) {
    window.location.href = `/product/${product.slug}`;
  } else if (productIdOrSlug) {
    window.location.href = `/product/${productIdOrSlug}`;
  }
}

// --------------------------------------------------------------------------
// 6. Search Filtering (Direct DOM Filter on Static HTML Cards)
// --------------------------------------------------------------------------
function setupSearch() {
  const searchInput = document.getElementById('product-search');
  const countEl = document.getElementById('formulation-count');
  if (!searchInput) return;

  searchInput.addEventListener('input', (e) => {
    const query = e.target.value.toLowerCase().trim();
    const productCols = document.querySelectorAll('.product-item-col');
    let visibleCount = 0;

    productCols.forEach(col => {
      const title = col.getAttribute('data-title') || '';
      const text = col.innerText || '';
      if (title.toLowerCase().includes(query) || text.toLowerCase().includes(query)) {
        col.style.display = 'block';
        visibleCount++;
      } else {
        col.style.display = 'none';
      }
    });

    if (countEl) {
      countEl.innerText = visibleCount;
    }
  });
}

// --------------------------------------------------------------------------
// 7. Flash Deal Countdown Timer
// --------------------------------------------------------------------------
function startCountdownTimer() {
  let targetTime = new Date().getTime() + (14 * 60 * 60 * 1000) + (30 * 60 * 1000);

  const hoursEl = document.getElementById('timer-hours');
  const minutesEl = document.getElementById('timer-minutes');
  const secondsEl = document.getElementById('timer-seconds');

  if (!hoursEl || !minutesEl || !secondsEl) return;

  function update() {
    const now = new Date().getTime();
    const distance = targetTime - now;

    if (distance <= 0) {
      targetTime = new Date().getTime() + (24 * 60 * 60 * 1000);
      return;
    }

    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    hoursEl.innerText = hours.toString().padStart(2, '0');
    minutesEl.innerText = minutes.toString().padStart(2, '0');
    secondsEl.innerText = seconds.toString().padStart(2, '0');
  }

  update();
  setInterval(update, 1000);
}

// --------------------------------------------------------------------------
// 8. Toast Notifications & Newsletter
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

function setupNewsletter() {
  const form = document.getElementById('newsletter-form');
  if (!form) return;

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const input = document.getElementById('newsletter-email');
    const email = input.value.trim();

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      showToast('Please enter a valid email address.', 'info');
      input.focus();
      return;
    }

    showToast('Welcome to Yuvar Dhan Circle! Use code POWER35 for 35% off.', 'success');
    input.value = '';
  });
}

// --------------------------------------------------------------------------
// 9. Navigation, Smooth Scroll with Offset, Mobile Drawer & Active Highlights
// --------------------------------------------------------------------------
function scrollToTargetWithOffset(targetSelector, smooth = true) {
  if (!targetSelector) return;
  const targetId = targetSelector.replace(/^#/, '');
  const targetEl = document.getElementById(targetId) || document.querySelector(targetSelector);
  if (!targetEl) return false;

  const header = document.querySelector('.site-header');
  const headerHeight = header ? header.getBoundingClientRect().height : 80;
  const offset = headerHeight + 10;
  const elementPosition = targetEl.getBoundingClientRect().top + window.pageYOffset;
  const offsetPosition = Math.max(0, elementPosition - offset);

  window.scrollTo({
    top: offsetPosition,
    behavior: smooth ? 'smooth' : 'auto'
  });
  return true;
}

function closeMobileDrawer() {
  const drawerEl = document.getElementById('mobileNavDrawer');
  if (!drawerEl) return;

  // 1. Trigger close button click if present
  const closeBtn = drawerEl.querySelector('.mobile-nav-close-btn');
  if (closeBtn) {
    closeBtn.click();
  }

  // 2. Hide via Bootstrap Offcanvas API
  try {
    if (typeof bootstrap !== 'undefined' && bootstrap.Offcanvas) {
      const bsOffcanvas = bootstrap.Offcanvas.getInstance(drawerEl) || bootstrap.Offcanvas.getOrCreateInstance(drawerEl);
      if (bsOffcanvas) {
        bsOffcanvas.hide();
      }
    }
  } catch (err) {
    console.warn('Offcanvas hide exception', err);
  }

  // 3. Fallback cleanup
  setTimeout(() => {
    if (drawerEl.classList.contains('show')) {
      drawerEl.classList.remove('show', 'showing');
      const backdrops = document.querySelectorAll('.offcanvas-backdrop');
      backdrops.forEach(b => b.remove());
      document.body.classList.remove('modal-open');
      document.body.style.removeProperty('overflow');
      document.body.style.removeProperty('padding-right');
    }
  }, 250);
}

function setupNavigation() {
  const header = document.querySelector('.site-header');
  const backToTopBtn = document.getElementById('back-to-top');
  const drawerEl = document.getElementById('mobileNavDrawer');

  // 1. Sticky Header & Back-To-Top Button
  window.addEventListener('scroll', () => {
    const scrollY = window.scrollY;

    if (header) {
      if (scrollY > 40) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    }

    if (backToTopBtn) {
      if (scrollY > 350) {
        backToTopBtn.classList.add('visible');
      } else {
        backToTopBtn.classList.remove('visible');
      }
    }

    updateActiveNavLinks();
  });

  if (backToTopBtn) {
    backToTopBtn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // 2. Mobile Drawer Navigation Links (Always close drawer & smooth scroll/redirect)
  const drawerLinks = document.querySelectorAll('#mobileNavDrawer a, #mobileNavDrawer button:not(.mobile-nav-close-btn)');
  drawerLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      if (link.id === 'mobile-auth-link' || link.classList.contains('mobile-login-btn')) return;

      const href = link.getAttribute('href');
      closeMobileDrawer();

      if (href) {
        const hashIdx = href.indexOf('#');
        if (hashIdx !== -1) {
          const hash = href.substring(hashIdx);
          const targetEl = document.querySelector(hash);
          if (targetEl) {
            e.preventDefault();
            setTimeout(() => {
              scrollToTargetWithOffset(hash, true);
              if (history.pushState) {
                history.pushState(null, null, hash);
              }
            }, 200);
          }
        }
      }
    });
  });

  // 3. Desktop Navigation Links
  const desktopLinks = document.querySelectorAll('.navbar-nav a');
  desktopLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      const href = link.getAttribute('href');
      if (!href || href === '#' || href.startsWith('javascript:')) return;

      const hashIdx = href.indexOf('#');
      if (hashIdx !== -1) {
        const hash = href.substring(hashIdx);
        const targetEl = document.querySelector(hash);
        if (targetEl) {
          e.preventDefault();
          scrollToTargetWithOffset(hash, true);
          if (history.pushState) {
            history.pushState(null, null, hash);
          }
        }
      }
    });
  });

  // 4. Mobile Login / Register Button trigger
  const mobileAuthBtn = document.getElementById('mobile-auth-link');
  if (mobileAuthBtn) {
    mobileAuthBtn.addEventListener('click', (e) => {
      e.preventDefault();
      closeMobileDrawer();
      setTimeout(() => {
        const authModalEl = document.getElementById('authModal');
        if (authModalEl) {
          const authModal = bootstrap.Modal.getOrCreateInstance(authModalEl);
          authModal.show();
        }
      }, 250);
    });
  }

  // 5. Auto-Scroll on Page Load if URL has a Hash
  if (window.location.hash) {
    setTimeout(() => {
      scrollToTargetWithOffset(window.location.hash, true);
    }, 250);
  }
}

// --------------------------------------------------------------------------
// 9.1 Active Navigation Item Highlighting on Scroll
// --------------------------------------------------------------------------
function updateActiveNavLinks() {
  const sections = document.querySelectorAll('section[id]');
  if (!sections.length) return;

  const scrollY = window.scrollY;
  const header = document.querySelector('.site-header');
  const headerHeight = (header ? header.getBoundingClientRect().height : 80) + 20;

  let currentSectionId = '';
  sections.forEach(section => {
    const sectionTop = section.offsetTop - headerHeight;
    const sectionHeight = section.offsetHeight;
    if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
      currentSectionId = section.getAttribute('id');
    }
  });

  if (currentSectionId) {
    const allLinks = document.querySelectorAll('.navbar-nav .nav-link, .mobile-nav-list .mobile-nav-link');
    allLinks.forEach(link => {
      const href = link.getAttribute('href') || '';
      if (href.endsWith('#' + currentSectionId) || href === '#' + currentSectionId) {
        link.classList.add('active');
      } else if (href.includes('#')) {
        link.classList.remove('active');
      }
    });
  }
}

// --------------------------------------------------------------------------
// --------------------------------------------------------------------------
// 10. User Authentication & Account Management (Laravel MySQL Integration)
// --------------------------------------------------------------------------
let currentUser = JSON.parse(localStorage.getItem('powerveda_user')) || null;

function getCsrfToken() {
  const tokenMeta = document.querySelector('meta[name="csrf-token"]');
  return tokenMeta ? tokenMeta.getAttribute('content') : '';
}

function switchAuthTab(tabName) {
  const tabBtn = document.getElementById(tabName === 'register' ? 'register-tab' : 'login-tab');
  if (tabBtn) {
    const tab = new bootstrap.Tab(tabBtn);
    tab.show();
  }
}

async function checkAuthStatus() {
  try {
    const response = await fetch('/user/me', {
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken()
      }
    });
    if (response.ok) {
      const data = await response.json();
      if (data.authenticated && data.user) {
        currentUser = data.user;
        localStorage.setItem('powerveda_user', JSON.stringify(currentUser));
        if (data.cart) {
          cart = data.cart;
          saveCart();
        }
      } else {
        currentUser = null;
        localStorage.removeItem('powerveda_user');
      }
      updateAccountUI();
    }
  } catch (err) {
    updateAccountUI();
  }
}

function updateAccountUI() {
  const desktopBtn = document.getElementById('desktop-account-btn');
  const accountDropdownWrapper = document.getElementById('account-dropdown-wrapper');
  const desktopUserDropdownBtn = document.getElementById('desktop-user-dropdown-btn');
  const desktopHeaderUserName = document.getElementById('desktop-header-user-name');
  const dropdownUserName = document.getElementById('dropdown-user-name');
  const dropdownUserRole = document.getElementById('dropdown-user-role');
  const dropdownAdminItem = document.getElementById('dropdown-admin-item');
  const desktopOrdersBtn = document.getElementById('desktop-orders-btn');
  const navMyOrdersItem = document.getElementById('nav-my-orders-item');

  const mobileHeaderAccountBtn = document.getElementById('mobile-header-account-btn');
  const mobileHeaderGuestBtn = document.getElementById('mobile-header-guest-btn');

  const mobileGuestAuthBlock = document.getElementById('mobile-guest-auth-block');
  const mobileUserAuthBlock = document.getElementById('mobile-user-auth-block');
  const mobileUserName = document.getElementById('mobile-user-name');
  const mobileUserRole = document.getElementById('mobile-user-role');
  const mobileAdminItem = document.getElementById('mobile-admin-item');
  const mobileOrdersItem = document.getElementById('mobile-orders-item');
  const mobileLogoutItem = document.getElementById('mobile-logout-item');

  const accountSidebarSigninBtn = document.getElementById('account-sidebar-signin-btn');
  const accountSidebarLogoutBtn = document.getElementById('account-sidebar-logout-btn');

  if (currentUser) {
    const firstName = (currentUser.name || 'Member').split(' ')[0];
    const isAdmin = currentUser.is_admin || currentUser.role === 'Admin';

    // 1. Desktop Account State
    if (desktopBtn) desktopBtn.classList.add('d-none');
    if (accountDropdownWrapper) accountDropdownWrapper.classList.remove('d-none');
    if (desktopUserDropdownBtn) {
      desktopUserDropdownBtn.classList.remove('d-none');
      desktopUserDropdownBtn.title = `Signed in as ${currentUser.name} (${currentUser.role || 'User'})`;
    }
    if (desktopHeaderUserName) desktopHeaderUserName.innerText = firstName;
    if (dropdownUserName) dropdownUserName.innerText = currentUser.name || 'Member';
    if (dropdownUserRole) dropdownUserRole.innerText = currentUser.role || 'User';
    if (dropdownAdminItem) dropdownAdminItem.classList.toggle('d-none', !isAdmin);

    // 2. Orders Button & Main Nav Menu Link
    if (desktopOrdersBtn) desktopOrdersBtn.classList.remove('d-none');
    if (navMyOrdersItem) navMyOrdersItem.classList.remove('d-none');

    // 3. Mobile Header & Drawer Account State
    if (mobileHeaderAccountBtn) mobileHeaderAccountBtn.classList.remove('d-none');
    if (mobileHeaderGuestBtn) mobileHeaderGuestBtn.classList.add('d-none');

    if (mobileGuestAuthBlock) mobileGuestAuthBlock.classList.add('d-none');
    if (mobileUserAuthBlock) mobileUserAuthBlock.classList.remove('d-none');
    if (mobileUserName) mobileUserName.innerText = currentUser.name || 'Member';
    if (mobileUserRole) mobileUserRole.innerText = currentUser.role || 'User';
    if (mobileAdminItem) mobileAdminItem.classList.toggle('d-none', !isAdmin);
    if (mobileOrdersItem) mobileOrdersItem.classList.remove('d-none');
    if (mobileLogoutItem) mobileLogoutItem.classList.remove('d-none');

    // 4. Account Page Sidebar Buttons
    if (accountSidebarSigninBtn) accountSidebarSigninBtn.classList.add('d-none');
    if (accountSidebarLogoutBtn) accountSidebarLogoutBtn.classList.remove('d-none');
  } else {
    // 1. Desktop Account State
    if (desktopBtn) {
      desktopBtn.classList.remove('d-none');
      desktopBtn.title = 'Login / Register';
    }
    if (accountDropdownWrapper) accountDropdownWrapper.classList.add('d-none');
    if (desktopUserDropdownBtn) desktopUserDropdownBtn.classList.add('d-none');
    if (desktopOrdersBtn) desktopOrdersBtn.classList.add('d-none');
    if (navMyOrdersItem) navMyOrdersItem.classList.add('d-none');

    // 2. Mobile Header & Drawer Account State
    if (mobileHeaderAccountBtn) mobileHeaderAccountBtn.classList.add('d-none');
    if (mobileHeaderGuestBtn) mobileHeaderGuestBtn.classList.remove('d-none');

    if (mobileGuestAuthBlock) mobileGuestAuthBlock.classList.remove('d-none');
    if (mobileUserAuthBlock) mobileUserAuthBlock.classList.add('d-none');
    if (mobileOrdersItem) mobileOrdersItem.classList.add('d-none');
    if (mobileLogoutItem) mobileLogoutItem.classList.add('d-none');

    // 3. Account Page Sidebar Buttons
    if (accountSidebarSigninBtn) accountSidebarSigninBtn.classList.remove('d-none');
    if (accountSidebarLogoutBtn) accountSidebarLogoutBtn.classList.add('d-none');
  }
}

async function handleLoginSubmit(event) {
  event.preventDefault();
  const alertEl = document.getElementById('login-alert');
  const spinnerEl = document.getElementById('login-spinner');
  const submitBtn = document.getElementById('login-submit-btn');
  const emailInput = document.getElementById('login-email');
  const passwordInput = document.getElementById('login-password');
  const rememberInput = document.getElementById('remember-me');

  if (alertEl) {
    alertEl.classList.add('d-none');
    alertEl.innerText = '';
  }
  if (spinnerEl) spinnerEl.classList.remove('d-none');
  if (submitBtn) submitBtn.disabled = true;

  try {
    const response = await fetch('/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken()
      },
      body: JSON.stringify({
        login: emailInput ? emailInput.value.trim() : '',
        password: passwordInput ? passwordInput.value : '',
        remember: rememberInput ? rememberInput.checked : true,
        guest_cart: cart
      })
    });

    const data = await response.json();

    if (response.ok && data.success) {
      currentUser = data.user;
      localStorage.setItem('powerveda_user', JSON.stringify(currentUser));
      if (data.cart) {
        cart = data.cart;
        saveCart();
      }
      updateAccountUI();

      const authModalEl = document.getElementById('authModal');
      const modal = bootstrap.Modal.getInstance(authModalEl);
      if (modal) modal.hide();

      showToast(data.message || `Welcome back, ${currentUser.name}!`, 'success');

      if (data.user && data.user.is_admin) {
        setTimeout(() => {
          showToast('Admin Access detected. You can manage the store from Admin Console.', 'info');
        }, 1500);
      }
    } else {
      const errMsg = (data.errors && Object.values(data.errors).flat()[0]) || data.message || 'Login failed. Please check your credentials.';
      if (alertEl) {
        alertEl.innerText = errMsg;
        alertEl.classList.remove('d-none');
      } else {
        showToast(errMsg, 'error');
      }
    }
  } catch (err) {
    if (alertEl) {
      alertEl.innerText = 'Unable to connect to server. Please try again.';
      alertEl.classList.remove('d-none');
    }
  } finally {
    if (spinnerEl) spinnerEl.classList.add('d-none');
    if (submitBtn) submitBtn.disabled = false;
  }
}

async function handleRegisterSubmit(event) {
  event.preventDefault();
  const alertEl = document.getElementById('register-alert');
  const spinnerEl = document.getElementById('register-spinner');
  const submitBtn = document.getElementById('register-submit-btn');
  const nameInput = document.getElementById('reg-name');
  const emailInput = document.getElementById('reg-email');
  const phoneInput = document.getElementById('reg-phone');
  const passwordInput = document.getElementById('reg-password');

  if (alertEl) {
    alertEl.classList.add('d-none');
    alertEl.innerText = '';
  }
  if (spinnerEl) spinnerEl.classList.remove('d-none');
  if (submitBtn) submitBtn.disabled = true;

  try {
    const response = await fetch('/register', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken()
      },
      body: JSON.stringify({
        name: nameInput ? nameInput.value.trim() : '',
        email: emailInput ? emailInput.value.trim() : '',
        contactNo: phoneInput ? phoneInput.value.trim() : '',
        password: passwordInput ? passwordInput.value : '',
        guest_cart: cart
      })
    });

    const data = await response.json();

    if (response.ok && data.success) {
      currentUser = data.user;
      localStorage.setItem('powerveda_user', JSON.stringify(currentUser));
      if (data.cart) {
        cart = data.cart;
        saveCart();
      }
      updateAccountUI();

      const authModalEl = document.getElementById('authModal');
      const modal = bootstrap.Modal.getInstance(authModalEl);
      if (modal) modal.hide();

      showToast(data.message || `Welcome to Yuvar Dhan, ${currentUser.name}!`, 'success');
    } else {
      const errMsg = (data.errors && Object.values(data.errors).flat()[0]) || data.message || 'Registration failed. Please check your inputs.';
      if (alertEl) {
        alertEl.innerText = errMsg;
        alertEl.classList.remove('d-none');
      } else {
        showToast(errMsg, 'error');
      }
    }
  } catch (err) {
    if (alertEl) {
      alertEl.innerText = 'Unable to connect to server. Please try again.';
      alertEl.classList.remove('d-none');
    }
  } finally {
    if (spinnerEl) spinnerEl.classList.add('d-none');
    if (submitBtn) submitBtn.disabled = false;
  }
}

async function handleLogout() {
  try {
    await fetch('/logout', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken()
      }
    });
  } catch (err) {
    console.debug('Logout request error:', err);
  } finally {
    currentUser = null;
    localStorage.removeItem('powerveda_user');
    cart = [];
    saveCart();
    updateAccountUI();
    showToast('You have been signed out successfully.', 'info');
    setTimeout(() => { window.location.reload(); }, 500);
  }
}

function togglePasswordVisibility(inputId, btn) {
  const input = document.getElementById(inputId);
  if (!input) return;

  if (input.type === 'password') {
    input.type = 'text';
    btn.innerHTML = '<i class="bi bi-eye-slash"></i>';
  } else {
    input.type = 'password';
    btn.innerHTML = '<i class="bi bi-eye"></i>';
  }
}

// --------------------------------------------------------------------------
// 11. My Orders & Reorder Logic
// --------------------------------------------------------------------------
function reorderItems(productIds) {
  productIds.forEach(id => addToCart(id, 1));

  // Close orders modal
  const ordersModalEl = document.getElementById('myOrdersModal');
  const ordersModal = bootstrap.Modal.getInstance(ordersModalEl);
  if (ordersModal) ordersModal.hide();

  // Open Cart Drawer
  const cartDrawerEl = document.getElementById('cartOffcanvas');
  if (cartDrawerEl) {
    const bsCart = new bootstrap.Offcanvas(cartDrawerEl);
    bsCart.show();
  }

  showToast('Items added to your bag from past order!', 'success');
}

function trackOrderModal(orderId, statusMsg) {
  showToast(`Tracking #${orderId}: ${statusMsg}`, 'info');
}

// --------------------------------------------------------------------------
// 12. Testimonials Slider Functionality
// --------------------------------------------------------------------------
function setupTestimonialsSlider() {
  const track = document.getElementById('testimonials-slider-track');
  const container = document.getElementById('testimonials-track-container');
  const prevBtn = document.getElementById('testimonial-prev');
  const nextBtn = document.getElementById('testimonial-next');
  const dotsContainer = document.getElementById('testimonials-dots');

  if (!track || !container) return;

  const slides = track.querySelectorAll('.testimonial-slide-item');
  if (slides.length === 0) return;

  let currentIndex = 0;
  let autoplayTimer = null;
  let touchStartX = 0;
  let touchEndX = 0;

  function getVisibleCount() {
    if (window.innerWidth < 768) return 1;
    if (window.innerWidth < 992) return 2;
    return 3;
  }

  function getMaxIndex() {
    const visibleCount = getVisibleCount();
    return Math.max(0, slides.length - visibleCount);
  }

  function renderDots() {
    if (!dotsContainer) return;
    dotsContainer.innerHTML = '';
    const maxIdx = getMaxIndex();
    if (maxIdx <= 0) {
      if (prevBtn) prevBtn.style.display = 'none';
      if (nextBtn) nextBtn.style.display = 'none';
      return;
    }

    if (prevBtn) prevBtn.style.display = 'flex';
    if (nextBtn) nextBtn.style.display = 'flex';

    for (let i = 0; i <= maxIdx; i++) {
      const dot = document.createElement('button');
      dot.type = 'button';
      dot.className = `testimonial-dot ${i === currentIndex ? 'active' : ''}`;
      dot.setAttribute('aria-label', `Go to testimonial slide ${i + 1}`);
      dot.addEventListener('click', () => {
        goToSlide(i);
        resetAutoplay();
      });
      dotsContainer.appendChild(dot);
    }
  }

  function updateDots() {
    if (!dotsContainer) return;
    const dots = dotsContainer.querySelectorAll('.testimonial-dot');
    dots.forEach((dot, idx) => {
      dot.classList.toggle('active', idx === currentIndex);
    });
  }

  function goToSlide(index) {
    const maxIdx = getMaxIndex();
    currentIndex = Math.max(0, Math.min(index, maxIdx));

    const visibleCount = getVisibleCount();
    const gap = 24; // 1.5rem
    const slideWidth = (container.clientWidth - (gap * (visibleCount - 1))) / visibleCount;
    const shift = currentIndex * (slideWidth + gap);

    track.style.transform = `translateX(-${shift}px)`;
    updateDots();

    if (prevBtn) prevBtn.style.opacity = currentIndex === 0 ? '0.5' : '1';
    if (nextBtn) nextBtn.style.opacity = currentIndex === maxIdx ? '0.5' : '1';
  }

  function nextSlide() {
    const maxIdx = getMaxIndex();
    if (currentIndex >= maxIdx) {
      goToSlide(0);
    } else {
      goToSlide(currentIndex + 1);
    }
  }

  function prevSlide() {
    const maxIdx = getMaxIndex();
    if (currentIndex <= 0) {
      goToSlide(maxIdx);
    } else {
      goToSlide(currentIndex - 1);
    }
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      prevSlide();
      resetAutoplay();
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      nextSlide();
      resetAutoplay();
    });
  }

  function startAutoplay() {
    stopAutoplay();
    autoplayTimer = setInterval(() => {
      nextSlide();
    }, 5000);
  }

  function stopAutoplay() {
    if (autoplayTimer) {
      clearInterval(autoplayTimer);
      autoplayTimer = null;
    }
  }

  function resetAutoplay() {
    stopAutoplay();
    startAutoplay();
  }

  container.addEventListener('mouseenter', stopAutoplay);
  container.addEventListener('mouseleave', startAutoplay);

  // Touch Swipe Support
  container.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
    stopAutoplay();
  }, { passive: true });

  container.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    if (touchStartX - touchEndX > 50) {
      nextSlide();
    } else if (touchEndX - touchStartX > 50) {
      prevSlide();
    }
    startAutoplay();
  }, { passive: true });

  window.addEventListener('resize', () => {
    renderDots();
    goToSlide(currentIndex);
  });

  renderDots();
  goToSlide(0);
  startAutoplay();
}

// --------------------------------------------------------------------------
// 14. Contact Form Validation & Submission (JavaScript Validation & AJAX)
// --------------------------------------------------------------------------
function validateContactField(fieldId) {
  const input = document.getElementById(fieldId);
  const errorEl = document.getElementById(`${fieldId}-error`);
  if (!input) return true;

  let isValid = true;
  let errorMessage = '';
  const value = input.value.trim();

  if (fieldId === 'contact-name') {
    if (!value) {
      isValid = false;
      errorMessage = 'Please enter your full name.';
    } else if (value.length < 2) {
      isValid = false;
      errorMessage = 'Full name must be at least 2 characters.';
    }
  } else if (fieldId === 'contact-email') {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!value) {
      isValid = false;
      errorMessage = 'Please enter your email address.';
    } else if (!emailRegex.test(value)) {
      isValid = false;
      errorMessage = 'Please enter a valid email address.';
    }
  } else if (fieldId === 'contact-phone') {
    const phoneDigits = value.replace(/\D/g, '');
    if (!value) {
      isValid = false;
      errorMessage = 'Please enter your contact phone number.';
    } else if (phoneDigits.length < 7 || phoneDigits.length > 15) {
      isValid = false;
      errorMessage = 'Please enter a valid contact number (7-15 digits).';
    }
  } else if (fieldId === 'contact-subject') {
    if (!value) {
      isValid = false;
      errorMessage = 'Please enter a subject.';
    } else if (value.length < 3) {
      isValid = false;
      errorMessage = 'Subject must be at least 3 characters.';
    }
  } else if (fieldId === 'contact-message') {
    if (!value) {
      isValid = false;
      errorMessage = 'Please enter your message.';
    } else if (value.length < 5) {
      isValid = false;
      errorMessage = 'Message must be at least 5 characters.';
    }
  }

  if (!isValid) {
    input.classList.add('is-invalid');
    if (errorEl) {
      errorEl.innerText = errorMessage;
      errorEl.classList.remove('d-none');
    }
  } else {
    input.classList.remove('is-invalid');
    if (errorEl) {
      errorEl.innerText = '';
      errorEl.classList.add('d-none');
    }
  }

  return isValid;
}

function setupContactValidation() {
  const fields = ['contact-name', 'contact-email', 'contact-phone', 'contact-subject', 'contact-message'];
  fields.forEach(fieldId => {
    const input = document.getElementById(fieldId);
    if (input) {
      input.addEventListener('input', () => {
        if (input.classList.contains('is-invalid')) {
          validateContactField(fieldId);
        }
      });
      input.addEventListener('blur', () => {
        validateContactField(fieldId);
      });
    }
  });
}

async function handleContactSubmit(event) {
  event.preventDefault();
  const alertEl = document.getElementById('contact-alert');
  const successAlertEl = document.getElementById('contact-success-alert');
  const spinnerEl = document.getElementById('contact-spinner');
  const submitBtn = document.getElementById('contact-submit-btn');

  const fields = ['contact-name', 'contact-email', 'contact-phone', 'contact-subject', 'contact-message'];
  let isAllValid = true;
  let firstInvalid = null;

  fields.forEach(fieldId => {
    const valid = validateContactField(fieldId);
    if (!valid) {
      isAllValid = false;
      if (!firstInvalid) firstInvalid = document.getElementById(fieldId);
    }
  });

  if (!isAllValid) {
    if (alertEl) {
      alertEl.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i> Please complete all required fields correctly.';
      alertEl.classList.remove('d-none');
    }
    if (successAlertEl) {
      successAlertEl.classList.add('d-none');
    }
    if (firstInvalid) {
      firstInvalid.focus();
    }
    return false;
  }

  if (alertEl) {
    alertEl.classList.add('d-none');
    alertEl.innerText = '';
  }
  if (successAlertEl) {
    successAlertEl.classList.add('d-none');
    successAlertEl.innerText = '';
  }
  if (spinnerEl) spinnerEl.classList.remove('d-none');
  if (submitBtn) submitBtn.disabled = true;

  const nameInput = document.getElementById('contact-name');
  const emailInput = document.getElementById('contact-email');
  const phoneInput = document.getElementById('contact-phone');
  const subjectInput = document.getElementById('contact-subject');
  const messageInput = document.getElementById('contact-message');

  try {
    const response = await fetch('/contact', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken()
      },
      body: JSON.stringify({
        name: nameInput ? nameInput.value.trim() : '',
        email: emailInput ? emailInput.value.trim() : '',
        contactno: phoneInput ? phoneInput.value.trim() : '',
        subject: subjectInput ? subjectInput.value.trim() : '',
        messages: messageInput ? messageInput.value.trim() : ''
      })
    });

    const data = await response.json();

    if (response.ok && data.success) {
      if (successAlertEl) {
        successAlertEl.innerHTML = `<i class="bi bi-check-circle-fill text-success me-2"></i> ${data.message}`;
        successAlertEl.classList.remove('d-none');
      }

      showToast(data.message || 'Thank you! Your message has been sent.', 'success');

      // Reset Form & clear validation states
      const form = document.getElementById('contact-form');
      if (form) form.reset();
      fields.forEach(fieldId => {
        const inp = document.getElementById(fieldId);
        const err = document.getElementById(`${fieldId}-error`);
        if (inp) inp.classList.remove('is-invalid');
        if (err) {
          err.innerText = '';
          err.classList.add('d-none');
        }
      });
    } else {
      const errMsg = (data.errors && Object.values(data.errors).flat()[0]) || data.message || 'Please check all required fields and try again.';
      if (alertEl) {
        alertEl.innerText = errMsg;
        alertEl.classList.remove('d-none');
      } else {
        showToast(errMsg, 'error');
      }

      if (data.errors) {
        const keyMap = {
          'name': 'contact-name',
          'email': 'contact-email',
          'contactno': 'contact-phone',
          'subject': 'contact-subject',
          'messages': 'contact-message'
        };
        for (const [key, msgs] of Object.entries(data.errors)) {
          const fieldId = keyMap[key];
          if (fieldId) {
            const input = document.getElementById(fieldId);
            const err = document.getElementById(`${fieldId}-error`);
            if (input) input.classList.add('is-invalid');
            if (err) {
              err.innerText = msgs[0];
              err.classList.remove('d-none');
            }
          }
        }
      }
    }
  } catch (err) {
    if (alertEl) {
      alertEl.innerText = 'Unable to send message at this time. Please try again or reach us via email.';
      alertEl.classList.remove('d-none');
    }
  } finally {
    if (spinnerEl) spinnerEl.classList.add('d-none');
    if (submitBtn) submitBtn.disabled = false;
  }
}

// --------------------------------------------------------------------------
// 16. Checkout & Order Placement Logic (Login Enforced)
// --------------------------------------------------------------------------
let checkoutUserAddresses = [];

function handleInitiateCheckout() {
  if (!currentUser) {
    const cartEl = document.getElementById('cartOffcanvas');
    if (cartEl) {
      const bsCart = bootstrap.Offcanvas.getInstance(cartEl);
      if (bsCart) bsCart.hide();
    }
    showToast('Please log in or create an account to proceed to checkout.', 'info');
    openAuthModal('login');
    return;
  }

  if (!cart || cart.length === 0) {
    showToast('Your cart is empty. Please add products to place an order.', 'error');
    return;
  }

  const cartEl = document.getElementById('cartOffcanvas');
  if (cartEl) {
    const bsCart = bootstrap.Offcanvas.getInstance(cartEl);
    if (bsCart) bsCart.hide();
  }

  openCheckoutModal();
}

async function openCheckoutModal() {
  const itemsContainer = document.getElementById('checkout-items-list');
  const subtotalEl = document.getElementById('checkout-subtotal');
  const shippingEl = document.getElementById('checkout-shipping');
  const totalEl = document.getElementById('checkout-total');
  const alertEl = document.getElementById('checkout-alert');

  if (alertEl) {
    alertEl.classList.add('d-none');
    alertEl.innerText = '';
  }

  // 1. Calculate & Render summary
  const subtotal = cart.reduce((acc, item) => acc + (item.price * item.qty), 0);
  const shipping = (subtotal >= 999 || subtotal === 0) ? 0 : 99;
  const total = subtotal + shipping;

  if (subtotalEl) subtotalEl.innerText = `₹${subtotal.toLocaleString('en-IN')}`;
  if (shippingEl) {
    shippingEl.innerText = shipping === 0 ? 'FREE' : `₹${shipping}`;
    shippingEl.className = shipping === 0 ? 'fw-semibold text-success' : 'fw-semibold text-dark';
  }
  if (totalEl) totalEl.innerText = `₹${total.toLocaleString('en-IN')}`;

  if (itemsContainer) {
    itemsContainer.innerHTML = cart.map(item => {
      const imgSrc = item.image ? (item.image.startsWith('http') || item.image.startsWith('/') ? item.image : '/' + item.image) : '/image/products/product-1.jpg';
      return `
        <div class="d-flex align-items-center gap-3 py-2 border-bottom">
          <img src="${imgSrc}" alt="${escapeHtml(item.name)}" class="rounded border" style="width: 48px; height: 48px; object-fit: cover;">
          <div class="flex-grow-1">
            <strong class="d-block text-dark small text-truncate" style="max-width: 170px;">${escapeHtml(item.name)}</strong>
            <span class="text-muted small">Qty: ${item.qty} &bull; ₹${Number(item.price).toLocaleString('en-IN')}</span>
          </div>
          <div class="fw-bold text-dark small">₹${(Number(item.price) * item.qty).toLocaleString('en-IN')}</div>
        </div>
      `;
    }).join('');
  }

  // 2. Fetch and render user addresses
  await populateCheckoutAddresses();

  // 3. Show Modal
  const modalEl = document.getElementById('checkoutModal');
  if (modalEl) {
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
  }
}

async function populateCheckoutAddresses() {
  const container = document.getElementById('checkout-saved-addresses-list');
  const newAddressForm = document.getElementById('checkout-new-address-form');
  const toggleBtn = document.getElementById('btn-toggle-new-address');
  if (!container) return;

  try {
    const res = await fetch('/user/addresses', {
      headers: { 'Accept': 'application/json' }
    });
    if (res.ok) {
      const data = await res.json();
      checkoutUserAddresses = data.addresses || [];
    }
  } catch (e) {
    console.error('Failed to load addresses for checkout', e);
  }

  if (checkoutUserAddresses.length > 0) {
    if (newAddressForm) newAddressForm.classList.add('d-none');
    if (toggleBtn) {
      toggleBtn.classList.remove('d-none');
      toggleBtn.innerHTML = '<i class="bi bi-plus-circle"></i> + Add New';
    }

    container.innerHTML = checkoutUserAddresses.map((addr, idx) => `
      <label class="p-3 border rounded-3 d-flex align-items-start gap-3 mb-2 cursor-pointer address-radio-card" style="cursor: pointer; background: #fff;">
        <input class="form-check-input mt-1" type="radio" name="checkout_address_id" value="${addr.id}" ${addr.is_default || idx === 0 ? 'checked' : ''} onchange="onCheckoutAddressChange()">
        <div class="flex-grow-1">
          <div class="d-flex align-items-center gap-2 mb-1">
            <strong class="text-dark small">${addr.recipient_name}</strong>
            <span class="badge bg-light text-dark border" style="font-size: 0.68rem;">${addr.type || 'Home'}</span>
            ${addr.is_default ? '<span class="badge bg-warning text-dark" style="font-size: 0.68rem;">Default</span>' : ''}
          </div>
          <p class="text-muted small mb-1" style="font-size: 0.78rem;">
            ${addr.address_line_1}${addr.address_line_2 ? ', ' + addr.address_line_2 : ''}, ${addr.city}, ${addr.state} - ${addr.pincode}
          </p>
          <span class="text-muted small" style="font-size: 0.75rem;"><i class="bi bi-telephone me-1"></i> ${addr.contactNo}</span>
        </div>
      </label>
    `).join('');
  } else {
    container.innerHTML = '<p class="text-muted small mb-2">No saved address found. Please enter your delivery address below:</p>';
    if (newAddressForm) newAddressForm.classList.remove('d-none');
    if (toggleBtn) toggleBtn.classList.add('d-none');

    if (currentUser) {
      const nameInp = document.getElementById('checkout-recipient-name');
      const phoneInp = document.getElementById('checkout-contact-no');
      if (nameInp && !nameInp.value) nameInp.value = currentUser.name || '';
      if (phoneInp && !phoneInp.value) phoneInp.value = currentUser.contactNo || '';
    }
  }
}

function toggleNewAddressCheckout() {
  const form = document.getElementById('checkout-new-address-form');
  const toggleBtn = document.getElementById('btn-toggle-new-address');
  const radios = document.querySelectorAll('input[name="checkout_address_id"]');

  if (form) {
    const isHidden = form.classList.contains('d-none');
    if (isHidden) {
      form.classList.remove('d-none');
      radios.forEach(r => r.checked = false);
      if (toggleBtn) toggleBtn.innerHTML = '<i class="bi bi-x-circle"></i> Use Saved Address';
    } else {
      form.classList.add('d-none');
      if (radios.length > 0) radios[0].checked = true;
      if (toggleBtn) toggleBtn.innerHTML = '<i class="bi bi-plus-circle"></i> + Add New';
    }
  }
}

function onCheckoutAddressChange() {
  const form = document.getElementById('checkout-new-address-form');
  const toggleBtn = document.getElementById('btn-toggle-new-address');
  if (form) form.classList.add('d-none');
  if (toggleBtn) toggleBtn.innerHTML = '<i class="bi bi-plus-circle"></i> + Add New';
}

async function handlePlaceOrderSubmit(event) {
  event.preventDefault();
  const alertEl = document.getElementById('checkout-alert');
  const spinnerEl = document.getElementById('checkout-spinner');
  const submitBtn = document.getElementById('checkout-submit-btn');

  if (alertEl) {
    alertEl.classList.add('d-none');
    alertEl.innerText = '';
  }

  const selectedAddressRadio = document.querySelector('input[name="checkout_address_id"]:checked');
  const isUsingSavedAddress = selectedAddressRadio && selectedAddressRadio.value;

  const paymentRadio = document.querySelector('input[name="checkout_payment"]:checked');
  const paymentMethod = paymentRadio ? paymentRadio.value : 'Cash on Delivery';

  const payload = {
    payment_method: paymentMethod,
    cart_items: cart
  };

  if (isUsingSavedAddress) {
    payload.address_id = selectedAddressRadio.value;
  } else {
    const nameInp = document.getElementById('checkout-recipient-name');
    const phoneInp = document.getElementById('checkout-contact-no');
    const addr1Inp = document.getElementById('checkout-address-1');
    const addr2Inp = document.getElementById('checkout-address-2');
    const cityInp = document.getElementById('checkout-city');
    const stateInp = document.getElementById('checkout-state');
    const pincodeInp = document.getElementById('checkout-pincode');
    const saveCheckbox = document.getElementById('checkout-save-address');

    let hasError = false;
    const checkField = (inp, errId, msg) => {
      const errEl = document.getElementById(errId);
      if (!inp || !inp.value.trim()) {
        if (inp) inp.classList.add('is-invalid');
        if (errEl) { errEl.innerText = msg; errEl.classList.remove('d-none'); }
        hasError = true;
      } else {
        if (inp) inp.classList.remove('is-invalid');
        if (errEl) { errEl.innerText = ''; errEl.classList.add('d-none'); }
      }
    };

    checkField(nameInp, 'checkout-recipient-name-error', 'Please enter recipient name');
    checkField(phoneInp, 'checkout-contact-no-error', 'Please enter contact phone');
    checkField(addr1Inp, 'checkout-address-1-error', 'Please enter delivery address');
    checkField(cityInp, 'checkout-city-error', 'Please enter city');
    checkField(stateInp, 'checkout-state-error', 'Please enter state');
    checkField(pincodeInp, 'checkout-pincode-error', 'Please enter pincode');

    if (hasError) {
      if (alertEl) {
        alertEl.innerText = 'Please fill all required delivery address fields.';
        alertEl.classList.remove('d-none');
      }
      return;
    }

    payload.recipient_name = nameInp.value.trim();
    payload.contactNo = phoneInp.value.trim();
    payload.address_line_1 = addr1Inp.value.trim();
    payload.address_line_2 = addr2Inp ? addr2Inp.value.trim() : '';
    payload.city = cityInp.value.trim();
    payload.state = stateInp.value.trim();
    payload.pincode = pincodeInp.value.trim();
    payload.save_address = saveCheckbox ? saveCheckbox.checked : true;
  }

  if (spinnerEl) spinnerEl.classList.remove('d-none');
  if (submitBtn) submitBtn.disabled = true;

  try {
    const res = await fetch('/checkout/place-order', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken()
      },
      body: JSON.stringify(payload)
    });

    const data = await res.json();

    if (res.ok && data.success) {
      // Clear Cart
      cart = [];
      saveCart();
      updateCartCounters();
      renderCartDrawer();

      // Hide Modal
      const modalEl = document.getElementById('checkoutModal');
      if (modalEl) {
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
      }

      // If PhonePe redirect URL returned, redirect immediately to gateway
      if (data.redirect_url) {
        showToast(data.message || 'Redirecting to PhonePe...', 'info');
        setTimeout(() => {
          window.location.href = data.redirect_url;
        }, 400);
        return;
      }

      showToast(data.message || 'Order placed successfully!', 'success');

      if (window.location.pathname.includes('/account')) {
        setTimeout(() => {
          window.location.href = '/account?tab=orders';
        }, 1000);
      } else {
        setTimeout(() => {
          openOrdersModal();
        }, 800);
      }
    } else {
      const errMsg = (data.errors && Object.values(data.errors).flat()[0]) || data.message || 'Could not place order. Please try again.';
      if (alertEl) {
        alertEl.innerText = errMsg;
        alertEl.classList.remove('d-none');
      } else {
        showToast(errMsg, 'error');
      }
    }
  } catch (err) {
    if (alertEl) {
      alertEl.innerText = 'Unable to place order at this time. Please try again.';
      alertEl.classList.remove('d-none');
    }
  } finally {
    if (spinnerEl) spinnerEl.classList.add('d-none');
    if (submitBtn) submitBtn.disabled = false;
  }
}

async function openOrdersModal() {
  if (!currentUser) {
    showToast('Please log in to view your orders.', 'info');
    openAuthModal('login');
    return;
  }

  const modalEl = document.getElementById('myOrdersModal');
  const bodyEl = document.getElementById('orders-modal-body');
  if (!modalEl || !bodyEl) return;

  const modal = new bootstrap.Modal(modalEl);
  modal.show();

  bodyEl.innerHTML = `
    <div class="text-center py-5 text-muted">
      <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
      <p class="small mb-0">Loading your orders...</p>
    </div>
  `;

  try {
    const res = await fetch('/user/orders', {
      headers: { 'Accept': 'application/json' }
    });
    const data = await res.json();

    if (res.ok && data.success && data.orders && data.orders.length > 0) {
      bodyEl.innerHTML = data.orders.map(order => `
        <div class="order-card mb-3">
          <div class="order-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
              <span class="order-id-tag">#${order.order_number}</span>
              <span class="order-date-text ms-2">&bull; Placed on ${new Date(order.created_at).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' })}</span>
            </div>
            <span class="badge ${order.status_badge_class || 'badge-status-processing'} py-2 px-3">
              ${order.status}
            </span>
          </div>

          <div class="order-card-body p-3">
            ${(order.items || []).map(item => `
              <div class="order-product-row d-flex align-items-center gap-3 py-2 border-bottom">
                <img src="${item.photo_url || item.image || 'image/products/product-1.jpg'}" alt="${item.product_name}" class="order-thumb rounded border" style="width: 52px; height: 52px; object-fit: cover;">
                <div class="flex-grow-1">
                  <div class="order-product-name fw-semibold small">${item.product_name}</div>
                  <div class="order-product-meta text-muted small">Qty: ${item.qty} &bull; ₹${Number(item.price).toLocaleString('en-IN')}</div>
                </div>
                <div class="fw-bold" style="color: var(--heading-color);">₹${(Number(item.price) * item.qty).toLocaleString('en-IN')}</div>
              </div>
            `).join('')}
          </div>

          <div class="order-card-footer d-flex justify-content-between align-items-center flex-wrap gap-2 p-3 bg-light border-top">
            <div>
              <span class="text-muted small">Total Paid:</span>
              <span class="order-total-price ms-1 fw-bold fs-6">₹${Number(order.total_amount).toLocaleString('en-IN')}</span>
              <span class="badge bg-light text-dark border ms-2">${order.payment_method}</span>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-outline-secondary" onclick="showToast('Downloading Tax Invoice for #${order.order_number}...', 'info')">
                <i class="bi bi-file-earmark-arrow-down"></i> Invoice
              </button>
              <button class="btn btn-sm btn-primary" onclick="showToast('Order #${order.order_number} status is ${order.status}.', 'info')">
                <i class="bi bi-geo-alt-fill"></i> Track
              </button>
            </div>
          </div>
        </div>
      `).join('');
    } else {
      bodyEl.innerHTML = `
        <div class="text-center py-5 text-muted">
          <i class="bi bi-bag-x fs-1 text-muted d-block mb-3"></i>
          <h5 class="fw-bold text-dark mb-1">No Orders Found</h5>
          <p class="small text-muted mb-3">You have not placed any orders yet.</p>
          <a href="/#shop" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Start Shopping</a>
        </div>
      `;
    }
  } catch (err) {
    bodyEl.innerHTML = `
      <div class="text-center py-4 text-danger small">
        <i class="bi bi-exclamation-circle fs-3 d-block mb-2"></i>
        Failed to load orders. Please try again.
      </div>
    `;
  }
}

async function loadAccountOrders() {
  const container = document.getElementById('account-orders-container');
  const recentOrderContainer = document.getElementById('overview-recent-order-container');
  if (!container && !recentOrderContainer) return;

  try {
    const res = await fetch('/user/orders', {
      headers: { 'Accept': 'application/json' }
    });
    if (res.ok) {
      const data = await res.json();
      const orders = data.orders || [];

      if (recentOrderContainer && orders.length > 0) {
        const latest = orders[0];
        const firstItem = (latest.items && latest.items.length > 0) ? latest.items[0] : null;
        recentOrderContainer.innerHTML = `
          <div class="small text-muted mb-2">
            Order <strong class="text-dark">#${latest.order_number}</strong> &bull; Placed on ${new Date(latest.created_at).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' })}
          </div>
          <div class="small mb-3">
            Status: <span class="badge ${latest.status_badge_class || 'badge-status-processing'} py-1 px-2 fw-semibold">${latest.status}</span>
          </div>
          ${firstItem ? `
            <div class="d-flex align-items-center gap-3 p-2 rounded-2 bg-light border">
              <img src="${firstItem.photo_url || firstItem.image || 'image/products/product-1.jpg'}" alt="${firstItem.product_name}" class="rounded border" style="width: 64px; height: 64px; object-fit: cover;">
              <div class="flex-grow-1">
                <strong class="d-block text-dark small">${firstItem.product_name}</strong>
                <span class="text-muted small d-block">Qty: ${firstItem.qty} ${latest.items.length > 1 ? `&bull; +${latest.items.length - 1} more item(s)` : ''}</span>
                <span class="fw-bold text-dark small">₹${Number(latest.total_amount).toLocaleString('en-IN')}</span>
              </div>
            </div>
          ` : ''}
        `;
      }

      if (container) {
        if (orders.length > 0) {
          container.innerHTML = orders.map(order => `
            <div class="card border rounded-3 p-4 mb-4 shadow-sm">
              <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pb-3 border-bottom mb-3">
                <div>
                  <span class="badge bg-light text-dark border fs-6 me-2">#${order.order_number}</span>
                  <span class="text-muted small">&bull; Placed on ${new Date(order.created_at).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' })}</span>
                </div>
                <span class="badge ${order.status_badge_class || 'badge-status-processing'} py-2 px-3 fw-semibold">
                  ${order.status}
                </span>
              </div>

              ${(order.items || []).map(item => `
                <div class="d-flex align-items-center gap-3 p-2 rounded-2 bg-light border mb-2">
                  <img src="${item.photo_url || item.image || 'image/products/product-1.jpg'}" alt="${item.product_name}" class="rounded border" style="width: 58px; height: 58px; object-fit: cover;">
                  <div class="flex-grow-1">
                    <strong class="d-block text-dark small">${item.product_name}</strong>
                    <span class="text-muted small">Qty: ${item.qty} &bull; ₹${Number(item.price).toLocaleString('en-IN')} each</span>
                  </div>
                  <div class="fw-bold text-dark">₹${(Number(item.price) * item.qty).toLocaleString('en-IN')}</div>
                </div>
              `).join('')}

              <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pt-2 border-top mt-2">
                <div>
                  <span class="text-muted small">Delivery Address:</span>
                  <span class="small fw-medium text-dark ms-1">${order.formatted_address || (order.address_line_1 + ', ' + order.city)}</span>
                  <div class="mt-1">
                    <span class="text-muted small">Total Paid:</span>
                    <strong class="text-dark ms-1 fs-6">₹${Number(order.total_amount).toLocaleString('en-IN')}</strong>
                    <span class="badge bg-light text-dark border ms-2">${order.payment_method}</span>
                  </div>
                </div>
                <div class="d-flex gap-2">
                  <button class="btn btn-sm btn-outline-secondary" onclick="showToast('Downloading Tax Invoice for #${order.order_number}...', 'info')">
                    <i class="bi bi-file-earmark-arrow-down"></i> Invoice
                  </button>
                  <button class="btn btn-sm btn-primary" onclick="showToast('Order #${order.order_number} status is ${order.status}.', 'info')">
                    <i class="bi bi-geo-alt-fill"></i> Track
                  </button>
                </div>
              </div>
            </div>
          `).join('');
        }
      }
    }
  } catch (e) {
    console.warn('Could not load account orders dynamically', e);
  }
}

// --------------------------------------------------------------------------
// 17. Initialization
// --------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
  setupSearch();
  updateCartCounters();
  renderCartDrawer();
  renderCartPage();
  startCountdownTimer();
  setupNavigation();
  checkAuthStatus();
  setupTestimonialsSlider();
  setupContactValidation();
  loadAccountOrders();
});
