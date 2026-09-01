@extends('admin.layouts.app')

@section('page_title', 'Contact Messages & Inquiries')

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

  <!-- Top Metric Stat Cards -->
  <div class="row g-3 mb-4">
    <!-- Total Inquiries -->
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <span class="text-muted small fw-bold text-uppercase">Total Inquiries</span>
            <h3 class="fw-bold mb-0 mt-1 text-dark">{{ $stats['total'] }}</h3>
          </div>
          <div class="rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(6, 30, 67, 0.08); color: #061E43;">
            <i class="bi bi-envelope-paper-fill fs-4"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Unread Messages -->
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <span class="text-muted small fw-bold text-uppercase">Unread Messages</span>
            <h3 class="fw-bold mb-0 mt-1 text-danger">{{ $stats['unread'] }}</h3>
          </div>
          <div class="rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(220, 53, 69, 0.1); color: #dc3545;">
            <i class="bi bi-bell-fill fs-4"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Read Messages -->
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <span class="text-muted small fw-bold text-uppercase">Read &amp; Reviewed</span>
            <h3 class="fw-bold mb-0 mt-1 text-success">{{ $stats['read'] }}</h3>
          </div>
          <div class="rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(25, 135, 84, 0.1); color: #198754;">
            <i class="bi bi-envelope-open-fill fs-4"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Replied Messages -->
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <span class="text-muted small fw-bold text-uppercase">Replied</span>
            <h3 class="fw-bold mb-0 mt-1 text-primary">{{ $stats['replied'] }}</h3>
          </div>
          <div class="rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(13, 110, 253, 0.1); color: #0d6efd;">
            <i class="bi bi-reply-fill fs-4"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Messages Table Card -->
  <div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 border-bottom">
      <div class="row g-3 align-items-center justify-content-between">
        <div class="col-12 col-md-6">
          <h5 class="mb-0 fw-bold" style="color: #061E43;">
            <i class="bi bi-chat-left-text-fill me-2 text-warning"></i>Customer Contact Inquiries
          </h5>
          <small class="text-muted">Review incoming customer questions, consultations, and feedback</small>
        </div>

        <!-- Filter & Search Bar -->
        <div class="col-12 col-md-6">
          <form method="GET" action="{{ route('admin.contacts.index') }}" class="d-flex gap-2 justify-content-md-end">
            <div class="input-group input-group-sm" style="max-width: 260px;">
              <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
              <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search inquiries..." value="{{ request('search') }}">
            </div>

            <select name="status" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
              <option value="" {{ request('status') === '' ? 'selected' : '' }}>All Status</option>
              <option value="Unread" {{ request('status') === 'Unread' ? 'selected' : '' }}>Unread ({{ $stats['unread'] }})</option>
              <option value="Read" {{ request('status') === 'Read' ? 'selected' : '' }}>Read</option>
              <option value="Replied" {{ request('status') === 'Replied' ? 'selected' : '' }}>Replied</option>
            </select>

            @if(request()->hasAny(['search', 'status']))
              <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-secondary" title="Clear Filters">
                <i class="bi bi-x-lg"></i>
              </a>
            @endif
          </form>
        </div>
      </div>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 50px;">#</th>
              <th>Customer / Sender</th>
              <th>Contact Details</th>
              <th>Subject</th>
              <th>Message Preview</th>
              <th>Status</th>
              <th>Received</th>
              <th class="text-end" style="width: 140px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($contacts as $contact)
              <tr class="{{ $contact->isUnread() ? 'table-warning bg-opacity-10 fw-medium' : '' }}">
                <!-- ID -->
                <td class="text-muted small">#{{ $contact->id }}</td>

                <!-- Sender Name -->
                <td>
                  <strong class="text-dark d-block">{{ $contact->name }}</strong>
                  @if($contact->isUnread())
                    <span class="badge bg-danger" style="font-size: 0.65rem;">NEW</span>
                  @endif
                </td>

                <!-- Contact Details -->
                <td>
                  <div class="small">
                    <a href="mailto:{{ $contact->email }}" class="text-decoration-none text-dark d-block mb-1">
                      <i class="bi bi-envelope me-1 text-primary"></i>{{ $contact->email }}
                    </a>
                    <a href="tel:{{ $contact->contactno }}" class="text-decoration-none text-secondary">
                      <i class="bi bi-telephone me-1 text-success"></i>{{ $contact->contactno }}
                    </a>
                  </div>
                </td>

                <!-- Subject -->
                <td>
                  <span class="text-dark fw-bold small d-block" style="max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $contact->subject }}">
                    {{ $contact->subject }}
                  </span>
                </td>

                <!-- Message Preview -->
                <td>
                  <div class="text-secondary small" style="max-width: 240px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $contact->messages }}">
                    {{ $contact->messages }}
                  </div>
                </td>

                <!-- Status Badge -->
                <td>
                  @if($contact->status === 'Unread')
                    <span class="badge bg-danger">Unread</span>
                  @elseif($contact->status === 'Replied')
                    <span class="badge bg-primary">Replied</span>
                  @else
                    <span class="badge bg-secondary">Read</span>
                  @endif
                </td>

                <!-- Date -->
                <td class="text-muted small" title="{{ $contact->created_at->format('M d, Y h:i A') }}">
                  {{ $contact->created_at->diffForHumans() }}
                </td>

                <!-- Action Buttons -->
                <td class="text-end">
                  <div class="d-flex justify-content-end gap-1">
                    <!-- View Modal Button -->
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="openContactModal({{ json_encode($contact) }})" title="View Full Message">
                      <i class="bi bi-eye"></i>
                    </button>

                    <!-- Toggle Status Form -->
                    <form method="POST" action="{{ route('admin.contacts.status', $contact->id) }}" class="d-inline">
                      @csrf
                      @method('PATCH')
                      @if($contact->status === 'Unread')
                        <input type="hidden" name="status" value="Read">
                        <button type="submit" class="btn btn-sm btn-outline-success" title="Mark as Read">
                          <i class="bi bi-check2"></i>
                        </button>
                      @else
                        <input type="hidden" name="status" value="Unread">
                        <button type="submit" class="btn btn-sm btn-outline-warning text-dark" title="Mark as Unread">
                          <i class="bi bi-bell"></i>
                        </button>
                      @endif
                    </form>

                    <!-- Delete Form -->
                    <form method="POST" action="{{ route('admin.contacts.destroy', $contact->id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message from {{ addslashes($contact->name) }}?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Message">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center py-5 text-muted">
                  <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                  <p class="mb-0 fw-semibold">No contact inquiries found.</p>
                  <small>When visitors send messages through the storefront contact form, they will appear here.</small>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination Footer -->
    @if($contacts->hasPages())
      <div class="card-footer bg-white py-3 border-top d-flex justify-content-between align-items-center">
        <div class="small text-muted">
          Showing {{ $contacts->firstItem() }} to {{ $contacts->lastItem() }} of {{ $contacts->total() }} inquiries
        </div>
        <div>
          {{ $contacts->links() }}
        </div>
      </div>
    @endif
  </div>

