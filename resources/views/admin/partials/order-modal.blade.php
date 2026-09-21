<!-- MODAL: VIEW ORDER DETAILS MODAL -->
<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-3">
      <div class="modal-header text-white" style="background-color: #061E43 !important;">
        <h5 class="modal-title fw-bold" id="viewOrderModalLabel">
          <i class="bi bi-receipt me-2"></i> Order Information
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
          <div>
            <span class="text-muted small">Order Reference:</span>
            <h5 class="fw-bold mb-0" id="view-order-id" style="color: #061E43;">#PV-00000</h5>
          </div>
          <span class="badge bg-primary px-3 py-2" id="view-order-status-badge">Processing</span>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <span class="text-muted small d-block">Customer Details:</span>
            <strong id="view-order-customer" class="d-block text-dark">Customer Name</strong>
            <span id="view-order-email" class="small text-muted d-block">customer@example.com</span>
            <span id="view-order-phone" class="small text-muted d-block">+91 98765 43210</span>
          </div>
          <div class="col-md-6">
            <span class="text-muted small d-block">Delivery Address:</span>
            <span id="view-order-address" class="small text-dark d-block mt-1">Delivery Address</span>
          </div>
        </div>

        <div class="mb-3">
          <span class="text-muted small d-block mb-2">Purchased Formulations:</span>
          <div id="view-order-items-list" class="border rounded-2 p-2 bg-light">
            <!-- Rendered dynamically by js/admin.js -->
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
          <div>
            <span class="text-muted small d-block">Payment Method:</span>
            <div class="d-flex align-items-center gap-2 mt-1">
              <span class="fw-bold small text-dark" id="view-order-payment">Cash on Delivery</span>
              <span class="badge bg-secondary" id="view-order-payment-status">Pending</span>
            </div>
            <span class="text-muted small font-monospace d-block mt-1" id="view-order-txn" style="display: none;"></span>
          </div>
          <div class="text-end">
            <span class="text-muted small d-block">Total Amount:</span>
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
