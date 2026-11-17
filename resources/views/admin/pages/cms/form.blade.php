@extends('admin.layouts.app')

@section('page_title', ($page->exists ? 'Edit CMS Page' : 'Create New CMS Page'))

@push('styles')
<!-- Summernote Lite CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<style>
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
    min-height: 420px;
    font-family: var(--font-family, 'Plus Jakarta Sans', sans-serif);
    font-size: 0.95rem;
    line-height: 1.65;
    color: #212529;
  }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

  <!-- Success Notification -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
      <i class="bi bi-check-circle-fill fs-5"></i>
      <div><strong>Success!</strong> {{ session('success') }}</div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Error Notification -->
  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
      <i class="bi bi-exclamation-triangle-fill fs-5"></i>
      <div><strong>Error!</strong> {{ session('error') }}</div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Validation Errors -->
  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
      <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Please resolve the following issues:</h6>
      <ul class="mb-0 ps-3">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- CMS Page Form Card -->
  <div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2 border-bottom">
      <div>
        <h5 class="mb-0 fw-bold" style="color: #061E43;">
          <i class="bi bi-pencil-square me-2 text-primary"></i>
          {{ $page->exists ? 'Edit CMS Page: ' . $page->title : 'Create New CMS Page' }}
        </h5>
        <small class="text-muted">Enter page title, custom URL slug, and format rich content</small>
      </div>

      <div class="d-flex align-items-center gap-2">
        @if($page->exists && $page->status)
          <a href="{{ url($page->slug) }}" target="_blank" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
            <i class="bi bi-box-arrow-up-right"></i> View Storefront
          </a>
        @endif
        <a href="{{ route('admin.cms.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
          <i class="bi bi-arrow-left"></i> Back to Listing
        </a>
      </div>
    </div>

    <div class="card-body p-4">
      <form action="{{ route('admin.cms.createOrUpdate') }}" method="POST" id="cms-page-form">
        @csrf

        @if($page->exists)
          <input type="hidden" name="id" value="{{ $page->id }}">
        @endif

        <div class="row g-4">

          <!-- 1. Page Title -->
          <div class="col-12 col-md-7">
            <label for="cms-title" class="form-label fw-bold text-dark">
              Page Title <span class="text-danger">*</span>
            </label>
            <input type="text"
                   name="title"
                   id="cms-title"
                   class="form-control form-control-lg @error('title') is-invalid @enderror"
                   placeholder="e.g. Terms & Conditions, Privacy Policy"
                   value="{{ old('title', $page->title ?? '') }}"
                   required>
            @error('title')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">The primary title displayed at the top of the policy page and in SEO meta tags.</small>
          </div>

          <!-- 2. Status -->
          <div class="col-12 col-md-5">
            <label for="cms-status" class="form-label fw-bold text-dark">
              Status <span class="text-danger">*</span>
            </label>
            <select name="status" id="cms-status" class="form-select form-select-lg @error('status') is-invalid @enderror" required>
              <option value="1" {{ old('status', (string)($page->status ?? 1)) === '1' || old('status', $page->status ?? true) == 1 ? 'selected' : '' }}>
                Active (Published &amp; Publicly Accessible)
              </option>
              <option value="0" {{ old('status', (string)($page->status ?? 1)) === '0' || (isset($page->status) && $page->status === false) ? 'selected' : '' }}>
                Inactive (Hidden / 404 on Storefront)
              </option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">When inactive, visitor requests will return a 404 page.</small>
          </div>

          <!-- 3. Slug Input & Live Preview -->
          <div class="col-12">
            <label for="cms-slug" class="form-label fw-bold text-dark">
              URL Slug <span class="text-muted fw-normal">(Unique URL identifier)</span>
            </label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted">{{ url('/') }}/</span>
              <input type="text"
                     name="slug"
                     id="cms-slug"
                     class="form-control @error('slug') is-invalid @enderror"
                     placeholder="e.g. privacy-policy"
                     value="{{ old('slug', $page->slug ?? '') }}">
              @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="d-flex align-items-center justify-content-between mt-1">
              <small class="text-muted">
                Live URL Preview: <code class="text-primary fw-semibold">{{ url('/') }}/<span id="slug-preview-text">{{ old('slug', $page->slug ?? 'page-slug') }}</span></code>
              </small>
              <button type="button" class="btn btn-link btn-sm text-decoration-none p-0" id="btn-sync-slug" style="font-size: 0.8rem;">
                <i class="bi bi-arrow-repeat me-1"></i> Regenerate from Title
              </button>
            </div>
          </div>

          <!-- 4. Content (Summernote Rich Text Editor) -->
          <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <label for="cms-content" class="form-label fw-bold text-dark mb-0">
                Page Content <span class="text-danger">*</span>
              </label>
              <small class="text-muted">Supports rich formatting, headings, links, bullet lists, and tables</small>
            </div>
            <textarea name="content"
                      id="cms-content"
                      class="form-control @error('content') is-invalid @enderror"
                      rows="12"
                      required>{{ old('content', $page->content ?: ($page->detail ?? '')) }}</textarea>
            @error('content')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Action Buttons: Save & Cancel -->
          <div class="col-12 pt-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
            <a href="{{ route('admin.cms.index') }}" class="btn btn-outline-secondary px-4">
              <i class="bi bi-x-circle me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
              <i class="bi bi-check-circle me-1"></i> {{ $page->exists ? 'Update CMS Page' : 'Save & Publish Page' }}
            </button>
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
    // 1. Initialize Summernote Rich Text Editor
    $('#cms-content').summernote({
      placeholder: 'Compose and format your page content here...',
      tabsize: 2,
      height: 460,
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
        { title: 'Blockquote / Highlight Box', tag: 'blockquote', className: 'policy-highlight-box', value: 'blockquote' }
      ]
    });

    // 2. Slug Helper Functions
    function slugify(text) {
      return text.toString().toLowerCase().trim()
        .replace(/&/g, '-and-')
        .replace(/[\s\W-]+/g, '-')
        .replace(/^-+|-+$/g, '');
    }

    const titleInput = document.getElementById('cms-title');
    const slugInput = document.getElementById('cms-slug');
    const slugPreviewText = document.getElementById('slug-preview-text');
    const btnSyncSlug = document.getElementById('btn-sync-slug');
    const isEditing = {{ $page->exists ? 'true' : 'false' }};
    let slugManuallyEdited = isEditing;

    // Real-time slug generation when creating
    titleInput.addEventListener('input', function() {
      if (!slugManuallyEdited || slugInput.value.trim() === '') {
        const generated = slugify(this.value);
        slugInput.value = generated;
        slugPreviewText.textContent = generated || 'page-slug';
      }
    });

    // Real-time preview when editing slug input directly
    slugInput.addEventListener('input', function() {
      slugManuallyEdited = true;
      const formatted = slugify(this.value);
      slugPreviewText.textContent = formatted || 'page-slug';
    });

    // Manual Re-sync button
    btnSyncSlug.addEventListener('click', function() {
      const generated = slugify(titleInput.value);
      slugInput.value = generated;
      slugPreviewText.textContent = generated || 'page-slug';
      slugManuallyEdited = false;
    });
  });
</script>
@endpush
