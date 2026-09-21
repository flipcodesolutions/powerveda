@extends('admin.layouts.app')

@section('page_title', 'Policy CMS Management')

@push('styles')
<!-- Summernote Lite CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<style>
  .policy-tab-card {
    transition: all 0.2s ease;
    border-radius: 8px;
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    text-decoration: none;
    display: block;
    padding: 0.85rem 1rem;
    color: #333333;
    position: relative;
  }
  .policy-tab-card:hover {
    border-color: #061E43;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(6, 30, 67, 0.08);
    color: #061E43;
  }
  .policy-tab-card.active {
    border: 2px solid #061E43 !important;
    background-color: #ffffff;
    box-shadow: 0 4px 12px rgba(6, 30, 67, 0.12);
  }
  .policy-tab-card.active::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: #061E43;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
  }
  .note-editor.note-frame {
    border-radius: 8px;
    border: 1px solid #ced4da;
    overflow: hidden;
  }
  .note-editor.note-frame:focus-within {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
  }
  .note-toolbar {
    background-color: #f8fafc !important;
    border-bottom: 1px solid #e2e8f0 !important;
    padding: 8px 10px !important;
  }
  .note-editable {
    background-color: #ffffff !important;
    min-height: 400px;
    font-family: var(--font-family, 'Plus Jakarta Sans', sans-serif);
    font-size: 0.95rem;
    line-height: 1.6;
    color: #212529;
  }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

  <!-- Success Notification Message (Same as Product CRUD) -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
      <i class="bi bi-check-circle-fill fs-5"></i>
      <div><strong>Success!</strong> {{ session('success') }}</div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Validation Errors (Same as Product CRUD) -->
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

  <!-- Main CMS Management Card -->
  <div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2 border-bottom">
      <div>
        <h5 class="mb-0 fw-bold" style="color: #061E43;">
          <i class="bi bi-file-earmark-richtext me-2 text-primary"></i>Policy Pages Content Manager
        </h5>
        <small class="text-muted">Manage your store legal, refund, return, and shipping policy content</small>
      </div>

      <!-- Action Button -->
      <div class="d-flex align-items-center gap-2">
        @if($activePage->exists)
          <a href="{{ route('policies.show', $activePage->slug) }}" target="_blank" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2">
            <i class="bi bi-box-arrow-up-right text-primary"></i> View Live Storefront
          </a>
        @endif
      </div>
    </div>

    <div class="card-body p-4">
      <form action="{{ route('admin.cms.createOrUpdate') }}" method="POST" id="cms-policy-form">
        @csrf

        <div class="row g-4">

          <!-- 1. Select Policy Document Section -->
          <div class="col-12">
            <h6 class="fw-bold pb-2 border-bottom" style="color: #061E43;">
              <i class="bi bi-collection me-2 text-primary"></i>1. Select Policy Document
            </h6>
          </div>

          <div class="col-12">
            <div class="card bg-light border-0 p-3 rounded-3 mb-2">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fw-bold small text-uppercase" style="color: #061E43; letter-spacing: 0.5px;">
                  <i class="bi bi-list-ol me-1 text-warning"></i> Core Policy Documents
                </span>
                <span class="badge bg-secondary">5 Policies Available</span>
              </div>

              <div class="row g-3">
                @foreach ($predefinedPolicies as $slug => $title)
                  @php
                    $isConfigured = $existingPages->has($slug);
                    $isActive = ($selectedSlug === $slug);
                  @endphp
                  <div class="col-12 col-md-6 col-xl">
                    <a href="{{ route('admin.cms.index', ['slug' => $slug]) }}" class="policy-tab-card {{ $isActive ? 'active' : '' }}">
                      <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge {{ $isActive ? 'bg-warning text-dark fw-bold' : 'bg-light text-secondary border' }} small">
                          @if($isActive)
                            <i class="bi bi-pencil-fill me-1"></i> Editing
                          @else
                            {{ $slug === 'privacy-policy' ? 'Doc 01' : ($slug === 'refund-policy' ? 'Doc 02' : ($slug === 'return-policy' ? 'Doc 03' : ($slug === 'shipping-policy' ? 'Doc 04' : 'Doc 05'))) }}
                          @endif
                        </span>
                        @if($isConfigured)
                          <span class="badge bg-success" style="font-size: 0.7rem;">
                            <i class="bi bi-check2"></i> Published
                          </span>
                        @else
                          <span class="badge bg-secondary" style="font-size: 0.7rem;">Draft</span>
                        @endif
                      </div>

                      <div class="d-flex align-items-center gap-2 mb-1">
                        @if($slug === 'privacy-policy')
                          <i class="bi bi-shield-lock-fill text-primary fs-5"></i>
                        @elseif($slug === 'refund-policy')
                          <i class="bi bi-cash-stack text-success fs-5"></i>
                        @elseif($slug === 'return-policy')
                          <i class="bi bi-arrow-counterclockwise text-warning fs-5"></i>
                        @elseif($slug === 'shipping-policy')
                          <i class="bi bi-truck text-info fs-5"></i>
                        @elseif($slug === 'terms-and-conditions')
                          <i class="bi bi-file-earmark-text-fill text-secondary fs-5"></i>
                        @else
                          <i class="bi bi-file-text text-primary fs-5"></i>
                        @endif
                        <strong class="text-dark d-block text-truncate" style="font-size: 0.95rem;">{{ $title }}</strong>
                      </div>

                      <div class="small text-muted font-monospace" style="font-size: 0.75rem;">
                        /policies/{{ $slug }}
                      </div>
                    </a>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

          <!-- 2. Basic Policy Information & Content Section -->
          <div class="col-12 pt-2">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-1">
              <h6 class="fw-bold mb-0" style="color: #061E43;">
                <i class="bi bi-pencil-square me-2 text-primary"></i>2. Policy Information &amp; Content
              </h6>
              <div class="small text-muted">
                @if($activePage->exists && $activePage->updated_at)
                  <i class="bi bi-clock-history me-1 text-primary"></i> Last updated: {{ $activePage->updated_at->format('d M Y, h:i A') }}
                @else
                  <span class="badge bg-warning text-dark">Unsaved Draft</span>
                @endif
              </div>
            </div>
          </div>

          <!-- Policy Title -->
          <div class="col-md-6">
            <label class="form-label fw-bold small" for="title">Policy Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
              value="{{ old('title', $activePage->title) }}" placeholder="e.g. Privacy Policy" required>
            @error('title')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text small">Main H1 headline displayed on the storefront hero section.</div>
          </div>

          <!-- Policy Slug -->
          <div class="col-md-6">
            <label class="form-label fw-bold small" for="slug">Policy URL Slug <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror font-monospace" id="slug" name="slug"
              value="{{ old('slug', $activePage->slug) }}" placeholder="e.g. privacy-policy" required>
            @error('slug')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text small">Unique slug used for routing and updateOrCreate logic.</div>
          </div>

          <!-- Policy Detail (Summernote Editor) -->
          <div class="col-12">
            <label class="form-label fw-bold small d-flex justify-content-between align-items-center" for="detail">
              <span>Policy Document Content &amp; HTML <span class="text-danger">*</span></span>
              <small class="text-muted fw-normal"><i class="bi bi-code-slash me-1"></i>Rich-Text &amp; HTML Markup Supported</small>
            </label>
            <textarea class="form-control @error('detail') is-invalid @enderror" id="detail" name="detail" rows="18" required>{{ old('detail', $activePage->detail) }}</textarea>
            @error('detail')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text small mt-2">
              Supports headings (H2-H5), bulleted lists, highlight callouts (<code>.policy-highlight-box</code>), tables, and links.
            </div>
          </div>

          <!-- Submit Buttons (Identical to Product CRUD) -->
          <div class="col-12 pt-3">
            <hr>
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
              <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-circle me-1"></i> Save &amp; Publish Policy
              </button>
            </div>
          </div>

        </div>
      </form>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<!-- jQuery (Required for Summernote Lite) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Summernote Lite JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script>
  $(document).ready(function() {
    $('#detail').summernote({
      placeholder: 'Write the complete policy details here...',
      tabsize: 2,
      height: 420,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
        ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'hr']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ],
      styleTags: [
        'p',
        { title: 'Heading 2 (Section Title)', tag: 'h2', className: 'policy-section-title', value: 'h2' },
        { title: 'Heading 3', tag: 'h3', className: 'fw-bold', value: 'h3' },
        { title: 'Heading 4', tag: 'h4', className: 'fw-bold', value: 'h4' },
        { title: 'Blockquote / Highlight', tag: 'blockquote', className: 'policy-highlight-box', value: 'blockquote' }
      ]
    });
  });
</script>
@endpush
