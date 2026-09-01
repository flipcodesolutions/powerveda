@extends('admin.layouts.app')

@section('page_title', 'Edit Customer Review')

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
        <i class="bi bi-pencil-square me-2 text-primary"></i>Edit Review: {{ $review->author }}
      </h5>
      <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back to Reviews
      </a>
    </div>

    <div class="card-body p-4">
      <!-- Standard HTML Form -->
      <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">

          <!-- 1. Reviewer Name -->
          <div class="col-md-6">
            <label class="form-label fw-bold small" for="author">Reviewer / Customer Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('author', $review->author) }}" placeholder="e.g. Dr. Priya Nair" required>
            @error('author')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- 2. Location -->
          <div class="col-md-6">
            <label class="form-label fw-bold small" for="location">Location / City</label>
            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $review->location) }}" placeholder="e.g. Mumbai, Maharashtra">
            @error('location')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- 3. Formulation / Product Selection (Dynamic) -->
          <div class="col-12">
            <label class="form-label fw-bold small d-flex justify-content-between align-items-center" for="product_id">
              <span>Associated Product (Optional)</span>
              <span class="badge bg-light text-primary border small fw-normal">
                <i class="bi bi-lightning-charge-fill text-warning me-1"></i> Live Product Preview
              </span>
            </label>
            <select class="form-select @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
              <option value="" data-name="General Store Review" data-price="" data-photo="" data-detail="Review applies to overall brand, packaging, delivery or general wellness experience." data-badge="STOREWIDE">
                -- General Store Review (No Specific Product) --
              </option>
              @foreach($products as $product)
                <option value="{{ $product->id }}"
                  data-name="{{ $product->name }}"
                  data-price="₹{{ number_format($product->price, 0) }}"
                  data-photo="{{ $product->photo_url }}"
                  data-detail="{{ $product->detail }}"
                  data-badge="{{ $product->badge ?: 'NATURAL' }}"
                  data-stock="{{ $product->stock }}"
                  data-rating="{{ $product->rating }}"
                  {{ old('product_id', $review->product_id) == $product->id ? 'selected' : '' }}>
                  {{ $product->name }} (₹{{ number_format($product->price, 0) }})
                </option>
              @endforeach
            </select>
            @error('product_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <!-- Dynamic Live Product Card Preview -->
            <div id="product-preview-card" class="mt-3 p-3 rounded border bg-light d-flex align-items-center gap-3 transition-all" style="display: none;">
              <img id="preview-prod-img" src="{{ asset('image/products/product-1.jpg') }}" alt="Product" class="rounded border bg-white" style="width: 65px; height: 65px; object-fit: cover;">
              <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                  <strong id="preview-prod-name" class="text-dark">Product Name</strong>
                  <span id="preview-prod-badge" class="badge bg-primary-subtle text-primary border small">NATURAL</span>
                  <span id="preview-prod-price" class="fw-bold text-success small">₹0</span>
                </div>
                <p id="preview-prod-detail" class="text-muted small mb-0" style="max-height: 40px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                  Product description...
                </p>
              </div>
            </div>
          </div>

          <!-- 4. Star Rating -->
          <div class="col-md-6">
            <label class="form-label fw-bold small d-flex justify-content-between align-items-center" for="rating">
              <span>Star Rating <span class="text-danger">*</span></span>
              <span id="live-rating-stars" class="text-warning small">{{ str_repeat('⭐', old('rating', $review->rating)) }} {{ old('rating', $review->rating) }}.0</span>
            </label>
            <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating" required>
              <option value="5" {{ old('rating', $review->rating) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 Stars (Exceptional)</option>
              <option value="4" {{ old('rating', $review->rating) == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ 4 Stars (Very Good)</option>
              <option value="3" {{ old('rating', $review->rating) == 3 ? 'selected' : '' }}>⭐⭐⭐ 3 Stars (Average)</option>
              <option value="2" {{ old('rating', $review->rating) == 2 ? 'selected' : '' }}>⭐⭐ 2 Stars (Below Average)</option>
              <option value="1" {{ old('rating', $review->rating) == 1 ? 'selected' : '' }}>⭐ 1 Star (Poor)</option>
            </select>
            @error('rating')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- 5. Moderation Status -->
          <div class="col-md-6">
            <label class="form-label fw-bold small" for="status">Status <span class="text-danger">*</span></label>
            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
              <option value="Approved" {{ old('status', $review->status) === 'Approved' ? 'selected' : '' }}>Approved (Visible on Storefront)</option>
              <option value="Pending" {{ old('status', $review->status) === 'Pending' ? 'selected' : '' }}>Pending Moderation</option>
              <option value="Hidden" {{ old('status', $review->status) === 'Hidden' ? 'selected' : '' }}>Hidden</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- 6. Reviewer Photo (File Upload + Live Preview) -->
          <div class="col-12">
            <label class="form-label fw-bold small" for="photo">Reviewer Photo / Avatar (Leave empty to keep current photo)</label>
            <div class="d-flex align-items-center gap-3">
              <img id="avatar-preview-img" src="{{ $review->photo_url }}" alt="Avatar Preview" class="rounded-circle border" style="width: 50px; height: 50px; object-fit: cover;">
              <div class="flex-grow-1">
                <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                <div class="form-text small">Upload JPG, PNG, or WEBP image (Max 2MB) to change current photo.</div>
              </div>
            </div>
            @error('photo')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <!-- 7. Review / Feedback Comment -->
          <div class="col-12">
            <label class="form-label fw-bold small d-flex justify-content-between align-items-center" for="comment">
              <span>Review Feedback / Testimonial <span class="text-danger">*</span></span>
              <small id="comment-char-count" class="text-muted">{{ strlen($review->comment) }} characters</small>
            </label>
            <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="4" placeholder="Enter customer's review feedback and experience with the botanical formulation..." required>{{ old('comment', $review->comment) }}</textarea>
            @error('comment')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Submit Buttons -->
          <div class="col-12 pt-3">
            <hr>
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">Cancel</a>
              <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-circle me-1"></i> Update Review
              </button>
            </div>
          </div>

        </div>
      </form>
    </div>
  </div>

</div>

<!-- Dynamic UI JavaScript (Beginner Friendly, No AJAX) -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const previewCard = document.getElementById('product-preview-card');
    const previewImg = document.getElementById('preview-prod-img');
    const previewName = document.getElementById('preview-prod-name');
    const previewBadge = document.getElementById('preview-prod-badge');
    const previewPrice = document.getElementById('preview-prod-price');
    const previewDetail = document.getElementById('preview-prod-detail');

    const authorInput = document.getElementById('author');
    const avatarPreviewImg = document.getElementById('avatar-preview-img');
    const photoInput = document.getElementById('photo');

    const ratingSelect = document.getElementById('rating');
    const liveRatingStars = document.getElementById('live-rating-stars');

    const commentInput = document.getElementById('comment');
    const commentCharCount = document.getElementById('comment-char-count');

    const currentPhotoUrl = "{{ $review->photo_url }}";

    // 1. Dynamic Product Selection Card Updater
    function updateProductPreview() {
      const selectedOption = productSelect.options[productSelect.selectedIndex];
      if (!selectedOption) return;

      const name = selectedOption.getAttribute('data-name') || '';
      const price = selectedOption.getAttribute('data-price') || '';
      const photo = selectedOption.getAttribute('data-photo') || '';
      const detail = selectedOption.getAttribute('data-detail') || '';
      const badge = selectedOption.getAttribute('data-badge') || 'NATURAL';

      if (productSelect.value) {
        previewCard.style.display = 'flex';
        previewName.innerText = name;
        previewPrice.innerText = price;
        previewBadge.innerText = badge;
        previewDetail.innerText = detail || 'No botanical details provided.';
        if (photo) {
          previewImg.src = photo;
          previewImg.style.display = 'block';
        } else {
          previewImg.style.display = 'none';
        }
      } else {
        previewCard.style.display = 'flex';
        previewName.innerText = 'General Store Review';
        previewPrice.innerText = '';
        previewBadge.innerText = 'STOREWIDE';
        previewDetail.innerText = 'Review applies to overall brand, packaging, delivery, or general customer wellness journey.';
        previewImg.src = '/image/logo.png';
      }
    }

    productSelect.addEventListener('change', updateProductPreview);
    updateProductPreview(); // Initialize on page load

    // 2. Dynamic Avatar Preview from Author Name & File Upload
    function updateAvatarFromName() {
      if (!photoInput.files || photoInput.files.length === 0) {
        if (currentPhotoUrl && !currentPhotoUrl.includes('ui-avatars.com')) {
          avatarPreviewImg.src = currentPhotoUrl;
        } else {
          const name = authorInput.value.trim() || 'User';
          avatarPreviewImg.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=061E43&color=D8BC8D&size=100`;
        }
      }
    }

    authorInput.addEventListener('input', updateAvatarFromName);

    photoInput.addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(evt) {
          avatarPreviewImg.src = evt.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        updateAvatarFromName();
      }
    });

    // 3. Dynamic Rating Visualizer
    ratingSelect.addEventListener('change', function() {
      const starsCount = parseInt(ratingSelect.value, 10) || 5;
      liveRatingStars.innerText = '⭐'.repeat(starsCount) + ` ${starsCount}.0`;
    });

    // 4. Comment Character Counter
    commentInput.addEventListener('input', function() {
      const len = commentInput.value.length;
      commentCharCount.innerText = `${len} character${len === 1 ? '' : 's'}`;
    });
  });
</script>
@endsection
