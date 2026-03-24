{{-- resources/views/rider/orders/index.blade.php --}}
@extends('layouts.app')

@section('title', 'My Deliveries - MediSwift')

@section('header')
    <div>
        <h1 class="h2 fw-bold mb-1">My Deliveries</h1>
        <p class="text-muted mb-0">Manage and update your assigned orders</p>
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
                <h3 class="h4 fw-bold mb-0">{{ $orders->total() ?? 0 }}</h3>
                <p class="text-muted small mb-0">Total Orders</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex p-2 mb-2">
                    <i class="bi bi-clock-history fs-4 text-warning"></i>
                </div>
                <h3 class="h4 fw-bold mb-0">{{ $pendingOrders ?? 0 }}</h3>
                <p class="text-muted small mb-0">Pending Pickup</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="rounded-circle bg-info bg-opacity-10 d-inline-flex p-2 mb-2">
                    <i class="bi bi-truck fs-4 text-info"></i>
                </div>
                <h3 class="h4 fw-bold mb-0">{{ $inTransitOrders ?? 0 }}</h3>
                <p class="text-muted small mb-0">In Transit</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex p-2 mb-2">
                    <i class="bi bi-check-circle fs-4 text-success"></i>
                </div>
                <h3 class="h4 fw-bold mb-0">{{ $completedToday ?? 0 }}</h3>
                <p class="text-muted small mb-0">Completed Today</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card-glass p-3 p-md-4 mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold small">Search Order</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Tracking ID or recipient...">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label fw-semibold small">Status Filter</label>
                <select id="statusFilter" class="form-select">
                    <option value="">All Orders</option>
                    <option value="assigned">Assigned</option>
                    <option value="picked_up">Picked Up</option>
                    <option value="in_transit">In Transit</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <button id="resetFilters" class="btn btn-outline-secondary w-100 btn-rounded">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Orders Table (Desktop) -->
    <div class="card-glass overflow-hidden d-none d-lg-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="ordersTable">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 py-3 px-4">#</th>
                        <th class="border-0 py-3">Tracking ID</th>
                        <th class="border-0 py-3">Recipient</th>
                        <th class="border-0 py-3">Cost</th>
                        <th class="border-0 py-3">Status</th>
                        <th class="border-0 py-3">Payment</th>
                        <th class="border-0 py-3 text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr class="order-row" data-status="{{ $order->status }}" data-search="{{ strtolower($order->tracking_id . ' ' . $order->recipient_name) }}">
                        <td class="px-4 fw-semibold">{{ $order->id }}</td>
                        <td>
                            <span class="fw-semibold text-primary">{{ $order->tracking_id }}</span>
                        </td>
                        <td>
                            <div>
                                <div class="fw-semibold">{{ $order->recipient_name }}</div>
                                @if($order->recipient_phone)
                                    <div class="small text-muted">
                                        <i class="bi bi-telephone me-1"></i>{{ $order->recipient_phone }}
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="fw-semibold">₦{{ number_format($order->cost ?? 0, 2) }}</td>
                        <td>
                            <span class="badge rounded-pill px-3 py-2
                                @if($order->status == 'delivered') bg-success
                                @elseif($order->status == 'picked_up') bg-info
                                @elseif($order->status == 'in_transit') bg-primary
                                @elseif($order->status == 'assigned') bg-warning
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
                        </td>
                        <td>
                            @if($order->paid)
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> Paid
                                </span>
                                @if($order->paidBy)
                                    <div class="small text-muted mt-1">by {{ $order->paidBy->name }}</div>
                                @endif
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">
                                    <i class="bi bi-clock me-1"></i> Unpaid
                                </span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('rider.orders.show', $order) }}" class="btn btn-sm btn-primary rounded-pill">
                                    <i class="bi bi-eye me-1"></i> View
                                </a>
                                @if(!$order->paid && $order->status != 'delivered' && $order->status != 'cancelled')
                                    <form action="{{ route('rider.orders.mark_paid', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill" onclick="return confirm('Mark this order as paid?')">
                                            <i class="bi bi-credit-card me-1"></i> Mark Paid
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-0">No orders assigned to you yet</p>
                            <p class="small text-muted">Orders will appear here once assigned by an admin</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Cards View -->
    <div class="d-lg-none">
        <div class="row g-3" id="mobileOrdersContainer">
            @forelse($orders as $order)
            <div class="col-12 mobile-order-card" data-status="{{ $order->status }}" data-search="{{ strtolower($order->tracking_id . ' ' . $order->recipient_name) }}">
                <div class="card-glass p-3">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="fw-bold text-primary fs-5">{{ $order->tracking_id }}</span>
                            <div class="small text-muted">#{{ $order->id }}</div>
                        </div>
                        <span class="badge rounded-pill px-3 py-2
                            @if($order->status == 'delivered') bg-success
                            @elseif($order->status == 'picked_up') bg-info
                            @elseif($order->status == 'in_transit') bg-primary
                            @elseif($order->status == 'assigned') bg-warning
                            @elseif($order->status == 'cancelled') bg-danger
                            @else bg-secondary @endif">
                            {{ ucfirst(str_replace('_', ' ', $order->status ?? 'Unknown')) }}
                        </span>
                    </div>

                    <div class="mb-2">
                        <div class="fw-semibold">{{ $order->recipient_name }}</div>
                        @if($order->recipient_phone)
                            <div class="small text-muted">
                                <i class="bi bi-telephone"></i> {{ $order->recipient_phone }}
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Delivery Cost:</span>
                        <span class="fw-semibold">₦{{ number_format($order->cost ?? 0, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small">Payment Status:</span>
                        @if($order->paid)
                            <span class="text-success small">
                                <i class="bi bi-check-circle"></i> Paid
                                @if($order->paidBy) by {{ $order->paidBy->name }} @endif
                            </span>
                        @else
                            <span class="text-warning small">
                                <i class="bi bi-clock"></i> Unpaid
                            </span>
                        @endif
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('rider.orders.show', $order) }}" class="btn btn-sm btn-primary flex-grow-1 rounded-pill">
                            <i class="bi bi-eye me-1"></i> View Details
                        </a>
                        @if(!$order->paid && $order->status != 'delivered' && $order->status != 'cancelled')
                            <form action="{{ route('rider.orders.mark_paid', $order) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success w-100 rounded-pill" onclick="return confirm('Mark this order as paid?')">
                                    <i class="bi bi-credit-card me-1"></i> Mark Paid
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-2 mb-0">No orders assigned to you yet</p>
                    <p class="small text-muted">Orders will appear here once assigned by an admin</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const resetBtn = document.getElementById('resetFilters');

        function filterOrders() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;

            // Filter desktop table rows
            const rows = document.querySelectorAll('#ordersTable .order-row');
            rows.forEach(row => {
                let show = true;

                if (searchTerm && !row.dataset.search.includes(searchTerm)) {
                    show = false;
                }

                if (statusValue && row.dataset.status !== statusValue) {
                    show = false;
                }

                row.style.display = show ? '' : 'none';
            });

            // Filter mobile cards
            const cards = document.querySelectorAll('.mobile-order-card');
            cards.forEach(card => {
                let show = true;

                if (searchTerm && !card.dataset.search.includes(searchTerm)) {
                    show = false;
                }

                if (statusValue && card.dataset.status !== statusValue) {
                    show = false;
                }

                card.style.display = show ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterOrders);
        statusFilter.addEventListener('change', filterOrders);

        resetBtn.addEventListener('click', function() {
            searchInput.value = '';
            statusFilter.value = '';
            filterOrders();
        });

        // Add dataset attributes for search
        document.querySelectorAll('#ordersTable .order-row').forEach(row => {
            const trackingId = row.cells[1]?.innerText.trim() || '';
            const recipient = row.cells[2]?.innerText.trim() || '';
            row.dataset.search = (trackingId + ' ' + recipient).toLowerCase();
        });
    });