</div>

<!-- Contact Inquiry Detail Modal -->
<div class="modal fade" id="contactDetailModal" tabindex="-1" aria-labelledby="contactDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow">
      
      <div class="modal-header text-white" style="background-color: #061E43;">
        <h5 class="modal-title fw-bold" id="contactDetailModalLabel">
          <i class="bi bi-chat-square-quote-fill me-2 text-warning"></i>Customer Inquiry Details
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">
        <div class="row g-3 mb-4">
          <!-- Sender -->
          <div class="col-12 col-md-6">
            <label class="small text-muted text-uppercase fw-bold">Customer Name</label>
            <div class="fs-6 fw-bold text-dark" id="modal-name">--</div>
          </div>

          <!-- Email -->
          <div class="col-12 col-md-6">
            <label class="small text-muted text-uppercase fw-bold">Email Address</label>
            <div>
              <a href="#" class="fs-6 text-primary fw-medium text-decoration-none" id="modal-email">--</a>
            </div>
          </div>

          <!-- Contact Number -->
          <div class="col-12 col-md-6">
            <label class="small text-muted text-uppercase fw-bold">Contact Phone</label>
            <div>
              <a href="#" class="fs-6 text-success fw-medium text-decoration-none" id="modal-phone">--</a>
            </div>
          </div>

          <!-- Date Received -->
          <div class="col-12 col-md-6">
            <label class="small text-muted text-uppercase fw-bold">Received At</label>
            <div class="fs-6 text-dark" id="modal-date">--</div>
          </div>
        </div>

        <!-- Subject -->
        <div class="mb-3">
          <label class="small text-muted text-uppercase fw-bold">Inquiry Subject</label>
          <div class="p-3 bg-light rounded-3 fw-bold text-dark fs-6" id="modal-subject">--</div>
        </div>

        <!-- Message Body -->
        <div class="mb-4">
          <label class="small text-muted text-uppercase fw-bold">Message Content</label>
          <div class="p-3 bg-light rounded-3 text-secondary" style="white-space: pre-wrap; line-height: 1.7; min-height: 120px;" id="modal-messages">--</div>
        </div>

        <!-- Quick Reply Action Box -->
        <div class="p-3 rounded-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="background: rgba(216, 188, 141, 0.15); border: 1px solid rgba(216, 188, 141, 0.3);">
          <div>
            <strong class="text-dark small d-block">Quick Reply Options</strong>
            <span class="small text-muted">Respond to customer directly via their preferred communication channel.</span>
          </div>
          <div class="d-flex gap-2">
            <a href="#" class="btn btn-sm btn-primary" id="modal-email-btn" target="_blank">
              <i class="bi bi-reply-fill"></i> Reply by Email
            </a>
            <a href="#" class="btn btn-sm btn-success" id="modal-tel-btn">
              <i class="bi bi-telephone-outbound-fill"></i> Call Phone
            </a>
          </div>
        </div>

      </div>

      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

