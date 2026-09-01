<!-- My Orders & Tracking Modal -->
<div class="modal fade" id="myOrdersModal" tabindex="-1" aria-labelledby="myOrdersModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg overflow-hidden rounded-3">

      <!-- Header -->
      <div class="orders-modal-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-box-seam fs-4" style="color: var(--gold-color);"></i>
          <div>
            <h5 class="modal-title mb-0 fw-bold" id="myOrdersModalLabel">My Orders &amp; Delivery Status</h5>
            <span class="small" style="color: var(--silver-color);">Track active shipments, view invoices &amp; reorder easily</span>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body p-4" id="orders-modal-body" style="max-height: 70vh; overflow-y: auto;">
        <div class="text-center py-5 text-muted">
          <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
          <p class="small mb-0">Loading your orders...</p>
        </div>
      </div>

    </div>
  </div>
</div>
