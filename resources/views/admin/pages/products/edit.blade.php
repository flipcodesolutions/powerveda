@extends('admin.layouts.app')

@section('page_title', 'Edit Product')

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
        <i class="bi bi-pencil-square me-2 text-primary"></i>Edit Product: {{ $product->name }}
      </h5>
      <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back to Products
      </a>
    </div>

    <div class="card-body p-4">
      <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" placeholder="e.g. Power Veda Ashwagandha Gold KSM-66" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Badge -->
          <div class="col-md-5">
            <label class="form-label fw-bold small" for="badge">Badge / Tagline</label>
            <input type="text" class="form-control @error('badge') is-invalid @enderror" id="badge" name="badge" value="{{ old('badge', $product->badge ?: 'NATURAL') }}" placeholder="e.g. NATURAL, 100% PURE, PREMIUM">
            @error('badge')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Price -->
          <div class="col-md-4">
            <label class="form-label fw-bold small" for="price">Discounted Selling Price (₹) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" placeholder="1499" required min="0">
            @error('price')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Original Price -->
          <div class="col-md-4">
            <label class="form-label fw-bold small" for="original_price">Original MRP Price (₹)</label>
            <input type="number" step="0.01" class="form-control @error('original_price') is-invalid @enderror" id="original_price" name="original_price" value="{{ old('original_price', $product->original_price) }}" placeholder="1999" min="0">
            @error('original_price')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Discount Label -->
          <div class="col-md-4">
            <label class="form-label fw-bold small" for="discount">Discount Tag</label>
            <input type="text" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" value="{{ old('discount', $product->discount) }}" placeholder="e.g. 25% OFF">
            @error('discount')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Stock -->
          <div class="col-md-4">
            <label class="form-label fw-bold small" for="stock">Inventory Stock Quantity <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" placeholder="50" required min="0">
            @error('stock')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Photo (File Upload) -->
          <div class="col-md-8">
            <label class="form-label fw-bold small" for="photo">Product Photo (Leave empty to keep current photo)</label>
            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
            <div class="form-text small">Upload JPG, PNG, or WEBP image (Max 2MB).</div>
            @error('photo')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if($product->photo)
              <div class="d-flex align-items-center gap-2 mt-2">
                <span class="small text-muted">Current Photo:</span>
                <img src="{{ $product->photo_url }}" alt="Current Photo" class="rounded border" style="width: 50px; height: 50px; object-fit: cover;">
              </div>
            @endif
          </div>

          <!-- Product Detail -->
          <div class="col-12">
            <label class="form-label fw-bold small" for="detail">Product Description / Highlights</label>
            <textarea class="form-control @error('detail') is-invalid @enderror" id="detail" name="detail" rows="3" placeholder="Enter key benefits, Ayurvedic botanical extraction, and formula overview...">{{ old('detail', $product->detail) }}</textarea>
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
                <p class="text-muted small mb-0">Provide general dosage instructions and configure the dynamic step cards displayed on the visitor storefront.</p>
              </div>
              <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-step">
                <i class="bi bi-plus-circle me-1"></i> Add Custom Step
              </button>
            </div>

            <!-- General Usage Text -->
            <div class="mb-3">
              <label class="form-label fw-bold small" for="how_to_use">General Usage &amp; Dosage Instructions</label>
              <textarea class="form-control @error('how_to_use') is-invalid @enderror" id="how_to_use" name="how_to_use" rows="2" placeholder="e.g. Take 1 to 2 capsules twice daily with warm milk or lukewarm water after meals.">{{ old('how_to_use', $product->how_to_use) }}</textarea>
              <div class="form-text small">Concise dosage summary for quick view and product summary strips.</div>
            </div>

            <!-- Dynamic Steps Container -->
            <div class="card bg-light border-0 p-3 rounded-3 mb-2">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold small text-uppercase" style="color: #061E43; letter-spacing: 0.5px;">
                  <i class="bi bi-list-ol me-1 text-warning"></i> Step-by-Step Ritual Cards
                </span>
                <span class="badge bg-secondary" id="step-count-badge">{{ count($product->how_to_use_steps_list) }} Steps</span>
              </div>

              <div id="steps-container" class="d-flex flex-column gap-3">
                @foreach($product->how_to_use_steps_list as $sIdx => $step)
                  <div class="step-card bg-white p-3 rounded border shadow-sm position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-warning text-dark fw-bold step-num-badge">Step {{ $step['step_number'] ?? str_pad($sIdx + 1, 2, '0', STR_PAD_LEFT) }}</span>
                      <button type="button" class="btn btn-sm text-danger p-0 btn-remove-step" title="Remove Step"><i class="bi bi-trash"></i></button>
                    </div>
                    <div class="row g-2">
                      <div class="col-md-5">
                        <label class="small fw-semibold">Step Title</label>
                        <input type="text" name="step_title[]" class="form-control form-control-sm" value="{{ $step['title'] ?? '' }}" placeholder="e.g. Dosage & Measure" required>
                      </div>
                      <div class="col-md-4">
                        <label class="small fw-semibold">Timing / Badge</label>
                        <input type="text" name="step_timing[]" class="form-control form-control-sm" value="{{ $step['timing'] ?? '' }}" placeholder="e.g. Twice Daily / Before Bed">
                      </div>
                      <div class="col-md-3">
                        <label class="small fw-semibold">Icon</label>
                        <select name="step_icon[]" class="form-select form-select-sm">
                          <option value="bi-capsule" {{ ($step['icon'] ?? '') === 'bi-capsule' ? 'selected' : '' }}>Capsule / Pill</option>
                          <option value="bi-cup-hot" {{ ($step['icon'] ?? '') === 'bi-cup-hot' ? 'selected' : '' }}>Warm Cup / Liquid</option>
                          <option value="bi-calendar-check" {{ ($step['icon'] ?? '') === 'bi-calendar-check' ? 'selected' : '' }}>Calendar / Routine</option>
                          <option value="bi-heart-pulse" {{ ($step['icon'] ?? '') === 'bi-heart-pulse' ? 'selected' : '' }}>Heart / Health</option>
                          <option value="bi-droplet" {{ ($step['icon'] ?? '') === 'bi-droplet' ? 'selected' : '' }}>Droplet / Oil</option>
                          <option value="bi-sun" {{ ($step['icon'] ?? '') === 'bi-sun' ? 'selected' : '' }}>Sun / Morning</option>
                          <option value="bi-moon-stars" {{ ($step['icon'] ?? '') === 'bi-moon-stars' ? 'selected' : '' }}>Moon / Night</option>
                          <option value="bi-fire" {{ ($step['icon'] ?? '') === 'bi-fire' ? 'selected' : '' }}>Warmth / Boil</option>
                          <option value="bi-eyedropper" {{ ($step['icon'] ?? '') === 'bi-eyedropper' ? 'selected' : '' }}>Dropper / Serum</option>
                          <option value="bi-stars" {{ ($step['icon'] ?? '') === 'bi-stars' ? 'selected' : '' }}>Radiance / Glow</option>
                        </select>
                      </div>
                      <div class="col-12">
                        <label class="small fw-semibold">Instruction Description</label>
                        <input type="text" name="step_desc[]" class="form-control form-control-sm" value="{{ $step['description'] ?? '' }}" placeholder="Describe what the user should do...">
                      </div>
                    </div>
                  </div>
                @endforeach
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
                <p class="text-muted small mb-0">Manage product-specific FAQs that dynamically show in visitor storefront accordion and quick-view modal.</p>
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
                <span class="badge bg-secondary" id="faq-count-badge">{{ $product->faqs->count() }} FAQs</span>
              </div>

              <div id="faqs-container" class="d-flex flex-column gap-3">
                @forelse($product->faqs as $fIdx => $faq)
                  <div class="faq-item-card bg-white p-3 rounded border shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-primary-subtle text-primary fw-bold faq-num-badge">FAQ #{{ $fIdx + 1 }}</span>
                      <button type="button" class="btn btn-sm text-danger p-0 btn-remove-faq" title="Remove FAQ"><i class="bi bi-trash"></i></button>
                    </div>
                    <div class="mb-2">
                      <label class="small fw-semibold">Question</label>
                      <input type="text" name="faq_question[]" class="form-control form-control-sm" value="{{ $faq->question }}" placeholder="Enter frequently asked question..." required>
                    </div>
                    <div>
                      <label class="small fw-semibold">Answer</label>
                      <textarea name="faq_answer[]" class="form-control form-control-sm" rows="2" placeholder="Write a clear, helpful answer for customers..." required>{{ $faq->answer }}</textarea>
                    </div>
                  </div>
                @empty
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
                @endforelse
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
            <label class="form-label fw-bold small" for="meta_title">Meta Title</label>
            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" placeholder="e.g. Buy Organic Ashwagandha Gold | Power Veda">
            @error('meta_title')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Meta Detail -->
          <div class="col-12">
            <label class="form-label fw-bold small" for="meta_detail">Meta Detail / Description</label>
            <textarea class="form-control @error('meta_detail') is-invalid @enderror" id="meta_detail" name="meta_detail" rows="2" placeholder="Brief SEO description snippet (recommended 150-160 characters)...">{{ old('meta_detail', $product->meta_detail) }}</textarea>
            @error('meta_detail')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- OG Image -->
          <div class="col-12">
            <label class="form-label fw-bold small" for="og_image">OG Image (Leave empty to keep current image)</label>
            <input type="file" class="form-control @error('og_image') is-invalid @enderror" id="og_image" name="og_image" accept="image/*">
            <div class="form-text small">Social sharing image upload for WhatsApp/Facebook preview.</div>
            @error('og_image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if($product->og_image)
              <div class="d-flex align-items-center gap-2 mt-2">
                <span class="small text-muted">Current OG Image:</span>
                <img src="{{ $product->og_image_url }}" alt="Current OG Image" class="rounded border" style="width: 60px; height: 35px; object-fit: cover;">
              </div>
            @endif
          </div>

          <!-- Submit Buttons -->
          <div class="col-12 pt-3">
            <hr>
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
              <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-circle me-1"></i> Update Product &amp; FAQs
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
    // 1. Dynamic Steps Builder
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
              <option value="bi-fire">Warmth / Boil</option>
              <option value="bi-eyedropper">Dropper / Serum</option>
              <option value="bi-stars">Radiance / Glow</option>
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

    // 2. Dynamic FAQs Builder
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