@push('scripts')
<script>
  function openContactModal(contact) {
    document.getElementById('modal-name').innerText = contact.name || '--';
    
    const emailEl = document.getElementById('modal-email');
    emailEl.innerText = contact.email || '--';
    emailEl.href = `mailto:${contact.email}?subject=Re: ${encodeURIComponent(contact.subject || 'Power Veda Inquiry')}`;
    
    const emailBtn = document.getElementById('modal-email-btn');
    if (emailBtn) {
      emailBtn.href = `mailto:${contact.email}?subject=Re: ${encodeURIComponent(contact.subject || 'Power Veda Inquiry')}`;
    }

    const phoneEl = document.getElementById('modal-phone');
    phoneEl.innerText = contact.contactno || '--';
    phoneEl.href = `tel:${contact.contactno}`;

    const telBtn = document.getElementById('modal-tel-btn');
    if (telBtn) {
      telBtn.href = `tel:${contact.contactno}`;
    }

    document.getElementById('modal-date').innerText = contact.created_at ? new Date(contact.created_at).toLocaleString() : '--';
    document.getElementById('modal-subject').innerText = contact.subject || 'No Subject';
    document.getElementById('modal-messages').innerText = contact.messages || '--';

    const modalEl = document.getElementById('contactDetailModal');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();

    // Auto mark as read on backend via fetch
    if (contact.status === 'Unread') {
      fetch(`/admin/contacts/${contact.id}`, {
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      }).catch(err => console.debug('Mark read error:', err));
    }
  }
</script>
@endpush
@endsection
