<!-- MODAL: VIEW ORDER DETAILS MODAL -->
<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-3">
      <div class="modal-header text-white" style="background-color: #061E43 !important;">
        <h5 class="modal-title fw-bold" id="viewOrderModalLabel">Order Information</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
          <div>
            <span class="text-muted small">Order ID:</span>
            <h5 class="fw-bold mb-0" id="view-order-id" style="color: #061E43;">#PV-00000</h5>
          </div>
          <span class="badge bg-primary px-3 py-2" id="view-order-status-badge">Delivered</span>
        </div>

        <div class="mb-3">
          <span class="text-muted small d-block">Customer Details:</span>
          <strong id="view-order-customer" class="d-block">Customer Name</strong>
          <span id="view-order-email" class="small text-muted d-block">customer@example.com</span>
          <span id="view-order-address" class="small text-muted d-block mt-1">Delivery Address</span>
        </div>

        <div class="mb-3">
          <span class="text-muted small d-block mb-2">Purchased Formulations:</span>
          <div id="view-order-items-list">
            <!-- Rendered dynamically by js/admin.js -->
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center pt-2">
          <div>
            <span class="text-muted small">Payment Mode:</span>
            <span class="fw-bold d-block small" id="view-order-payment">Prepaid UPI</span>
          </div>
          <div class="text-end">
            <span class="text-muted small">Total Paid:</span>
            <h4 class="fw-bold mb-0" id="view-order-total" style="color: #061E43;">₹0</h4>
          </div>
        </div>

      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
