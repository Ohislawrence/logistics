{{-- resources/views/admin/orders/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Orders Management - MediSwift')

@section('header')
    <div>
        <h1 class="h2 fw-bold mb-1">Orders Management</h1>
        <p class="text-muted mb-0">Manage and track all delivery orders</p>
    </div>
    <div class="mt-3 mt-sm-0">
        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary btn-rounded">
            <i class="bi bi-plus-circle me-1"></i> Create Order
        </a>
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
                <p class="text-muted small mb-0">Pending</p>
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
                <h3 class="h4 fw-bold mb-0">{{ $deliveredOrders ?? 0 }}</h3>
                <p class="text-muted small mb-0">Delivered</p>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card-glass p-3 p-md-4 mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold small">Search</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Tracking ID, recipient...">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label fw-semibold small">Status Filter</label>
                <select id="statusFilter" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="assigned">Assigned</option>
                    <option value="picked_up">Picked Up</option>
                    <option value="in_transit">In Transit</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label fw-semibold small">Payment Status</label>
                <select id="paymentFilter" class="form-select">
                    <option value="">All</option>
                    <option value="paid">Paid</option>
                    <option value="unpaid">Unpaid</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
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
                        <th class="border-0 py-3">Assigned To</th>
                        <th class="border-0 py-3">Status</th>
                        <th class="border-0 py-3">Payment</th>
                        <th class="border-0 py-3 text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr class="order-row" data-status="{{ $order->status }}" data-paid="{{ $order->paid ? 'paid' : 'unpaid' }}" data-search="{{ strtolower($order->tracking_id . ' ' . $order->recipient_name . ' ' . ($order->recipient_phone ?? '')) }}">
                        <td class="px-4 fw-semibold">{{ $order->id }}</td>
                        <td>
                            <span class="fw-semibold text-primary">{{ $order->tracking_id }}</span>
                        </td>
                        <td>
                            <div>{{ $order->recipient_name }}</div>
                            @if($order->recipient_phone)
                                <small class="text-muted">{{ $order->recipient_phone }}</small>
                            @endif
                        </td>
                        <td class="fw-semibold">₦{{ number_format($order->cost ?? 0, 2) }}</td>
                        <td>
                            @if($order->assignedTo)
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle-small bg-light d-inline-flex align-items-center justify-content-center rounded-circle">
                                        <span class="small">{{ substr($order->assignedTo->name, 0, 2) }}</span>
                                    </div>
                                    <span>{{ $order->assignedTo->name }}</span>
                                </div>
                            @else
                                <span class="text-muted">Unassigned</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge rounded-pill px-3 py-2
                                @if($order->status == 'delivered') bg-success
                                @elseif($order->status == 'pending') bg-warning
                                @elseif($order->status == 'cancelled') bg-danger
                                @elseif($order->status == 'in_transit') bg-info
                                @else bg-secondary @endif">
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
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-info rounded-pill">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @if(!$order->paid)
                                            <li>
                                                <form action="{{ route('admin.orders.mark_paid', $order) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item" onclick="return confirm('Mark order as paid?')">
                                                        <i class="bi bi-credit-card me-2"></i> Mark as Paid
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        <li>
                                            <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $order->id }}">
                                                <i class="bi bi-trash me-2"></i> Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-0">No orders found</p>
                            <a href="{{ route('admin.orders.create') }}" class="btn btn-sm btn-primary mt-3">Create your first order</a>
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
            <div class="col-12 mobile-order-card" data-status="{{ $order->status }}" data-paid="{{ $order->paid ? 'paid' : 'unpaid' }}" data-search="{{ strtolower($order->tracking_id . ' ' . $order->recipient_name . ' ' . ($order->recipient_phone ?? '')) }}">
                <div class="card-glass p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <span class="fw-bold text-primary">{{ $order->tracking_id }}</span>
                            <div class="small text-muted">#{{ $order->id }}</div>
                        </div>
                        <span class="badge rounded-pill px-3 py-2
                            @if($order->status == 'delivered') bg-success
                            @elseif($order->status == 'pending') bg-warning
                            @elseif($order->status == 'cancelled') bg-danger
                            @elseif($order->status == 'in_transit') bg-info
                            @else bg-secondary @endif">
                            {{ ucfirst(str_replace('_', ' ', $order->status ?? 'Unknown')) }}
                        </span>
                    </div>

                    <div class="mb-2">
                        <div class="fw-semibold">{{ $order->recipient_name }}</div>
                        @if($order->recipient_phone)
                            <div class="small text-muted"><i class="bi bi-telephone"></i> {{ $order->recipient_phone }}</div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Cost:</span>
                        <span class="fw-semibold">₦{{ number_format($order->cost ?? 0, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small">Rider:</span>
                        <span>{{ $order->assignedTo->name ?? 'Unassigned' }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small">Payment:</span>
                        @if($order->paid)
                            <span class="text-success"><i class="bi bi-check-circle"></i> Paid</span>
                        @else
                            <span class="text-warning"><i class="bi bi-clock"></i> Unpaid</span>
                        @endif
                    </div>

                    <div class="d-flex gap-2 mb-2">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-info flex-grow-1 rounded-pill">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-outline-primary flex-grow-1 rounded-pill">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button class="btn btn-sm btn-outline-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $order->id }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>

                    @if(!$order->paid)
                        <form action="{{ route('admin.orders.mark_paid', $order) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success w-100 rounded-pill" onclick="return confirm('Mark order as paid?')">
                                <i class="bi bi-credit-card me-1"></i> Mark as Paid
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-2 mb-0">No orders found</p>
                    <a href="{{ route('admin.orders.create') }}" class="btn btn-sm btn-primary mt-3">Create your first order</a>
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

<!-- Delete Modals -->
@foreach($orders as $order)
<div class="modal fade" id="deleteModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-0">
                <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex p-3 mb-3">
                    <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>
                </div>
                <h5 class="fw-bold mb-2">Delete Order</h5>
                <p class="text-muted mb-4">
                    Are you sure you want to delete order <strong>{{ $order->tracking_id }}</strong>?<br>
                    This action cannot be undone.
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" class="btn btn-light btn-rounded px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </button>
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-rounded px-4">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const paymentFilter = document.getElementById('paymentFilter');
        const resetBtn = document.getElementById('resetFilters');

        function filterOrders() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;
            const paymentValue = paymentFilter.value;

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

                if (paymentValue && row.dataset.paid !== paymentValue) {
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

                if (paymentValue && card.dataset.paid !== paymentValue) {
                    show = false;
                }

                card.style.display = show ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterOrders);
        statusFilter.addEventListener('change', filterOrders);
        paymentFilter.addEventListener('change', filterOrders);

        resetBtn.addEventListener('click', function() {
            searchInput.value = '';
            statusFilter.value = '';
            paymentFilter.value = '';
            filterOrders();
        });

        // Add dataset attributes for search
        document.querySelectorAll('.order-row').forEach(row => {
            const trackingId = row.cells[1]?.innerText.trim() || '';
            const recipient = row.cells[2]?.innerText.trim() || '';
            row.dataset.search = (trackingId + ' ' + recipient).toLowerCase();
        });
    });
</script>
@endpush

<style>
    /* Additional styles for orders index */
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

    .avatar-circle-small {
        width: 28px;
        height: 28px;
        background: var(--gray-100);
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

    /* Mobile optimizations */
    @media (max-width: 768px) {
        .btn-rounded {
            padding: 0.4rem 1rem;
            font-size: 0.8125rem;
        }

        .card-glass {
            border-radius: 1rem;
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

    /* Fix dropdown z-index issues */
    .table tbody tr {
        position: relative;
    }

    .table tbody tr:hover {
        z-index: 10;
    }

    /* Ensure dropdown menu appears above other rows */
    .dropdown {
        position: static;
    }

    .dropdown-menu {
        position: absolute !important;
        z-index: 1050 !important;
    }

    /* When dropdown is open, ensure it's visible */
    .dropdown.show {
        position: relative;
        z-index: 1055;
    }

    /* Allow overflow on desktop to show dropdowns */
    @media (min-width: 992px) {
        .table-responsive {
            overflow: visible;
        }

        .card-glass.overflow-hidden {
            overflow: visible;
        }
    }

    /* For rows near the bottom, adjust dropdown position */
    .table tbody tr:nth-last-child(-n+2) .dropdown-menu {
        transform: translateY(-100%);
        top: -10px;
    }
</style>
@endsection
