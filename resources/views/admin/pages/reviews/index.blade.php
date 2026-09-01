@extends('admin.layouts.app')

@section('page_title', 'Customer Reviews')

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

  <!-- Reviews Card -->
  <div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2 border-bottom">
      <div>
        <h5 class="mb-0 fw-bold" style="color: #061E43;">
          <i class="bi bi-star-fill me-2 text-warning"></i>All Customer Reviews
        </h5>
        <small class="text-muted">Manage testimonials, ratings, and customer feedback</small>
      </div>

      <!-- Add Button (Opens create.blade.php) -->
      <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle"></i> Add Customer Review
      </a>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 60px;">Photo</th>
              <th>Reviewer</th>
              <th>Rating &amp; Feedback</th>
              <th>Product / Formulation</th>
              <th>Status</th>
              <th>Date</th>
              <th class="text-end" style="width: 140px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($reviews as $review)
              <tr>
                <!-- 1. Photo / Avatar -->
                <td>
                  <img src="{{ $review->photo_url }}" alt="{{ $review->author }}" class="rounded-circle border" style="width: 42px; height: 42px; object-fit: cover;">
                </td>

                <!-- 2. Reviewer Name & Location -->
                <td>
                  <strong class="text-dark d-block">{{ $review->author }}</strong>
                  <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $review->location ?: 'India' }}</small>
                </td>

                <!-- 3. Rating & Feedback Comment -->
                <td>
                  <div class="mb-1 text-warning">
                    @for($i = 1; $i <= 5; $i++)
                      @if($i <= $review->rating)
                        <i class="bi bi-star-fill"></i>
                      @else
                        <i class="bi bi-star text-muted opacity-50"></i>
                      @endif
                    @endfor
                    <span class="text-dark fw-bold ms-1 small">({{ $review->rating }}.0)</span>
                  </div>
                  <div class="text-secondary small" style="max-width: 320px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $review->comment }}">
                    "{{ $review->comment }}"
                  </div>
                </td>

                <!-- 4. Associated Product -->
                <td>
                  @if($review->product)
                    <span class="badge bg-light text-dark border">
                      <i class="bi bi-box-seam me-1 text-primary"></i>{{ $review->product->name }}
                    </span>
                  @else
                    <span class="badge bg-light text-secondary border">General Review</span>
                  @endif
                </td>

                <!-- 5. Status -->
                <td>
                  @if($review->status === 'Approved')
                    <span class="badge bg-success">Approved</span>
                  @elseif($review->status === 'Pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                  @else
                    <span class="badge bg-secondary">Hidden</span>
                  @endif
                </td>

                <!-- 6. Date -->
                <td>
                  <small class="text-muted">{{ $review->created_at ? $review->created_at->format('d M Y') : 'Recent' }}</small>
                </td>

                <!-- 7. Actions (Standard Edit Link & Delete Form) -->
                <td class="text-end">
                  <div class="d-inline-flex gap-1">
                    <!-- Edit Link -->
                    <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Review">
                      <i class="bi bi-pencil-square"></i>
                    </a>

                    <!-- Delete Form (Standard POST with DELETE method) -->
                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review by \'{{ addslashes($review->author) }}\'?');" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Review">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                  <i class="bi bi-chat-square-quote fs-1 d-block mb-2 text-secondary"></i>
                  No reviews found. <a href="{{ route('admin.reviews.create') }}">Click here to add your first customer review</a>.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection
