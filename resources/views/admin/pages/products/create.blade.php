@extends('admin.layouts.app')

@section('page_title', 'Add New Product')

@section('content')
<div class="container-fluid px-0">

  <!-- Validation Errors -->
  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
      <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Please fix the following errors:</h6>
      <ul class="mb-0 ps-3">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
      <h5 class="mb-0 fw-bold" style="color: #061E43;">
        <i class="bi bi-plus-circle me-2 text-primary"></i>Create New Product
      </h5>
      <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back to Products
      </a>
    </div>

    <div class="card-body p-4">
      <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

          <!-- 1. Basic Product Details -->
          <div class="col-12">
            <h6 class="fw-bold pb-2 border-bottom" style="color: #061E43;">
              <i class="bi bi-box-seam me-2 text-primary"></i>1. Basic Information &amp; Pricing
            </h6>
          </div>

          <!-- Product Name -->
          <div class="col-md-7">
            <label class="form-label fw-bold small" for="name">Product Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Yuvar Dhan Ashwagandha Gold KSM-66" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Badge -->
          <div class="col-md-5">
            <label class="form-label fw-bold small" for="badge">Badge / Tagline</label>
            <input type="text" class="form-control @error('badge') is-invalid @enderror" id="badge" name="badge" value="{{ old('badge', 'NATURAL') }}" placeholder="e.g. NATURAL, 100% PURE, PREMIUM">
            @error('badge')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Price -->
          <div class="col-md-4">
            <label class="form-label fw-bold small" for="price">Discounted Selling Price (₹) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="1499" required min="0">
            @error('price')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Original Price -->
          <div class="col-md-4">
            <label class="form-label fw-bold small" for="original_price">Original MRP Price (₹)</label>
            <input type="number" step="0.01" class="form-control @error('original_price') is-invalid @enderror" id="original_price" name="original_price" value="{{ old('original_price') }}" placeholder="1999" min="0">
            @error('original_price')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Discount Label -->
          <div class="col-md-4">
            <label class="form-label fw-bold small" for="discount">Discount Tag</label>
            <input type="text" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" value="{{ old('discount', '25% OFF') }}" placeholder="e.g. 25% OFF">
            @error('discount')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Stock -->
          <div class="col-md-4">
            <label class="form-label fw-bold small" for="stock">Inventory Stock Quantity <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', 50) }}" placeholder="50" required min="0">
            @error('stock')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Photo (File Upload) -->
          <div class="col-md-8">
            <label class="form-label fw-bold small" for="photo">Product Photo (File Upload)</label>
            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
            <div class="form-text small">Upload JPG, PNG, or WEBP image (Max 2MB).</div>
            @error('photo')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Product Detail -->
          <div class="col-12">
            <label class="form-label fw-bold small" for="detail">Product Description / Highlights</label>
            <textarea class="form-control @error('detail') is-invalid @enderror" id="detail" name="detail" rows="3" placeholder="Enter key benefits, Ayurvedic botanical extraction, and formula overview...">{{ old('detail') }}</textarea>
            @error('detail')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- 2. Dynamic 'How to Use' Section -->
          <div class="col-12 pt-2">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
              <div>
                <h6 class="fw-bold mb-1" style="color: #061E43;">
                  <i class="bi bi-clock-history me-2 text-primary"></i>2. How to Use Product (Dosage &amp; Ritual Steps)
                </h6>
                <p class="text-muted small mb-0">Provide general dosage instructions and build dynamic step-by-step ritual cards displayed to visitors.</p>
              </div>
              <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-step">
                <i class="bi bi-plus-circle me-1"></i> Add Custom Step
              </button>
            </div>

            <!-- General Usage Text -->
            <div class="mb-3">
              <label class="form-label fw-bold small" for="how_to_use">General Usage &amp; Dosage Instructions</label>
              <textarea class="form-control @error('how_to_use') is-invalid @enderror" id="how_to_use" name="how_to_use" rows="2" placeholder="e.g. Take 1 to 2 capsules twice daily with warm milk or lukewarm water after meals.">{{ old('how_to_use') }}</textarea>
              <div class="form-text small">Concise dosage summary for quick view and product summary strips.</div>
            </div>

            <!-- Dynamic Steps Container -->
            <div class="card bg-light border-0 p-3 rounded-3 mb-2">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold small text-uppercase" style="color: #061E43; letter-spacing: 0.5px;">
                  <i class="bi bi-list-ol me-1 text-warning"></i> Step-by-Step Ritual Cards
                </span>
                <span class="badge bg-secondary" id="step-count-badge">4 Steps</span>
              </div>

              <div id="steps-container" class="d-flex flex-column gap-3">
                <!-- Step 1 -->
                <div class="step-card bg-white p-3 rounded border shadow-sm position-relative">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-warning text-dark fw-bold step-num-badge">Step 01</span>
                    <button type="button" class="btn btn-sm text-danger p-0 btn-remove-step" title="Remove Step"><i class="bi bi-trash"></i></button>
                  </div>
                  <div class="row g-2">
                    <div class="col-md-5">
                      <label class="small fw-semibold">Step Title</label>
                      <input type="text" name="step_title[]" class="form-control form-control-sm" value="Dosage & Measure" placeholder="e.g. Dosage & Measure" required>
                    </div>
                    <div class="col-md-4">
                      <label class="small fw-semibold">Timing / Badge</label>
                      <input type="text" name="step_timing[]" class="form-control form-control-sm" value="Twice Daily" placeholder="e.g. Twice Daily / Before Bed">
                    </div>
                    <div class="col-md-3">
                      <label class="small fw-semibold">Icon</label>
                      <select name="step_icon[]" class="form-select form-select-sm">
                        <option value="bi-capsule" selected>Capsule / Pill</option>
                        <option value="bi-cup-hot">Warm Cup / Liquid</option>
                        <option value="bi-calendar-check">Calendar / Routine</option>
                        <option value="bi-heart-pulse">Heart / Health</option>
                        <option value="bi-droplet">Droplet / Oil</option>
                        <option value="bi-sun">Sun / Morning</option>
                        <option value="bi-moon-stars">Moon / Night</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <label class="small fw-semibold">Instruction Description</label>
                      <input type="text" name="step_desc[]" class="form-control form-control-sm" value="Take 1 to 2 vegetarian capsules daily based on your wellness routine." placeholder="Describe what the user should do...">
                    </div>
                  </div>
                </div>

                <!-- Step 2 -->
                <div class="step-card bg-white p-3 rounded border shadow-sm position-relative">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-warning text-dark fw-bold step-num-badge">Step 02</span>
                    <button type="button" class="btn btn-sm text-danger p-0 btn-remove-step" title="Remove Step"><i class="bi bi-trash"></i></button>
                  </div>
                  <div class="row g-2">
                    <div class="col-md-5">
                      <label class="small fw-semibold">Step Title</label>
                      <input type="text" name="step_title[]" class="form-control form-control-sm" value="Optimal Vehicle (Anupana)" placeholder="e.g. Optimal Vehicle" required>
                    </div>
                    <div class="col-md-4">
                      <label class="small fw-semibold">Timing / Badge</label>
                      <input type="text" name="step_timing[]" class="form-control form-control-sm" value="30 Mins After Meals" placeholder="e.g. 30 Mins After Meals">
                    </div>
                    <div class="col-md-3">
                      <label class="small fw-semibold">Icon</label>
                      <select name="step_icon[]" class="form-select form-select-sm">
                        <option value="bi-capsule">Capsule / Pill</option>
                        <option value="bi-cup-hot" selected>Warm Cup / Liquid</option>
                        <option value="bi-calendar-check">Calendar / Routine</option>
                        <option value="bi-heart-pulse">Heart / Health</option>
                        <option value="bi-droplet">Droplet / Oil</option>
                        <option value="bi-sun">Sun / Morning</option>
                        <option value="bi-moon-stars">Moon / Night</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <label class="small fw-semibold">Instruction Description</label>
                      <input type="text" name="step_desc[]" class="form-control form-control-sm" value="Consume with warm organic milk, almond milk, or lukewarm water for optimum adaptogenic uptake." placeholder="Describe what the user should do...">
                    </div>
                  </div>
                </div>

                <!-- Step 3 -->
                <div class="step-card bg-white p-3 rounded border shadow-sm position-relative">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-warning text-dark fw-bold step-num-badge">Step 03</span>
                    <button type="button" class="btn btn-sm text-danger p-0 btn-remove-step" title="Remove Step"><i class="bi bi-trash"></i></button>
                  </div>
                  <div class="row g-2">
                    <div class="col-md-5">
                      <label class="small fw-semibold">Step Title</label>
                      <input type="text" name="step_title[]" class="form-control form-control-sm" value="Ritual Consistency" placeholder="e.g. Ritual Consistency" required>
                    </div>
                    <div class="col-md-4">
                      <label class="small fw-semibold">Timing / Badge</label>
                      <input type="text" name="step_timing[]" class="form-control form-control-sm" value="60-90 Days" placeholder="e.g. 60-90 Days">
                    </div>
                    <div class="col-md-3">
                      <label class="small fw-semibold">Icon</label>
                      <select name="step_icon[]" class="form-select form-select-sm">
                        <option value="bi-capsule">Capsule / Pill</option>
                        <option value="bi-cup-hot">Warm Cup / Liquid</option>
                        <option value="bi-calendar-check" selected>Calendar / Routine</option>
                        <option value="bi-heart-pulse">Heart / Health</option>
                        <option value="bi-droplet">Droplet / Oil</option>
                        <option value="bi-sun">Sun / Morning</option>
                        <option value="bi-moon-stars">Moon / Night</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <label class="small fw-semibold">Instruction Description</label>
                      <input type="text" name="step_desc[]" class="form-control form-control-sm" value="Incorporate consistently for 60 to 90 consecutive days to nourish deep bodily tissues." placeholder="Describe what the user should do...">
                    </div>
                  </div>
                </div>

                <!-- Step 4 -->
                <div class="step-card bg-white p-3 rounded border shadow-sm position-relative">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-warning text-dark fw-bold step-num-badge">Step 04</span>
                    <button type="button" class="btn btn-sm text-danger p-0 btn-remove-step" title="Remove Step"><i class="bi bi-trash"></i></button>
                  </div>
                  <div class="row g-2">
                    <div class="col-md-5">
                      <label class="small fw-semibold">Step Title</label>
                      <input type="text" name="step_title[]" class="form-control form-control-sm" value="Holistic Synergy" placeholder="e.g. Holistic Synergy" required>
                    </div>
                    <div class="col-md-4">
                      <label class="small fw-semibold">Timing / Badge</label>
                      <input type="text" name="step_timing[]" class="form-control form-control-sm" value="Daily Wellness" placeholder="e.g. Daily Wellness">
                    </div>
                    <div class="col-md-3">
                      <label class="small fw-semibold">Icon</label>
                      <select name="step_icon[]" class="form-select form-select-sm">
                        <option value="bi-capsule">Capsule / Pill</option>
                        <option value="bi-cup-hot">Warm Cup / Liquid</option>
                        <option value="bi-calendar-check">Calendar / Routine</option>
                        <option value="bi-heart-pulse" selected>Heart / Health</option>
                        <option value="bi-droplet">Droplet / Oil</option>
                        <option value="bi-sun">Sun / Morning</option>
                        <option value="bi-moon-stars">Moon / Night</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <label class="small fw-semibold">Instruction Description</label>
                      <input type="text" name="step_desc[]" class="form-control form-control-sm" value="Pair with balanced hydration, mindful breathing (Pranayama), and restful sleep." placeholder="Describe what the user should do...">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 3. Dynamic Product FAQs Section -->
          <div class="col-12 pt-2">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
              <div>
                <h6 class="fw-bold mb-1" style="color: #061E43;">
                  <i class="bi bi-question-circle me-2 text-primary"></i>3. Product FAQs (Dynamic Questions &amp; Answers)
                </h6>
                <p class="text-muted small mb-0">Add product-specific FAQs that will dynamically appear on the visitor storefront accordion and quick-view modal.</p>
              </div>
              <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-faq">
                <i class="bi bi-plus-circle me-1"></i> Add FAQ Item
              </button>
            </div>

            <!-- FAQs Container -->
            <div class="card bg-light border-0 p-3 rounded-3 mb-2">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold small text-uppercase" style="color: #061E43; letter-spacing: 0.5px;">
                  <i class="bi bi-chat-left-quote me-1 text-warning"></i> Frequently Asked Questions
                </span>
                <span class="badge bg-secondary" id="faq-count-badge">2 FAQs</span>
              </div>

              <div id="faqs-container" class="d-flex flex-column gap-3">
                <!-- FAQ 1 -->
                <div class="faq-item-card bg-white p-3 rounded border shadow-sm">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-primary-subtle text-primary fw-bold faq-num-badge">FAQ #1</span>
                    <button type="button" class="btn btn-sm text-danger p-0 btn-remove-faq" title="Remove FAQ"><i class="bi bi-trash"></i></button>
                  </div>
                  <div class="mb-2">
                    <label class="small fw-semibold">Question</label>
                    <input type="text" name="faq_question[]" class="form-control form-control-sm" value="How soon can I expect noticeable results?" placeholder="e.g. How soon can I expect noticeable results?" required>
                  </div>
                  <div>
                    <label class="small fw-semibold">Answer</label>
                    <textarea name="faq_answer[]" class="form-control form-control-sm" rows="2" placeholder="Write a clear, reassuring answer for customers..." required>Most individuals experience initial calmness and energy balance within 1-2 weeks, with peak benefits achieved over 60-90 days of daily use.</textarea>
                  </div>
                </div>

                <!-- FAQ 2 -->
                <div class="faq-item-card bg-white p-3 rounded border shadow-sm">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-primary-subtle text-primary fw-bold faq-num-badge">FAQ #2</span>
                    <button type="button" class="btn btn-sm text-danger p-0 btn-remove-faq" title="Remove FAQ"><i class="bi bi-trash"></i></button>
                  </div>
                  <div class="mb-2">
                    <label class="small fw-semibold">Question</label>
                    <input type="text" name="faq_question[]" class="form-control form-control-sm" value="Is this formulation 100% natural and vegetarian?" placeholder="e.g. Is this formulation 100% natural?" required>
                  </div>
                  <div>
                    <label class="small fw-semibold">Answer</label>
                    <textarea name="faq_answer[]" class="form-control form-control-sm" rows="2" placeholder="Write a clear, reassuring answer for customers..." required>Yes, our formulation is 100% vegetarian, free from synthetic preservatives, artificial colors, and independently lab-tested for purity.</textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 4. SEO Section Divider -->
          <div class="col-12 pt-2">
            <h6 class="fw-bold border-bottom pb-2" style="color: #061E43;">
              <i class="bi bi-search me-2 text-primary"></i>4. SEO &amp; Social Share Metadata
            </h6>
          </div>

          <!-- Meta Title -->
          <div class="col-12">
            <label class="form-label fw-bold small d-flex justify-content-between align-items-center" for="meta_title">
              <span>Meta Title</span>
              <small class="text-muted fw-normal">Auto-filled from Product Name (editable)</small>
            </label>
            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" placeholder="Auto-filled from Product Name...">
            @error('meta_title')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Meta Detail -->
          <div class="col-12">
            <label class="form-label fw-bold small d-flex justify-content-between align-items-center" for="meta_detail">
              <span>Meta Detail / Description</span>
              <small class="text-muted fw-normal">Auto-filled from Product Detail (editable)</small>
            </label>
            <textarea class="form-control @error('meta_detail') is-invalid @enderror" id="meta_detail" name="meta_detail" rows="2" placeholder="Auto-filled from Product Detail...">{{ old('meta_detail') }}</textarea>
            @error('meta_detail')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- OG Image -->
          <div class="col-12">
            <label class="form-label fw-bold small d-flex justify-content-between align-items-center" for="og_image">
              <span>OG Image (Social Share Image)</span>
              <small class="text-muted fw-normal">Defaults to product photo if left empty</small>
            </label>
            <input type="file" class="form-control @error('og_image') is-invalid @enderror" id="og_image" name="og_image" accept="image/*">
            @error('og_image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Submit Buttons -->
          <div class="col-12 pt-3">
            <hr>
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
              <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-circle me-1"></i> Save Product with Usage &amp; FAQs
              </button>
            </div>
          </div>

        </div>
      </form>
    </div>
  </div>

</div>

<!-- JavaScript for Dynamic Steps & FAQs -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // 1. Auto-sync SEO
    const nameInput = document.getElementById('name');
    const metaTitleInput = document.getElementById('meta_title');
    const detailInput = document.getElementById('detail');
    const metaDetailInput = document.getElementById('meta_detail');

    let metaTitleManuallyChanged = metaTitleInput.value.trim().length > 0;
    let metaDetailManuallyChanged = metaDetailInput.value.trim().length > 0;

    metaTitleInput.addEventListener('input', () => { metaTitleManuallyChanged = true; });
    metaDetailInput.addEventListener('input', () => { metaDetailManuallyChanged = true; });

    nameInput.addEventListener('input', () => {
      if (!metaTitleManuallyChanged) metaTitleInput.value = nameInput.value;
    });
    detailInput.addEventListener('input', () => {
      if (!metaDetailManuallyChanged) metaDetailInput.value = detailInput.value;
    });

    // 2. Dynamic Steps Builder
    const stepsContainer = document.getElementById('steps-container');
    const btnAddStep = document.getElementById('btn-add-step');
    const stepCountBadge = document.getElementById('step-count-badge');

    function updateStepNumbers() {
      const cards = stepsContainer.querySelectorAll('.step-card');
      cards.forEach((card, index) => {
        const num = String(index + 1).padStart(2, '0');
        const badge = card.querySelector('.step-num-badge');
        if (badge) badge.innerText = `Step ${num}`;
      });
      stepCountBadge.innerText = `${cards.length} Step${cards.length === 1 ? '' : 's'}`;
    }

    btnAddStep.addEventListener('click', function() {
      const stepIndex = stepsContainer.querySelectorAll('.step-card').length + 1;
      const num = String(stepIndex).padStart(2, '0');
      const stepHtml = document.createElement('div');
      stepHtml.className = 'step-card bg-white p-3 rounded border shadow-sm position-relative';
      stepHtml.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="badge bg-warning text-dark fw-bold step-num-badge">Step ${num}</span>
          <button type="button" class="btn btn-sm text-danger p-0 btn-remove-step" title="Remove Step"><i class="bi bi-trash"></i></button>
        </div>
        <div class="row g-2">
          <div class="col-md-5">
            <label class="small fw-semibold">Step Title</label>
            <input type="text" name="step_title[]" class="form-control form-control-sm" placeholder="e.g. Daily Ritual Step" required>
          </div>
          <div class="col-md-4">
            <label class="small fw-semibold">Timing / Badge</label>
            <input type="text" name="step_timing[]" class="form-control form-control-sm" placeholder="e.g. Morning / Night">
          </div>
          <div class="col-md-3">
            <label class="small fw-semibold">Icon</label>
            <select name="step_icon[]" class="form-select form-select-sm">
              <option value="bi-capsule">Capsule / Pill</option>
              <option value="bi-cup-hot">Warm Cup / Liquid</option>
              <option value="bi-calendar-check">Calendar / Routine</option>
              <option value="bi-heart-pulse">Heart / Health</option>
              <option value="bi-droplet">Droplet / Oil</option>
              <option value="bi-sun">Sun / Morning</option>
              <option value="bi-moon-stars">Moon / Night</option>
            </select>
          </div>
          <div class="col-12">
            <label class="small fw-semibold">Instruction Description</label>
            <input type="text" name="step_desc[]" class="form-control form-control-sm" placeholder="Describe instructions for this step...">
          </div>
        </div>
      `;
      stepsContainer.appendChild(stepHtml);
      updateStepNumbers();
    });

    stepsContainer.addEventListener('click', function(e) {
      if (e.target.closest('.btn-remove-step')) {
        const card = e.target.closest('.step-card');
        if (stepsContainer.querySelectorAll('.step-card').length > 1) {
          card.remove();
          updateStepNumbers();
        } else {
          alert('You must have at least one step in the usage protocol.');
        }
      }
    });

    // 3. Dynamic FAQs Builder
    const faqsContainer = document.getElementById('faqs-container');
    const btnAddFaq = document.getElementById('btn-add-faq');
    const faqCountBadge = document.getElementById('faq-count-badge');

    function updateFaqNumbers() {
      const items = faqsContainer.querySelectorAll('.faq-item-card');
      items.forEach((item, index) => {
        const badge = item.querySelector('.faq-num-badge');
        if (badge) badge.innerText = `FAQ #${index + 1}`;
      });
      faqCountBadge.innerText = `${items.length} FAQ${items.length === 1 ? '' : 's'}`;
    }

    btnAddFaq.addEventListener('click', function() {
      const faqIndex = faqsContainer.querySelectorAll('.faq-item-card').length + 1;
      const faqHtml = document.createElement('div');
      faqHtml.className = 'faq-item-card bg-white p-3 rounded border shadow-sm';
      faqHtml.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="badge bg-primary-subtle text-primary fw-bold faq-num-badge">FAQ #${faqIndex}</span>
          <button type="button" class="btn btn-sm text-danger p-0 btn-remove-faq" title="Remove FAQ"><i class="bi bi-trash"></i></button>
        </div>
        <div class="mb-2">
          <label class="small fw-semibold">Question</label>
          <input type="text" name="faq_question[]" class="form-control form-control-sm" placeholder="Enter frequently asked question..." required>
        </div>
        <div>
          <label class="small fw-semibold">Answer</label>
          <textarea name="faq_answer[]" class="form-control form-control-sm" rows="2" placeholder="Write a clear, helpful answer for customers..." required></textarea>
        </div>
      `;
      faqsContainer.appendChild(faqHtml);
      updateFaqNumbers();
    });

    faqsContainer.addEventListener('click', function(e) {
      if (e.target.closest('.btn-remove-faq')) {
        const item = e.target.closest('.faq-item-card');
        item.remove();
        updateFaqNumbers();
      }
    });

    updateStepNumbers();
    updateFaqNumbers();
  });
</script>
@endsection
