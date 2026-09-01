@extends('admin.layouts.app')

@section('page_title', 'Product List')

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

  <!-- Products Card -->
  <div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2 border-bottom">
      <div>
        <h5 class="mb-0 fw-bold" style="color: #061E43;">
          <i class="bi bi-box-seam me-2 text-primary"></i>All Products
        </h5>
        <small class="text-muted">Manage your store products and stock</small>
      </div>

      <!-- Simple Add Button (Opens create.blade.php) -->
      <a href="{{ route('admin.products.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle"></i> Add New Product
      </a>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 70px;">Photo</th>
              <th>Product Name</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Detail</th>
              <th>Meta Title</th>
              <th>OG Image</th>
              <th class="text-end" style="width: 140px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($products as $product)
              <tr>
                <!-- 1. Photo -->
                <td>
                  <img src="{{ $product->photo_url }}" alt="{{ $product->name }}" class="rounded border" style="width: 50px; height: 50px; object-fit: cover;">
                </td>

                <!-- 2. Name -->
                <td>
                  <strong class="text-dark d-block">{{ $product->name }}</strong>
                  <div class="d-flex align-items-center gap-1 flex-wrap mt-1">
                    <span class="badge bg-light text-secondary border small">{{ $product->badge ?: 'NATURAL' }}</span>
                    <span class="badge bg-info-subtle text-info border border-info-subtle small">
                      <i class="bi bi-clock-history"></i> {{ count($product->how_to_use_steps_list) }} Steps
                    </span>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle small">
                      <i class="bi bi-question-circle"></i> {{ $product->faqs_count ?? $product->faqs()->count() }} FAQs
                    </span>
                  </div>
                </td>

                <!-- 3. Price -->
                <td>
                  <span class="fw-bold text-dark">₹{{ number_format($product->price, 2) }}</span>
                </td>

                <!-- 4. Stock -->
                <td>
                  @if($product->stock <= 0)
                    <span class="badge bg-danger">Out of Stock ({{ $product->stock }})</span>
                  @elseif($product->stock <= 20)
                    <span class="badge bg-warning text-dark">Low Stock ({{ $product->stock }})</span>
                  @else
                    <span class="badge bg-success">In Stock ({{ $product->stock }})</span>
                  @endif
                </td>

                <!-- 5. Detail -->
                <td>
                  <div class="text-muted small" style="max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $product->detail }}">
                    {{ $product->detail ?: 'No details added' }}
                  </div>
                </td>

                <!-- 6. Meta Title -->
                <td>
                  <div class="small" style="max-width: 160px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $product->meta_title }}">
                    {{ $product->meta_title ?: '-' }}
                  </div>
                </td>

                <!-- 7. OG Image -->
                <td>
                  @if($product->og_image)
                    <a href="{{ $product->og_image_url }}" target="_blank">
                      <img src="{{ $product->og_image_url }}" alt="OG Image" class="rounded border" style="width: 45px; height: 30px; object-fit: cover;">
                    </a>
                  @else
                    <span class="text-muted small">-</span>
                  @endif
                </td>

                <!-- 8. Actions (Standard Edit Link & Delete Form) -->
                <td class="text-end">
                  <div class="d-inline-flex gap-1">
                    <!-- Edit Link -->
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Product">
                      <i class="bi bi-pencil-square"></i>
                    </a>

                    <!-- Delete Form (Standard POST with DELETE method) -->
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete \'{{ addslashes($product->name) }}\'?');" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Product">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center py-5 text-muted">
                  <i class="bi bi-box-seam fs-1 d-block mb-2 text-secondary"></i>
                  No products found. <a href="{{ route('admin.products.create') }}">Click here to add your first product</a>.
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
