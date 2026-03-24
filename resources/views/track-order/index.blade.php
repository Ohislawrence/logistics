{{-- resources/views/guest/track.blade.php --}}
@extends('layouts.guest')

@section('title', 'Track Your Order - Aniquelogistics')

@section('content')
<div class="tracking-container py-5">
    <div class="container">
        <!-- Hero Section -->
        <div class="text-center mb-5">
            <div class="tracking-icon-wrapper mb-4">
                <div class="d-inline-flex p-2" style="width:120px;height:120px;align-items:center;justify-content:center;">
                    <img src="{{ asset('images/test.gif') }}" alt="Bike moving" style="width:120px;height:120px;object-fit:cover;border-radius:50%;" />
                </div>
            </div>
            <h1 class="display-5 fw-bold mb-3">Track Your Order</h1>
            <p class="lead text-muted">Enter your tracking ID to get real-time delivery status</p>
        </div>

        <!-- Tracking Form Card -->
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-lg-8">
                <div class="tracking-card glass-card p-4 p-md-5">
                    <form method="GET" action="{{ route('track.order') }}" id="trackingForm">
                        {{-- Honeypot field (should remain empty) --}}
                        <input type="text" name="hp_name" value="" aria-hidden="true" style="display: none;">
                        {{-- Timestamp to ensure human users don't submit too fast --}}
                        <input type="hidden" name="hp_time" value="{{ now()->timestamp }}">

                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-upc-scan text-primary"></i>
                            </span>
                            <input type="text"
                                   name="tracking_id"
                                   class="form-control border-start-0 ps-0 tracking-input"
                                   placeholder="Enter tracking ID (e.g., MED-12345)"
                                   value="{{ request('tracking_id') }}"
                                   required
                                   autocomplete="off">
                            <button class="btn btn-primary btn-track" type="submit">
                                <i class="bi bi-arrow-right me-1"></i> Track
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Tracking ID format: MED-XXXXX or as provided in your confirmation
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loadingState" class="text-center d-none">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted mt-2">Fetching order details...</p>
        </div>

        <!-- Error Message -->
        @if(request()->filled('tracking_id') && empty($order))
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="alert alert-warning alert-modern d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                        <div>
                            <strong>Order Not Found</strong><br>
                            No order found for tracking ID: <strong>{{ request('tracking_id') }}</strong>. Please check the ID and try again.
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Order Details -->
        @if($order)
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <!-- Status Timeline -->
                    <div class="glass-card p-4 p-md-5 mb-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-diagram-3 me-2 text-primary"></i>Delivery Progress
                        </h5>

                        @php
                            $statusOrder = ['pending', 'assigned', 'collected', 'in_transit', 'delivered'];
                            $currentStatusIndex = array_search($order->status, $statusOrder);
                            $statusLabels = [
                                'pending' => 'Order Placed',
                                'assigned' => 'Assigned to Rider',
                                'collected' => 'Picked Up',
                                'in_transit' => 'In Transit',
                                'delivered' => 'Delivered'
                            ];
                        @endphp

                        <div class="timeline-progress">
                            <div class="progress-track">
                                <div class="progress-fill" style="width: {{ ($currentStatusIndex / (count($statusOrder) - 1)) * 100 }}%"></div>
                            </div>
                            <div class="timeline-steps">
                                @foreach($statusOrder as $index => $status)
                                    <div class="timeline-step {{ $index <= $currentStatusIndex ? 'completed' : '' }} {{ $index == $currentStatusIndex ? 'active' : '' }}">
                                        <div class="step-icon">
                                            @if($index < $currentStatusIndex)
                                                <i class="bi bi-check-lg"></i>
                                            @elseif($index == $currentStatusIndex)
                                                <i class="bi bi-{{ $status == 'delivered' ? 'check-lg' : ($status == 'collected' ? 'box-seam' : ($status == 'in_transit' ? 'truck' : 'clock')) }}"></i>
                                            @else
                                                <i class="bi bi-{{ $status == 'delivered' ? 'check-lg' : ($status == 'collected' ? 'box-seam' : ($status == 'in_transit' ? 'truck' : 'clock')) }}"></i>
                                            @endif
                                        </div>
                                        <div class="step-label">{{ $statusLabels[$status] ?? ucfirst($status) }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Order Information Card -->
                    <div class="glass-card p-4 p-md-5 mb-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-receipt me-2 text-primary"></i>Order Details
                            </h5>
                            <span class="badge status-badge
                                @if($order->status == 'delivered') bg-success
                                @elseif($order->status == 'in_transit') bg-info
                                @elseif($order->status == 'collected') bg-primary
                                @elseif($order->status == 'assigned') bg-warning
                                @else bg-secondary @endif
                                rounded-pill px-3 py-2">
                                <i class="bi
                                    @if($order->status == 'delivered') bi-check-circle
                                    @elseif($order->status == 'in_transit') bi-truck
                                    @elseif($order->status == 'collected') bi-box-seam
                                    @elseif($order->status == 'assigned') bi-person-check
                                    @else bi-clock @endif me-1">
                                </i>
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </div>

                        <div class="row g-4">
                            <div class="col-12 col-md-6">
                                <div class="info-section">
                                    <div class="info-label">
                                        <i class="bi bi-upc-scan text-muted"></i> Tracking ID
                                    </div>
                                    <div class="info-value fw-semibold fs-5">{{ $order->tracking_id }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="info-section">
                                    <div class="info-label">
                                        <i class="bi bi-calendar3 text-muted"></i> Order Date
                                    </div>
                                    <div class="info-value">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="info-section">
                                    <div class="info-label">
                                        <i class="bi bi-person text-muted"></i> Recipient
                                    </div>
                                    <div class="info-value">{{ $order->recipient_name }}</div>
                                    @if($order->recipient_phone)
                                        <div class="info-small text-muted">
                                            <i class="bi bi-telephone"></i> {{ $order->recipient_phone }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="info-section">
                                    <div class="info-label">
                                        <i class="bi bi-cash-stack text-muted"></i> Delivery Cost
                                    </div>
                                    <div class="info-value fw-bold text-primary fs-4">₦{{ number_format($order->cost ?? 0, 2) }}</div>
                                    @if($order->paid)
                                        <span class="badge bg-success bg-opacity-10 text-success mt-1">Paid</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning mt-1">Pending Payment</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="row g-4 mb-4">
                        <div class="col-12 col-md-6">
                            <div class="glass-card p-4 h-100">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-shop me-2 text-primary"></i>Pickup Address
                                </h6>
                                <p class="mb-2">{{ $order->pickup_address ?? 'Not specified' }}</p>
                                @if($order->pickup_address)
                                    <a href="https://maps.google.com/?q={{ urlencode($order->pickup_address) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill mt-2">
                                        <i class="bi bi-map me-1"></i> View on Map
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="glass-card p-4 h-100">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-house-door me-2 text-primary"></i>Delivery Address
                                </h6>
                                <p class="mb-2">{{ $order->delivery_address ?? 'Not specified' }}</p>
                                @if($order->delivery_address)
                                    <a href="https://maps.google.com/?q={{ urlencode($order->delivery_address) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill mt-2">
                                        <i class="bi bi-map me-1"></i> View on Map
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Rider Information -->
                    @if($order->assignedTo)
                        <div class="glass-card p-4 mb-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-bicycle me-2 text-primary"></i>Assigned Rider
                            </h6>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rider-avatar rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                                    <span class="fw-bold text-primary fs-5">{{ substr($order->assignedTo->name, 0, 2) }}</span>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $order->assignedTo->name }}</div>
                                    <div class="small text-muted">Your delivery partner</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Progress Timeline -->
                    @if($order->progresses && $order->progresses->count() > 0)
                        <div class="glass-card p-4 p-md-5">
                            <h5 class="fw-bold mb-4">
                                <i class="bi bi-clock-history me-2 text-primary"></i>Activity Timeline
                            </h5>
                            <div class="timeline-list">
                                @foreach($order->progresses()->where('status', '!=', 'paid')->latest()->get() as $p)
                                    <div class="timeline-list-item">
                                        <div class="timeline-list-icon
                                            @if($p->status == 'delivered') bg-success
                                            @elseif($p->status == 'cancelled') bg-danger
                                            @else bg-primary @endif">
                                            <i class="bi
                                                @if($p->status == 'delivered') bi-check-lg
                                                @elseif($p->status == 'collected') bi-box-seam
                                                @elseif($p->status == 'in_transit') bi-truck
                                                @elseif($p->status == 'assigned') bi-person-check
                                                @elseif($p->status == 'cancelled') bi-x-lg
                                                @else bi-clock @endif text-white">
                                            </i>
                                        </div>
                                        <div class="timeline-list-content">
                                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                                <div>
                                                    <strong class="text-dark">{{ ucfirst(str_replace('_', ' ', $p->status)) }}</strong>
                                                    @if($p->notes)
                                                        <div class="small text-muted mt-1">{{ $p->notes }}</div>
                                                    @endif
                                                </div>
                                                <small class="text-muted">{{ $p->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="small text-muted mt-1">
                                                <i class="bi bi-calendar3 me-1"></i>{{ $p->created_at->format('M d, Y h:i A') }}
                                                @if($p->reporter)
                                                    <span class="mx-1">•</span>
                                                    <i class="bi bi-person me-1"></i>{{ $p->reporter->name }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Notes Section -->
                    @if($order->notes)
                        <div class="glass-card p-4 mt-4">
                            <h6 class="fw-bold mb-2">
                                <i class="bi bi-chat-text me-2 text-primary"></i>Additional Notes
                            </h6>
                            <p class="mb-0 text-muted">{{ $order->notes }}</p>
                        </div>
                    @endif

                    <!-- Need Help Section -->
                    <div class="text-center mt-4">
                        <div class="help-section p-4">
                            <i class="bi bi-question-circle fs-2 text-primary mb-2 d-block"></i>
                            <h6 class="fw-bold">Need Help?</h6>
                            <p class="small text-muted mb-2">Contact our support team for assistance with your order</p>
                            <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-envelope me-1"></i> Support Center
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('trackingForm');
        const loadingState = document.getElementById('loadingState');
        const trackingInput = document.querySelector('.tracking-input');

        // Show loading state on form submit
        if (form) {
            form.addEventListener('submit', function() {
                loadingState.classList.remove('d-none');
                // Disable submit button to prevent double submission
                const submitBtn = form.querySelector('.btn-track');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Tracking...';
                }
            });
        }

        // Auto-format tracking ID input (uppercase)
        if (trackingInput) {
            trackingInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });

            // Remove any leading/trailing spaces
            trackingInput.addEventListener('blur', function() {
                this.value = this.value.trim();
            });
        }

        // Smooth scroll to results if order exists
        @if($order)
            setTimeout(function() {
                document.querySelector('.glass-card')?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 300);
        @endif
    });
</script>
@endpush

<style>
    /* Tracking Page Styles */
    .tracking-container {
        min-height: 80vh;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border-radius: 1.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .glass-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1);
    }

    .tracking-card {
        background: white;
        border-radius: 2rem;
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.1);
    }

    .tracking-icon-wrapper .rounded-circle {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.3);
    }

    .tracking-input {
        font-size: 1.1rem;
        padding: 0.75rem 1rem;
    }

    .tracking-input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
    }

    .btn-track {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 2rem;
        transition: all 0.3s ease;
    }

    .btn-track:hover {
        transform: translateX(3px);
        background-color: #0b5ed7;
    }

    /* Timeline Progress */
    .timeline-progress {
        position: relative;
        padding: 1rem 0;
    }

    .progress-track {
        position: relative;
        height: 4px;
        background: #e9ecef;
        border-radius: 2px;
        margin: 2rem 0;
    }

    .progress-fill {
        position: absolute;
        height: 100%;
        background: linear-gradient(90deg, #0d6efd, #0a58ca);
        border-radius: 2px;
        transition: width 0.5s ease;
    }

    .timeline-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-top: -1.5rem;
    }

    .timeline-step {
        text-align: center;
        flex: 1;
    }

    .step-icon {
        width: 40px;
        height: 40px;
        background: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.5rem;
        transition: all 0.3s ease;
        color: #6c757d;
    }

    .timeline-step.completed .step-icon {
        background: #0d6efd;
        color: white;
    }

    .timeline-step.active .step-icon {
        background: #0d6efd;
        color: white;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2);
        animation: pulse 2s infinite;
    }

    .step-label {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 500;
    }

    .timeline-step.completed .step-label,
    .timeline-step.active .step-label {
        color: #0d6efd;
        font-weight: 600;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(13, 110, 253, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
        }
    }

    /* Info Sections */
    .info-section {
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 1rem;
        transition: all 0.3s ease;
    }

    .info-section:hover {
        background: #f1f3f5;
    }

    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        color: #6c757d;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-size: 1rem;
        color: #212529;
    }

    .info-small {
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    /* Timeline List */
    .timeline-list {
        position: relative;
        padding-left: 1.5rem;
    }

    .timeline-list-item {
        position: relative;
        padding-bottom: 1.5rem;
        border-left: 2px solid #e9ecef;
        padding-left: 1.5rem;
        margin-left: 0.5rem;
    }

    .timeline-list-item:last-child {
        border-left-color: transparent;
        padding-bottom: 0;
    }

    .timeline-list-icon {
        position: absolute;
        left: -0.9rem;
        top: 0;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .timeline-list-content {
        padding-bottom: 0.5rem;
    }

    /* Rider Avatar */
    .rider-avatar {
        width: 60px;
        height: 60px;
    }

    /* Status Badge */
    .status-badge {
        font-size: 0.875rem;
        font-weight: 600;
    }

    /* Alert Modern */
    .alert-modern {
        border: none;
        border-radius: 1rem;
        background: #fff3cd;
        border-left: 4px solid #ffc107;
    }

    /* Help Section */
    .help-section {
        background: white;
        border-radius: 1.5rem;
        padding: 1.5rem;
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.05);
    }

    /* Mobile Optimizations */
    @media (max-width: 768px) {
        .timeline-steps {
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }

        .timeline-step {
            flex: 0 0 auto;
            min-width: 80px;
        }

        .progress-track {
            display: none;
        }

        .step-icon {
            width: 35px;
            height: 35px;
        }

        .step-label {
            font-size: 0.65rem;
        }

        .glass-card {
            padding: 1.25rem !important;
        }

        .btn-track {
            padding: 0.6rem 1rem;
        }

        .tracking-input {
            font-size: 1rem;
        }

        .display-5 {
            font-size: 1.75rem;
        }
    }

    /* Animation for order details */
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

    .glass-card {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    /* Input group styling */
    .input-group-text {
        border-radius: 2rem 0 0 2rem;
    }

    .tracking-input {
        border-radius: 0;
    }

    .btn-track {
        border-radius: 0 2rem 2rem 0;
    }

    /* Loading spinner */
    .spinner-border {
        width: 1.2rem;
        height: 1.2rem;
    }
</style>
@endsection
