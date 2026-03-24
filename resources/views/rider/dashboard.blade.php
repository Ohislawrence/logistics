{{-- resources/views/rider/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Rider Dashboard - MediSwift')

@section('header')
    <div>
        <h1 class="h2 fw-bold mb-1">Welcome back, {{ Auth::user()->name ?? 'Rider' }}!</h1>
        <p class="text-muted mb-0">Here's your delivery overview and recent assignments</p>
    </div>
@endsection

@section('content')
<div class="py-3 py-md-4">
    <!-- Stats Overview Cards -->
    <div class="row g-3 g-md-4 mb-4">
        <div class="col-6 col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex p-2 mb-2">
                    <i class="bi bi-box-seam fs-4 text-primary"></i>
                </div>
                <h3 class="h4 fw-bold mb-0">{{ $assignedCount ?? 0 }}</h3>
                <p class="text-muted small mb-0">Active Orders</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex p-2 mb-2">
                    <i class="bi bi-clock-history fs-4 text-warning"></i>
                </div>
                <h3 class="h4 fw-bold mb-0">{{ $pendingPickup ?? 0 }}</h3>
                <p class="text-muted small mb-0">Pending Pickup</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="rounded-circle bg-info bg-opacity-10 d-inline-flex p-2 mb-2">
                    <i class="bi bi-truck fs-4 text-info"></i>
                </div>
                <h3 class="h4 fw-bold mb-0">{{ $inTransit ?? 0 }}</h3>
                <p class="text-muted small mb-0">In Transit</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex p-2 mb-2">
                    <i class="bi bi-currency-dollar fs-4 text-success"></i>
                </div>
                <h3 class="h4 fw-bold mb-0">₦{{ number_format($todayEarnings ?? 0, 0) }}</h3>
                <p class="text-muted small mb-0">Today's Earnings</p>
            </div>
        </div>
    </div>

    <!-- Welcome & Quick Actions -->
    <div class="row g-3 g-md-4 mb-4">
        <div class="col-12 col-lg-8">
            <div class="card-glass p-4 p-md-5 bg-gradient-primary text-white" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h2 class="h3 fw-bold mb-2">Ready for deliveries?</h2>
                        <p class="mb-0 opacity-75">Check your assigned orders and start delivering</p>
                    </div>
                    <a href="{{ route('rider.orders.index') }}" class="btn btn-light btn-rounded px-4">
                        <i class="bi bi-arrow-right me-1"></i> View All Orders
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card-glass p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0">Today's Progress</h6>
                    <span class="badge bg-primary rounded-pill">{{ $completedToday ?? 0 }}/{{ $assignedCount ?? 0 }}</span>
                </div>
                <div class="progress mb-3" style="height: 8px;">
                    @php
                        $progressPercentage = ($assignedCount > 0) ? (($completedToday ?? 0) / $assignedCount) * 100 : 0;
                    @endphp
                    <div class="progress-bar bg-success" style="width: {{ $progressPercentage }}%"></div>
                </div>
                <div class="d-flex justify-content-between small text-muted">
                    <span><i class="bi bi-check-circle"></i> {{ $completedToday ?? 0 }} completed</span>
                    <span><i class="bi bi-clock"></i> {{ ($assignedCount ?? 0) - ($completedToday ?? 0) }} remaining</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Assigned Orders -->
    <div class="card-glass p-0 overflow-hidden">
        <div class="d-flex justify-content-between align-items-center p-3 p-md-4 border-bottom">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-clock-history me-2 text-primary"></i>Recent Assigned Orders
            </h5>
            @if(($recentAssigned->count() ?? 0) > 0)
                <a href="{{ route('rider.orders.index') }}" class="text-decoration-none small fw-semibold">
                    View all <i class="bi bi-arrow-right-short"></i>
                </a>
            @endif
        </div>

        @if(isset($recentAssigned) && $recentAssigned->count() > 0)
            <div class="list-group list-group-flush">
                @foreach($recentAssigned as $o)
                    <div class="list-group-item border-0 py-3 px-3 px-md-4 hover-bg-light transition">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div class="d-flex align-items-center gap-3 flex-grow-1">
                                <div class="rounded-circle
                                    @if($o->status == 'delivered') bg-success bg-opacity-10
                                    @elseif($o->status == 'in_transit') bg-info bg-opacity-10
                                    @elseif($o->status == 'collected') bg-primary bg-opacity-10
                                    @else bg-warning bg-opacity-10 @endif
                                    p-2" style="width: 48px; height: 48px;">
                                    <i class="bi
                                        @if($o->status == 'delivered') bi-check-circle text-success
                                        @elseif($o->status == 'in_transit') bi-truck text-info
                                        @elseif($o->status == 'collected') bi-box-seam text-primary
                                        @else bi-clock-history text-warning @endif
                                        fs-5">
                                    </i>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <strong class="text-dark">{{ $o->tracking_id ?? 'N/A' }}</strong>
                                        <span class="badge rounded-pill px-2 py-1 fs-7
                                            @if($o->status == 'delivered') bg-success bg-opacity-10 text-success
                                            @elseif($o->status == 'in_transit') bg-info bg-opacity-10 text-info
                                            @elseif($o->status == 'collected') bg-primary bg-opacity-10 text-primary
                                            @elseif($o->status == 'assigned') bg-warning bg-opacity-10 text-warning
                                            @else bg-secondary bg-opacity-10 text-secondary @endif">
                                            {{ ucfirst(str_replace('_', ' ', $o->status ?? 'Unknown')) }}
                                        </span>
                                    </div>
                                    <div class="text-muted small mt-1">
                                        <i class="bi bi-person me-1"></i>{{ $o->recipient_name ?? 'N/A' }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="bi bi-geo-alt me-1"></i>{{ Str::limit($o->pickup_address ?? '', 30) }} → {{ Str::limit($o->delivery_address ?? '', 30) }}
                                    </div>
                                    <div class="d-flex gap-3 mt-1">
                                        <div class="small">
                                            <i class="bi bi-cash-stack me-1"></i>₦{{ number_format($o->cost ?? 0, 2) }}
                                        </div>
                                        @if(isset($o->distance))
                                        <div class="small">
                                            <i class="bi bi-signpost me-1"></i>{{ number_format($o->distance, 1) }} km
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('rider.orders.show', $o->id) }}" class="btn btn-sm btn-primary rounded-pill">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                @if($o->status == 'assigned')
                                    <a href="{{ route('rider.orders.show', $o->id) }}#update-status" class="btn btn-sm btn-outline-success rounded-pill">
                                        <i class="bi bi-play-circle"></i> Start
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-2 mb-0">No orders assigned to you yet</p>
                <p class="small text-muted">Orders will appear here once assigned by an admin</p>
                <a href="{{ route('rider.orders.index') }}" class="btn btn-sm btn-outline-primary mt-3 rounded-pill">
                    <i class="bi bi-arrow-repeat me-1"></i> Refresh
                </a>
            </div>
        @endif
    </div>

    <!-- Performance & Tips Section -->
    <div class="row g-3 g-md-4 mt-2">
        <div class="col-12 col-md-6">
            <div class="card-glass p-4">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-star me-2 text-warning"></i>Your Performance
                </h6>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small text-muted">Completion Rate</span>
                        <span class="small fw-semibold">{{ $completionRate ?? 94 }}%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: {{ $completionRate ?? 94 }}%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small text-muted">On-Time Delivery</span>
                        <span class="small fw-semibold">{{ $onTimeRate ?? 87 }}%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: {{ $onTimeRate ?? 87 }}%"></div>
                    </div>
                </div>
                <div class="d-flex justify-content-between pt-2 border-top">
                    <div>
                        <div class="small text-muted">Total Deliveries</div>
                        <div class="fw-bold">{{ $totalDeliveries ?? 0 }}</div>
                    </div>
                    <div>
                        <div class="small text-muted">This Week</div>
                        <div class="fw-bold">{{ $weeklyDeliveries ?? 0 }}</div>
                    </div>
                    <div>
                        <div class="small text-muted">Rating</div>
                        <div class="fw-bold text-warning">
                            <i class="bi bi-star-fill"></i> {{ number_format($rating ?? 4.8, 1) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card-glass p-4">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-lightbulb me-2 text-primary"></i>Rider Tips
                </h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2 d-flex gap-2">
                        <i class="bi bi-check-circle-fill text-success mt-1"></i>
                        <span>Always confirm the pickup address before leaving</span>
                    </li>
                    <li class="mb-2 d-flex gap-2">
                        <i class="bi bi-check-circle-fill text-success mt-1"></i>
                        <span>Contact the recipient before arrival to ensure they're available</span>
                    </li>
                    <li class="mb-2 d-flex gap-2">
                        <i class="bi bi-check-circle-fill text-success mt-1"></i>
                        <span>Update status promptly for accurate tracking</span>
                    </li>
                    <li class="mb-2 d-flex gap-2">
                        <i class="bi bi-check-circle-fill text-success mt-1"></i>
                        <span>Collect payment upon delivery when applicable</span>
                    </li>
                    <li class="d-flex gap-2">
                        <i class="bi bi-check-circle-fill text-success mt-1"></i>
                        <span>Rate your delivery experience to help improve the service</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-refresh active orders count every 30 seconds (optional)
        setInterval(function() {
            fetch(window.location.href)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newCount = doc.querySelector('.card-glass .h4.fw-bold')?.innerText;
                    if (newCount) {
                        const currentCount = document.querySelector('.card-glass .h4.fw-bold')?.innerText;
                        if (currentCount !== newCount) {
                            location.reload();
                        }
                    }
                })
                .catch(() => {});
        }, 30000);

        // Add hover animation to cards
        const cards = document.querySelectorAll('.card-glass');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endpush

<style>
    /* Additional styles for rider dashboard */
    .card-glass {
        background: white;
        border: none;
        border-radius: 1.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-glass:hover {
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.08);
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }

    .btn-rounded {
        border-radius: 2rem;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-rounded:hover {
        transform: translateY(-1px);
    }

    .hover-bg-light:hover {
        background-color: var(--gray-100);
        transition: all 0.2s ease;
    }

    .transition {
        transition: all 0.2s ease;
    }

    .fs-7 {
        font-size: 0.7rem;
    }

    /* Progress bar styling */
    .progress {
        border-radius: 1rem;
        background-color: var(--gray-200);
    }

    .progress-bar {
        border-radius: 1rem;
        transition: width 0.3s ease;
    }

    /* Stats cards */
    .rounded-circle.bg-opacity-10 {
        transition: transform 0.2s ease;
    }

    .card-glass:hover .rounded-circle.bg-opacity-10 {
        transform: scale(1.05);
    }

    /* Mobile optimizations */
    @media (max-width: 768px) {
        .card-glass {
            border-radius: 1rem;
        }

        .btn-rounded {
            padding: 0.4rem 1rem;
            font-size: 0.875rem;
        }

        .h2 {
            font-size: 1.5rem;
        }

        .h3 {
            font-size: 1.25rem;
        }

        .h4 {
            font-size: 1.1rem;
        }

        .list-group-item {
            padding: 1rem;
        }

        .bg-gradient-primary {
            text-align: center;
        }
    }

    /* Animation */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-glass {
        animation: slideInUp 0.4s ease-out forwards;
    }

    .card-glass:nth-child(1) { animation-delay: 0.05s; }
    .card-glass:nth-child(2) { animation-delay: 0.1s; }
    .card-glass:nth-child(3) { animation-delay: 0.15s; }
    .card-glass:nth-child(4) { animation-delay: 0.2s; }

    /* List group hover effects */
    .list-group-item {
        transition: all 0.2s ease;
    }

    /* Badge animations */
    .badge {
        transition: all 0.2s ease;
    }

    /* Icon styling */
    .bi {
        vertical-align: middle;
    }

    /* Empty state */
    .text-center i {
        opacity: 0.5;
    }
</style>
@endsection
