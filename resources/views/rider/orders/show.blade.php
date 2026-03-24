{{-- resources/views/rider/orders/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Order ' . ($order->tracking_id ?? 'Details') . ' - MediSwift')

@section('header')
    <div>
        <h1 class="h2 fw-bold mb-1">Order Details</h1>
        <p class="text-muted mb-0">
            <i class="bi bi-receipt me-1"></i>
            Tracking ID: {{ $order->tracking_id ?? 'N/A' }}
        </p>
    </div>
    <div class="mt-3 mt-sm-0">
        <a href="{{ route('rider.orders.index') }}" class="btn btn-outline-secondary btn-rounded">
            <i class="bi bi-arrow-left me-1"></i> Back to Orders
        </a>
    </div>
@endsection

@section('content')
<div class="py-3 py-md-4">
    <div class="row g-4">
        <!-- Main Order Information -->
        <div class="col-12 col-lg-8">
            <!-- Order Status Banner -->
            <div class="alert alert-modern d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill fs-5"></i>
                    <span>Current Status:</span>
                    <span class="badge rounded-pill px-3 py-2
                        @if($order->status == 'delivered') bg-success
                        @elseif($order->status == 'collected') bg-info
                        @elseif($order->status == 'in_transit') bg-primary
                        @elseif($order->status == 'assigned') bg-warning
                        @elseif($order->status == 'cancelled') bg-danger
                        @else bg-secondary @endif">
                        <i class="bi
                            @if($order->status == 'delivered') bi-check-circle
                            @elseif($order->status == 'collected') bi-box-seam
                            @elseif($order->status == 'in_transit') bi-truck
                            @elseif($order->status == 'assigned') bi-clock
                            @elseif($order->status == 'cancelled') bi-x-circle
                            @else bi-question-circle @endif me-1">
                        </i>
                        {{ ucfirst(str_replace('_', ' ', $order->status ?? 'Unknown')) }}
                    </span>
                </div>
                @if($order->paid)
                    <span class="badge bg-success rounded-pill px-3 py-2">
                        <i class="bi bi-check-circle-fill me-1"></i> Paid
                    </span>
                @else
                    <span class="badge bg-warning rounded-pill px-3 py-2">
                        <i class="bi bi-clock me-1"></i> Unpaid
                    </span>
                @endif
            </div>

            <!-- Order Details Card -->
            <div class="card-glass p-4 p-md-5 mb-4">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-info-circle me-2 text-primary"></i>Order Information
                </h5>

                <div class="row g-4">
                    <!-- Recipient Info -->
                    <div class="col-12 col-md-6">
                        <div class=" ps-3">
                            <h6 class="text-muted mb-2 small text-uppercase">Recipient</h6>
                            <div class="fw-semibold fs-5">{{ $order->recipient_name }}</div>
                            @if($order->recipient_phone)
                                <div class="mt-1">
                                    <i class="bi bi-telephone me-2 text-muted"></i>
                                    <a href="tel:{{ $order->recipient_phone }}" class="text-decoration-none">{{ $order->recipient_phone }}</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Cost Info -->
                    <div class="col-12 col-md-6">
                        <div class="ps-3">
                            <h6 class="text-muted mb-2 small text-uppercase">Delivery Cost</h6>
                            <div class="fw-bold fs-3 text-primary">₦{{ number_format($order->cost ?? 0, 2) }}</div>
                            @if($order->paid && $order->paidBy)
                                <div class="small text-muted mt-1">Paid by {{ $order->paidBy->name }}</div>
                            @endif
                        </div>
                    </div>

                    <!-- Pickup Address -->
                    <div class="col-12">
                        <div class="ps-3">
                            <h6 class="text-muted mb-2 small text-uppercase">
                                <i class="bi bi-shop me-1"></i>Pickup Address
                            </h6>
                            <div class="mb-2">{{ $order->pickup_address ?? 'Not specified' }}</div>
                            @if($order->pickup_address)
                                <a href="https://maps.google.com/?q={{ urlencode($order->pickup_address) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill">
                                    <i class="bi bi-map me-1"></i> Open in Maps
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Delivery Address -->
                    <div class="col-12">
                        <div class="ps-3">
                            <h6 class="text-muted mb-2 small text-uppercase">
                                <i class="bi bi-house-door me-1"></i>Delivery Address
                            </h6>
                            <div class="mb-2">{{ $order->delivery_address ?? 'Not specified' }}</div>
                            @if($order->delivery_address)
                                <a href="https://maps.google.com/?q={{ urlencode($order->delivery_address) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill">
                                    <i class="bi bi-map me-1"></i> Open in Maps
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($order->notes)
                    <div class="col-12">
                        <div class="ps-3">
                            <h6 class="text-muted mb-2 small text-uppercase">
                                <i class="bi bi-chat-text me-1"></i>Additional Notes
                            </h6>
                            <div class="bg-light rounded-3 p-3">
                                {{ $order->notes }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Update Status Card -->
            @if($order->status != 'delivered' && $order->status != 'cancelled')
            <div class="card-glass p-4 p-md-5 mb-4">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-arrow-repeat me-2 text-primary"></i>Update Status
                </h5>

                <form action="{{ route('rider.orders.update_status', $order) }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Current Status</label>
                            <select name="status" class="form-select form-select-lg" required>
                                <option value="assigned" @if($order->status=='assigned') selected @endif>
                                    <i class="bi bi-clock"></i> Order Assigned - Ready for pickup
                                </option>
                                <option value="collected" @if($order->status=='collected') selected @endif>
                                    <i class="bi bi-box-seam"></i> Order Collected - Package picked up
                                </option>
                                <option value="in_transit" @if($order->status=='in_transit') selected @endif>
                                    <i class="bi bi-truck"></i> In Transit - On the way to recipient
                                </option>
                                <option value="delivered" @if($order->status=='delivered') selected @endif>
                                    <i class="bi bi-check-circle"></i> Delivered - Order completed
                                </option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Status Notes <span class="text-muted">(optional)</span></label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Add any notes about this update..."></textarea>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">
                                <i class="bi bi-check-circle me-2"></i> Update Status
                            </button>
                        </div>
                    </div>
                </form>

                @if(!$order->paid && $order->assigned_to == auth()->id())
                    <hr class="my-4">
                    <div class="mt-3">
                        <h6 class="fw-semibold mb-3">Payment Collection</h6>
                        <form action="{{ route('rider.orders.mark_paid', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success rounded-pill px-4" onclick="return confirm('Confirm payment received?')">
                                <i class="bi bi-credit-card me-2"></i> Mark as Paid
                            </button>
                        </form>
                        <div class="small text-muted mt-2">
                            <i class="bi bi-info-circle"></i> Only mark as paid when you have collected payment from the recipient
                        </div>
                    </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-12 col-lg-4">
            <!-- Progress Timeline Card -->
            <div class="card-glass p-4 mb-4">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-clock-history me-2 text-primary"></i>Progress Timeline
                </h5>

                @if($progresses->count() > 0)
                    <div class="timeline">
                        @foreach($progresses as $p)
                            <div class="timeline-item pb-4">
                                <div class="d-flex gap-3">
                                    <div class="timeline-icon">
                                        <div class="rounded-circle
                                            @if($loop->first) bg-primary
                                            @elseif($p->status == 'delivered') bg-success
                                            @elseif($p->status == 'cancelled') bg-danger
                                            @else bg-secondary @endif
                                            d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="bi
                                                @if($p->status == 'delivered') bi-check-circle
                                                @elseif($p->status == 'collected') bi-box-seam
                                                @elseif($p->status == 'in_transit') bi-truck
                                                @elseif($p->status == 'assigned') bi-clock
                                                @elseif($p->status == 'cancelled') bi-x-circle
                                                @else bi-question-circle @endif text-white small">
                                            </i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong class="text-dark">{{ ucfirst(str_replace('_', ' ', $p->status)) }}</strong>
                                                @if($p->notes)
                                                    <div class="small text-muted mt-1">{{ $p->notes }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="small text-muted mt-1">
                                            <i class="bi bi-calendar3 me-1"></i>{{ $p->created_at->format('M d, Y H:i') }}
                                        </div>
                                        <div class="small text-muted">
                                            <i class="bi bi-person me-1"></i>{{ optional($p->reporter)->name ?? 'System' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-hourglass-split fs-1 text-muted"></i>
                        <p class="text-muted mt-2 mb-0">No progress updates yet</p>
                        <p class="small text-muted">Updates will appear here as the order progresses</p>
                    </div>
                @endif
            </div>

            <!-- Quick Actions Card -->
            <div class="card-glass p-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-lightning me-2 text-primary"></i>Quick Actions
                </h5>

                <div class="d-grid gap-2">
                    @if($order->pickup_address)
                        <a href="https://maps.google.com/?q={{ urlencode($order->pickup_address) }}" target="_blank" class="btn btn-outline-primary rounded-pill">
                            <i class="bi bi-geo-alt me-2"></i> Navigate to Pickup
                        </a>
                    @endif

                    @if($order->delivery_address)
                        <a href="https://maps.google.com/?q={{ urlencode($order->delivery_address) }}" target="_blank" class="btn btn-outline-primary rounded-pill">
                            <i class="bi bi-house-door me-2"></i> Navigate to Delivery
                        </a>
                    @endif

                    @if($order->recipient_phone)
                        <a href="tel:{{ $order->recipient_phone }}" class="btn btn-outline-success rounded-pill">
                            <i class="bi bi-telephone me-2"></i> Call Recipient
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss flash messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = bootstrap.Alert.getInstance(alert);
                if (bsAlert) {
                    bsAlert.close();
                }
            });
        }, 5000);

        // Add confirmation for status update
        const statusForm = document.querySelector('form[action*="update_status"]');
        if (statusForm) {
            statusForm.addEventListener('submit', function(e) {
                const statusSelect = this.querySelector('select[name="status"]');
                const selectedStatus = statusSelect.options[statusSelect.selectedIndex]?.text;
                if (selectedStatus && !confirm(`Are you sure you want to update status to "${selectedStatus}"?`)) {
                    e.preventDefault();
                }
            });
        }

        // Add auto-scroll to timeline
        const timeline = document.querySelector('.timeline');
        if (timeline && timeline.children.length > 0) {
            const lastItem = timeline.lastElementChild;
            if (lastItem) {
                lastItem.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }
    });
</script>
@endpush

<style>
    /* Additional styles for rider order details */
    .card-glass {
        background: white;
        border: none;
        border-radius: 1.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-glass:hover {
        transform: translateY(-2px);
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.08);
    }

    .alert-modern {
        border: none;
        border-radius: 1rem;
        background: #e7f3ff;
        color: #0a58ca;
    }

    .btn-rounded {
        border-radius: 2rem;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-rounded:hover {
        transform: translateY(-1px);
    }

    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }

    /* Timeline styles */
    .timeline {
        position: relative;
    }

    .timeline-item {
        position: relative;
        border-left: 2px solid var(--gray-300);
        margin-left: 16px;
        padding-left: 24px;
    }

    .timeline-item:last-child {
        border-left-color: transparent;
    }

    .timeline-icon {
        position: absolute;
        left: -16px;
        top: 0;
    }

    /* Form styles */
    .form-select-lg {
        padding: 0.75rem 1rem;
        font-size: 1rem;
        border-radius: 1rem;
    }

    /* Map links */
    .btn-outline-primary, .btn-outline-success, .btn-outline-secondary {
        transition: all 0.2s ease;
    }

    .btn-outline-primary:hover, .btn-outline-success:hover, .btn-outline-secondary:hover {
        transform: translateY(-1px);
    }

    /* Mobile optimizations */
    @media (max-width: 768px) {
        .card-glass {
            padding: 1.25rem !important;
        }

        .btn-rounded {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .btn-lg {
            padding: 0.6rem 1.2rem;
            font-size: 0.875rem;
        }

        .timeline-item {
            margin-left: 12px;
            padding-left: 20px;
        }

        .timeline-icon {
            left: -14px;
        }

        .timeline-icon div {
            width: 28px;
            height: 28px;
        }

        .fs-5 {
            font-size: 1.1rem;
        }

        .fs-3 {
            font-size: 1.5rem;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-glass, .timeline-item {
        animation: fadeInUp 0.3s ease-out forwards;
    }

    /* Status badge animations */
    .badge i {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    /* Border styling */
    .border-start {
        border-left-width: 3px !important;
    }

    /* Responsive images */
    img {
        max-width: 100%;
        height: auto;
    }

    /* Focus states */
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
    }
</style>
@endsection
