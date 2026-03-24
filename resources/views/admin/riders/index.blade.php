{{-- resources/views/admin/riders/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Riders Management - MediSwift')

@section('header')
    <div>
        <h1 class="h2 fw-bold mb-1">Riders Management</h1>
        <p class="text-muted mb-0">Manage delivery riders and track their performance</p>
    </div>
    <div class="mt-3 mt-sm-0">
        <a href="{{ route('admin.riders.create') }}" class="btn btn-primary btn-rounded">
            <i class="bi bi-plus-circle me-1"></i> Create Rider
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
                    <i class="bi bi-bicycle fs-4 text-primary"></i>
                </div>
                <h3 class="h4 fw-bold mb-0">{{ $riders->total() ?? 0 }}</h3>
                <p class="text-muted small mb-0">Total Riders</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex p-2 mb-2">
                    <i class="bi bi-check-circle fs-4 text-success"></i>
                </div>
                <h3 class="h4 fw-bold mb-0">{{ $activeRiders ?? 0 }}</h3>
                <p class="text-muted small mb-0">Active Riders</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex p-2 mb-2">
                    <i class="bi bi-truck fs-4 text-warning"></i>
                </div>
                <h3 class="h4 fw-bold mb-0">{{ $totalDeliveries ?? 0 }}</h3>
                <p class="text-muted small mb-0">Total Deliveries</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="rounded-circle bg-info bg-opacity-10 d-inline-flex p-2 mb-2">
                    <i class="bi bi-star fs-4 text-info"></i>
                </div>
                <h3 class="h4 fw-bold mb-0">{{ $avgRating ?? 4.8 }}</h3>
                <p class="text-muted small mb-0">Avg Rating</p>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card-glass p-3 p-md-4 mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold small">Search Rider</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Name or email...">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label fw-semibold small">Status Filter</label>
                <select id="statusFilter" class="form-select">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="on_delivery">On Delivery</option>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <button id="resetFilters" class="btn btn-outline-secondary w-100 btn-rounded">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Riders Table (Desktop) -->
    <div class="card-glass overflow-hidden d-none d-lg-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="ridersTable">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 py-3 px-4">#</th>
                        <th class="border-0 py-3">Rider</th>
                        <th class="border-0 py-3">Contact</th>
                        <th class="border-0 py-3">Status</th>
                        <th class="border-0 py-3">Deliveries</th>
                        <th class="border-0 py-3 text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riders as $rider)
                    <tr class="rider-row" data-status="{{ $rider->status ?? 'active' }}" data-search="{{ strtolower($rider->name . ' ' . $rider->email) }}">
                        <td class="px-4 fw-semibold">{{ $rider->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle bg-light d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px;">
                                    <span class="fw-bold text-primary">{{ substr($rider->name, 0, 2) }}</span>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $rider->name }}</div>
                                    <div class="small text-muted">ID: R{{ str_pad($rider->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="small">
                                    <i class="bi bi-envelope me-1 text-muted"></i> {{ $rider->email }}
                                </div>
                                @if(isset($rider->phone))
                                <div class="small">
                                    <i class="bi bi-telephone me-1 text-muted"></i> {{ $rider->phone }}
                                </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge rounded-pill px-3 py-2
                                @if(($rider->status ?? 'active') == 'active') bg-success
                                @elseif(($rider->status ?? '') == 'inactive') bg-secondary
                                @elseif(($rider->status ?? '') == 'on_delivery') bg-info
                                @else bg-warning @endif">
                                <i class="bi
                                    @if(($rider->status ?? 'active') == 'active') bi-circle-fill
                                    @elseif(($rider->status ?? '') == 'inactive') bi-circle
                                    @elseif(($rider->status ?? '') == 'on_delivery') bi-truck
                                    @else bi-clock @endif me-1 fs-8">
                                </i>
                                {{ ucfirst($rider->status ?? 'Active') }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $rider->total_deliveries ?? 0 }}</div>
                            <div class="small text-muted">deliveries</div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.riders.show', $rider) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('admin.riders.edit', $rider) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <button class="btn btn-sm btn-outline-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $rider->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-0">No riders found</p>
                            <a href="{{ route('admin.riders.create') }}" class="btn btn-sm btn-primary mt-3">Create your first rider</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Cards View -->
    <div class="d-lg-none">
        <div class="row g-3" id="mobileRidersContainer">
            @forelse($riders as $rider)
            <div class="col-12 mobile-rider-card" data-status="{{ $rider->status ?? 'active' }}" data-search="{{ strtolower($rider->name . ' ' . $rider->email) }}">
                <div class="card-glass p-3">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-circle bg-light d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px;">
                                <span class="fw-bold text-primary fs-5">{{ substr($rider->name, 0, 2) }}</span>
                            </div>
                            <div>
                                <div class="fw-bold fs-5">{{ $rider->name }}</div>
                                <div class="small text-muted">ID: R{{ str_pad($rider->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                        <span class="badge rounded-pill px-3 py-2
                            @if(($rider->status ?? 'active') == 'active') bg-success
                            @elseif(($rider->status ?? '') == 'inactive') bg-secondary
                            @elseif(($rider->status ?? '') == 'on_delivery') bg-info
                            @else bg-warning @endif">
                            {{ ucfirst($rider->status ?? 'Active') }}
                        </span>
                    </div>

                    <div class="mb-2">
                        <div class="small text-muted">Email</div>
                        <div>{{ $rider->email }}</div>
                    </div>

                    @if(isset($rider->phone))
                    <div class="mb-2">
                        <div class="small text-muted">Phone</div>
                        <div>{{ $rider->phone }}</div>
                    </div>
                    @endif

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="bg-light rounded-3 p-2 text-center">
                                <div class="small text-muted">Deliveries</div>
                                <div class="fw-bold fs-5">{{ $rider->total_deliveries ?? 0 }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.riders.show', $rider) }}" class="btn btn-sm btn-outline-primary flex-grow-1 rounded-pill">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <a href="{{ route('admin.riders.edit', $rider) }}" class="btn btn-sm btn-outline-primary flex-grow-1 rounded-pill">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $rider->id }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-2 mb-0">No riders found</p>
                    <a href="{{ route('admin.riders.create') }}" class="btn btn-sm btn-primary mt-3">Create your first rider</a>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $riders->links() }}
    </div>
</div>

<!-- Delete Modals -->
@foreach($riders as $rider)
<div class="modal fade" id="deleteModal{{ $rider->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-0">
                <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex p-3 mb-3">
                    <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>
                </div>
                <h5 class="fw-bold mb-2">Delete Rider</h5>
                <p class="text-muted mb-4">
                    Are you sure you want to delete rider <strong>{{ $rider->name }}</strong>?<br>
                    This action cannot be undone. All associated deliveries will be unassigned.
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" class="btn btn-light btn-rounded px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </button>
                    <form action="{{ route('admin.riders.destroy', $rider) }}" method="POST" class="d-inline">
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
        const resetBtn = document.getElementById('resetFilters');

        function filterRiders() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;

            // Filter desktop table rows
            const rows = document.querySelectorAll('#ridersTable .rider-row');
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
            const cards = document.querySelectorAll('.mobile-rider-card');
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

        searchInput.addEventListener('input', filterRiders);
        statusFilter.addEventListener('change', filterRiders);

        resetBtn.addEventListener('click', function() {
            searchInput.value = '';
            statusFilter.value = '';
            filterRiders();
        });

        // Add dataset attributes for search on desktop rows
        document.querySelectorAll('#ridersTable .rider-row').forEach(row => {
            const name = row.cells[1]?.innerText.trim() || '';
            const email = row.cells[2]?.innerText.trim() || '';
            row.dataset.search = (name + ' ' + email).toLowerCase();
        });
    });
</script>
@endpush

<style>
    /* Additional styles for riders index */
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

    .avatar-circle {
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        font-weight: 600;
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

    .fs-8 {
        font-size: 0.5rem;
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

        .avatar-circle {
            width: 45px;
            height: 45px;
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

    .card-glass, .rider-row {
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

    /* Status badges with icons */
    .badge i {
        vertical-align: middle;
    }

    /* Rating stars */
    .bi-star-fill {
        font-size: 0.875rem;
    }

    /* Background light for stats */
    .bg-light {
        background-color: var(--gray-100);
    }
</style>
@endsection
