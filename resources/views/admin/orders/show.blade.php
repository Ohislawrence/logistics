{{-- resources/views/admin/orders/show.blade.php --}}
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
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-rounded">
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
                        @elseif($order->status == 'picked_up') bg-info
                        @elseif($order->status == 'in_transit') bg-primary
                        @elseif($order->status == 'assigned') bg-warning
                        @elseif($order->status == 'pending') bg-secondary
                        @elseif($order->status == 'cancelled') bg-danger
                        @else bg-secondary @endif">
                        <i class="bi
                            @if($order->status == 'delivered') bi-check-circle
                            @elseif($order->status == 'picked_up') bi-box-seam
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
                        <div class="ps-3">
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
                                <div class="small text-muted mt-1">
                                    Paid by {{ $order->paidBy->name }}<br>
                                    {{ $order->paid_at ? $order->paid_at->format('M d, Y H:i') : '' }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Assigned Rider -->
                    <div class="col-12">
                        <div class="ps-3">
                            <h6 class="text-muted mb-2 small text-uppercase">
                                <i class="bi bi-bicycle me-1"></i>Assigned Rider
                            </h6>
                            @if($order->assignedTo)
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="avatar-circle-small bg-light d-inline-flex align-items-center justify-content-center rounded-circle">
                                        <span class="small fw-semibold">{{ substr($order->assignedTo->name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $order->assignedTo->name }}</div>
                                        <div class="small text-muted">{{ $order->assignedTo->email }}</div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">Not assigned yet</span>
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

                    <!-- Order Metadata -->
                    <div class="col-12">
                        <div class="ps-3">
                            <h6 class="text-muted mb-2 small text-uppercase">
                                <i class="bi bi-calendar me-1"></i>Order Details
                            </h6>
                            <div class="row g-2 small">
                                <div class="col-md-6">
                                    <strong>Created:</strong> {{ $order->created_at->format('M d, Y H:i') }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Last Updated:</strong> {{ $order->updated_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Actions Card -->
            <div class="card-glass p-4 p-md-5 mb-4">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-tools me-2 text-primary"></i>Admin Actions
                </h5>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary w-100 rounded-pill">
                            <i class="bi bi-pencil me-2"></i> Edit Order
                        </a>
                    </div>

                    @if(!$order->paid)
                        <div class="col-12 col-md-6">
                            <form action="{{ route('admin.orders.mark_paid', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 rounded-pill" onclick="return confirm('Mark this order as paid?')">
                                    <i class="bi bi-credit-card me-2"></i> Mark as Paid
                                </button>
                            </form>
                        </div>
                    @endif

                    @if(!$order->assignedTo && $order->status == 'pending')
                        <div class="col-12">
                            <button class="btn btn-warning w-100 rounded-pill" data-bs-toggle="modal" data-bs-target="#assignRiderModal">
                                <i class="bi bi-person-plus me-2"></i> Assign Rider
                            </button>
                        </div>
                    @endif

                    @if($order->status != 'delivered' && $order->status != 'cancelled')
                        <div class="col-12">
                            <button class="btn btn-outline-danger w-100 rounded-pill" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                                <i class="bi bi-x-circle me-2"></i> Cancel Order
                            </button>
                        </div>
                    @endif
                </div>
            </div>
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
                                                @elseif($p->status == 'picked_up') bi-box-seam
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
                    <i class="bi bi-lightning me-2 text-primary"></i>Quick Links
                </h5>

                <div class="d-grid gap-2">
                    <a href="{{ url('track-order?tracking_id=' . $order->tracking_id) }}" target="_blank" class="btn btn-outline-primary rounded-pill">
                        <i class="bi bi-globe me-2"></i> View Public Tracking
                    </a>

                    @if($order->pickup_address)
                        <a href="https://maps.google.com/?q={{ urlencode($order->pickup_address) }}" target="_blank" class="btn btn-outline-secondary rounded-pill">
                            <i class="bi bi-geo-alt me-2"></i> Pickup Location
                        </a>
                    @endif

                    @if($order->delivery_address)
                        <a href="https://maps.google.com/?q={{ urlencode($order->delivery_address) }}" target="_blank" class="btn btn-outline-secondary rounded-pill">
                            <i class="bi bi-house-door me-2"></i> Delivery Location
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

<!-- Assign Rider Modal -->
@if(!$order->assignedTo)
<div class="modal fade" id="assignRiderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Assign Rider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.orders.assign', $order) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label class="form-label fw-semibold">Select Rider</label>
                    <select name="rider_id" class="form-select form-select-lg" required>
                        <option value="">Choose a rider...</option>
                        @foreach(\App\Models\User::role('rider')->get() as $rider)
                            <option value="{{ $rider->id }}">{{ $rider->name }} - {{ $rider->email }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4">
                        <i class="bi bi-person-check me-1"></i> Assign
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-0">
                <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex p-3 mb-3">
                    <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>
                </div>
                <h5 class="fw-bold mb-2">Cancel Order</h5>
                <p class="text-muted mb-4">
                    Are you sure you want to cancel order <strong>{{ $order->tracking_id }}</strong>?<br>
                    This action cannot be undone easily.
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" class="btn btn-light btn-rounded px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> No, Keep It
                    </button>
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="cancelled">
                        <input type="hidden" name="recipient_name" value="{{ $order->recipient_name }}">
                        <input type="hidden" name="delivery_address" value="{{ $order->delivery_address }}">
                        <input type="hidden" name="pickup_address" value="{{ $order->pickup_address }}">
                        <input type="hidden" name="cost" value="{{ $order->cost }}">
                        <button type="submit" class="btn btn-danger btn-rounded px-4">
                            <i class="bi bi-x-circle me-1"></i> Yes, Cancel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Additional styles for admin order details */
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

    .avatar-circle-small {
        width: 40px;
        height: 40px;
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

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .btn-rounded {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
    }
</style>
@endpush
@endsection
