<!-- Checkout & Place Order Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

      <!-- Modal Header (Navy + Gold) -->
      <div class="p-4 d-flex justify-content-between align-items-center" style="background: var(--primary-color); border-bottom: 1px solid rgba(216, 188, 141, 0.25);">
        <div class="d-flex align-items-center gap-3">
          <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 44px; height: 44px; background: rgba(216, 188, 141, 0.15); color: var(--gold-color);">
            <i class="bi bi-shield-lock-fill fs-5"></i>
          </div>
          <div>
            <h5 class="modal-title fw-bold text-white mb-0" id="checkoutModalLabel">Secure Checkout &amp; Place Order</h5>
            <span class="small" style="color: var(--silver-color);">Fast, encrypted Vedic direct delivery</span>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body p-4 p-md-5" style="background: #FAF9F6;">
        <div id="checkout-alert" class="alert alert-danger d-none py-2 px-3 small mb-4" role="alert"></div>

        <form id="checkout-form" onsubmit="handlePlaceOrderSubmit(event)">
          <div class="row g-4">

            <!-- Left Col: Delivery Address & Payment Method -->
            <div class="col-12 col-lg-7">

              <!-- 1. Delivery Destination -->
              <div class="bg-white p-4 rounded-3 border shadow-sm mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-geo-alt-fill text-warning"></i> 1. Delivery Address
                  </h6>
                  <button type="button" class="btn btn-sm btn-link p-0 text-decoration-none" id="btn-toggle-new-address" onclick="toggleNewAddressCheckout()">
                    <i class="bi bi-plus-circle"></i> + Add New
                  </button>
                </div>

                <!-- Saved Addresses Radio List -->
                <div id="checkout-saved-addresses-list" class="mb-3">
                  <!-- Dynamically populated by JS from user addresses -->
                </div>

                <!-- New Address Form (Collapsible) -->
                <div id="checkout-new-address-form" class="d-none border-top pt-3 mt-2">
                  <div class="row g-2">
                    <div class="col-12 col-sm-6">
                      <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 0.72rem;">Recipient Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm" id="checkout-recipient-name" placeholder="Full Name">
                      <div class="contact-error-text d-none" id="checkout-recipient-name-error"></div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 0.72rem;">Contact Phone <span class="text-danger">*</span></label>
                      <input type="tel" class="form-control form-control-sm" id="checkout-contact-no" placeholder="10-digit Mobile">
                      <div class="contact-error-text d-none" id="checkout-contact-no-error"></div>
                    </div>
                    <div class="col-12">
                      <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 0.72rem;">Address Line 1 <span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm" id="checkout-address-1" placeholder="House/Flat No, Building, Street">
                      <div class="contact-error-text d-none" id="checkout-address-1-error"></div>
                    </div>
                    <div class="col-12">
                      <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 0.72rem;">Address Line 2 (Optional)</label>
                      <input type="text" class="form-control form-control-sm" id="checkout-address-2" placeholder="Landmark, Area, Sector">
                    </div>
                    <div class="col-4">
                      <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 0.72rem;">City <span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm" id="checkout-city" placeholder="City">
                      <div class="contact-error-text d-none" id="checkout-city-error"></div>
                    </div>
                    <div class="col-4">
                      <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 0.72rem;">State <span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm" id="checkout-state" placeholder="State">
                      <div class="contact-error-text d-none" id="checkout-state-error"></div>
                    </div>
                    <div class="col-4">
                      <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 0.72rem;">Pincode <span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm" id="checkout-pincode" placeholder="Pincode" maxlength="10">
                      <div class="contact-error-text d-none" id="checkout-pincode-error"></div>
                    </div>
                    <div class="col-12 mt-2">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkout-save-address" checked>
                        <label class="form-check-label small text-muted" for="checkout-save-address">
                          Save this delivery address to my account
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <!-- 2. Payment Method -->
              <div class="bg-white p-4 rounded-3 border shadow-sm">
                <h6 class="fw-bold mb-3 text-dark d-flex align-items-center gap-2">
                  <i class="bi bi-credit-card-2-front-fill text-warning"></i> 2. Payment Method
                </h6>

                <div class="d-flex flex-column gap-2">
                  <label class="p-3 border rounded-3 d-flex align-items-center justify-content-between cursor-pointer payment-option-label" style="cursor: pointer;">
                    <div class="d-flex align-items-center gap-3">
                      <input class="form-check-input mt-0" type="radio" name="checkout_payment" id="pay-cod" value="Cash on Delivery" checked>
                      <div>
                        <strong class="d-block text-dark small">Cash on Delivery (COD)</strong>
                        <span class="text-muted" style="font-size: 0.75rem;">Pay in cash or scan QR upon physical parcel handover</span>
                      </div>
                    </div>
                    <span class="badge bg-light text-dark border">Standard</span>
                  </label>

                  <label class="p-3 border rounded-3 d-flex align-items-center justify-content-between cursor-pointer payment-option-label" style="cursor: pointer;">
                    <div class="d-flex align-items-center gap-3">
                      <input class="form-check-input mt-0" type="radio" name="checkout_payment" id="pay-upi" value="Prepaid UPI">
                      <div>
                        <strong class="d-block text-dark small">Instant UPI / NetBanking / Cards</strong>
                        <span class="text-muted" style="font-size: 0.75rem;">Instant confirmed order processing &amp; priority dispatch</span>
                      </div>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Recommended</span>
                  </label>
                </div>
              </div>

            </div>

            <!-- Right Col: Order Items Summary -->
            <div class="col-12 col-lg-5">
              <div class="bg-white p-4 rounded-3 border shadow-sm h-100 d-flex flex-column justify-content-between">
                <div>
                  <h6 class="fw-bold mb-3 text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-bag-check-fill text-warning"></i> Order Summary
                  </h6>

                  <!-- Items Mini-List -->
                  <div class="checkout-items-scroll overflow-auto mb-3 pe-1" id="checkout-items-list" style="max-height: 220px;">
                    <!-- Dynamically populated by JS from active cart -->
                  </div>

                  <!-- Calculations -->
                  <div class="border-top pt-3">
                    <div class="d-flex justify-content-between small text-muted mb-2">
                      <span>Items Subtotal:</span>
                      <span class="fw-semibold text-dark" id="checkout-subtotal">₹0</span>
                    </div>
                    <div class="d-flex justify-content-between small text-muted mb-2">
                      <span>Shipping Charge:</span>
                      <span class="fw-semibold text-success" id="checkout-shipping">FREE</span>
                    </div>
                    <div class="d-flex justify-content-between fs-5 fw-bold text-dark pt-2 border-top">
                      <span>Total Payable:</span>
                      <span style="color: var(--heading-color);" id="checkout-total">₹0</span>
                    </div>
                  </div>
                </div>

                <div class="pt-4 mt-3 border-top">
                  <button type="submit" class="btn btn-primary w-100 py-3 fw-bold text-uppercase d-flex align-items-center justify-content-center gap-2" id="checkout-submit-btn" style="letter-spacing: 1px;">
                    <span class="spinner-border spinner-border-sm d-none" id="checkout-spinner"></span>
                    <i class="bi bi-check-circle-fill"></i> CONFIRM &amp; PLACE ORDER
                  </button>
                  <div class="text-center mt-2 text-muted" style="font-size: 0.72rem;">
                    <i class="bi bi-lock-fill text-success"></i> 256-Bit SSL Encrypted &bull; 100% Satisfaction Guarantee
                  </div>
                </div>
              </div>
            </div>

          </div>
        </form>
      </div>

    </div>
  </div>
</div>
