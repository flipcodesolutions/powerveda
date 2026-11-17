@extends('admin.layouts.app')

@section('page_title', 'CMS Pages Management')

@section('content')
<div class="container-fluid px-0">

  <!-- Success Notification Message -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
      <i class="bi bi-check-circle-fill fs-5"></i>
      <div><strong>Success!</strong> {{ session('success') }}</div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Error Notification Message -->
  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
      <i class="bi bi-exclamation-triangle-fill fs-5"></i>
      <div><strong>Error!</strong> {{ session('error') }}</div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Main CMS Listing Card -->
  <div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2 border-bottom">
      <div>
        <h5 class="mb-0 fw-bold" style="color: #061E43;">
          <i class="bi bi-file-earmark-richtext me-2 text-primary"></i>CMS Website Pages
        </h5>
        <small class="text-muted">Manage policy pages, legal documents, and custom CMS pages dynamically</small>
      </div>

      <!-- Header Action: Create New Page -->
      <a href="{{ route('admin.cms.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle"></i> Add New Page
      </a>
    </div>

    <!-- Search & Filter Bar -->
    <div class="card-body border-bottom bg-light py-3 px-4">
      <form action="{{ route('admin.cms.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-12 col-md-5 col-lg-4">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0 text-muted">
              <i class="bi bi-search"></i>
            </span>
            <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search by title or slug..." value="{{ $search }}">
          </div>
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-primary px-3">
            <i class="bi bi-filter me-1"></i> Search
          </button>
        </div>
        @if($search !== '')
          <div class="col-auto">
            <a href="{{ route('admin.cms.index') }}" class="btn btn-outline-secondary px-3">
              <i class="bi bi-x-circle me-1"></i> Reset
            </a>
          </div>
        @endif
      </form>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 70px;">ID</th>
              <th>Page Title</th>
              <th>Slug / URL</th>
              <th style="width: 140px;">Status</th>
              <th style="width: 180px;">Last Updated</th>
              <th class="text-end" style="width: 160px;">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pages as $page)
              <tr>
                <!-- 1. ID -->
                <td class="text-muted fw-bold">#{{ $page->id }}</td>

                <!-- 2. Page Title -->
                <td>
                  <strong class="text-dark d-block">{{ $page->title }}</strong>
                  <small class="text-muted">
                    <i class="bi bi-file-text me-1"></i>{{ Str::limit(strip_tags($page->content ?: $page->detail), 50) }}
                  </small>
                </td>

                <!-- 3. Slug -->
                <td>
                  <code class="text-primary bg-light px-2 py-1 rounded small border">
                    /{{ $page->slug }}
                  </code>
                </td>

                <!-- 4. Status Badge -->
                <td>
                  @if($page->status)
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill small">
                      <i class="bi bi-check-circle-fill me-1"></i> Active
                    </span>
                  @else
                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 rounded-pill small">
                      <i class="bi bi-dash-circle-fill me-1"></i> Inactive
                    </span>
                  @endif
                </td>

                <!-- 5. Last Updated -->
                <td>
                  <span class="text-dark d-block small fw-semibold">{{ $page->updated_at ? $page->updated_at->format('M d, Y h:i A') : '-' }}</span>
                  <small class="text-muted">{{ $page->updated_at ? $page->updated_at->diffForHumans() : '' }}</small>
                </td>

                <!-- 6. Actions (Edit & Toggle) -->
                <td class="text-end">
                  <div class="d-inline-flex gap-1 align-items-center">
                    
                    <!-- Live Storefront Preview Link -->
                    @if($page->status)
                      <a href="{{ url($page->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="View Storefront">
                        <i class="bi bi-box-arrow-up-right"></i>
                      </a>
                    @endif

                    <!-- Edit Action -->
                    <a href="{{ route('admin.cms.edit', $page->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Page">
                      <i class="bi bi-pencil-square"></i>
                    </a>

                    <!-- Active/Inactive Toggle Action -->
                    <form action="{{ route('admin.cms.toggleStatus', $page->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Change status of \'{{ addslashes($page->title) }}\' to {{ $page->status ? 'Inactive' : 'Active' }}?');">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="btn btn-sm {{ $page->status ? 'btn-outline-warning' : 'btn-outline-success' }}" title="{{ $page->status ? 'Deactivate Page' : 'Activate Page' }}">
                        <i class="bi {{ $page->status ? 'bi-toggle-on' : 'bi-toggle-off' }}"></i>
                      </button>
                    </form>

                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-5 text-muted">
                  <i class="bi bi-file-earmark-x fs-1 d-block mb-2 text-secondary"></i>
                  @if($search !== '')
                    No CMS pages matched "<strong>{{ $search }}</strong>". <br>
                    <a href="{{ route('admin.cms.index') }}" class="btn btn-sm btn-outline-secondary mt-2">Clear Search</a>
                  @else
                    No CMS pages found in the database. <br>
                    <a href="{{ route('admin.cms.create') }}" class="btn btn-sm btn-primary mt-2">
                      <i class="bi bi-plus-circle me-1"></i> Create Your First Page
                    </a>
                  @endif
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination Footer -->
    @if($pages->hasPages())
      <div class="card-footer bg-white py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
        <small class="text-muted">
          Showing {{ $pages->firstItem() }} to {{ $pages->lastItem() }} of {{ $pages->total() }} pages
        </small>
        <div>
          {{ $pages->links() }}
        </div>
      </div>
    @endif
  </div>

</div>
@endsection