</script>
@endpush

<style>
    /* Additional styles for rider orders */
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

    .btn-rounded {
        border-radius: 2rem;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-rounded:hover {
        transform: translateY(-1px);
    }

    .table th {
        font-weight: 600;
        font-size: 0.875rem;
        color: var(--gray-800);
    }

    .table td {
        font-size: 0.875rem;
        vertical-align: middle;
    }

    .badge {
        font-weight: 500;
        font-size: 0.75rem;
    }

    .badge i {
        font-size: 0.7rem;
        vertical-align: middle;
    }

    /* Mobile optimizations */
    @media (max-width: 768px) {
        .btn-rounded {
            padding: 0.4rem 1rem;
            font-size: 0.8125rem;
        }

        .card-glass {
            border-radius: 1rem;
        }

        .btn-sm {
            font-size: 0.75rem;
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-glass, .order-row {
        animation: fadeIn 0.3s ease-out forwards;
    }

    /* Pagination styling */
    .pagination {
        justify-content: center;
    }

    .page-link {
        border-radius: 0.5rem;
        margin: 0 0.25rem;
        border: none;
        color: var(--primary);
        font-weight: 500;
    }

    .page-item.active .page-link {
        background: var(--primary);
        border-radius: 0.5rem;
    }

    .page-link:hover {
        background: var(--gray-100);
    }

    /* Status-specific styles */
    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }

    /* Button hover effects */
    .btn-primary, .btn-success {
        transition: all 0.2s ease;
    }

    .btn-primary:hover, .btn-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Empty state styling */
    .text-center i {
        opacity: 0.5;
    }
</style>
@endsection
