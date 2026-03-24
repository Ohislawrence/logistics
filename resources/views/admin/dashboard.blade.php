{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Admin Dashboard - MediSwift')

@section('header')
    <div>
        <h1 class="h2 fw-bold mb-1">Admin Dashboard</h1>
        <p class="text-muted mb-0">Manage orders, riders, and monitor delivery performance</p>
    </div>
    <div class="mt-3 mt-sm-0">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-rounded">
            <i class="bi bi-plus-circle me-1"></i> Manage Orders
        </a>
    </div>
@endsection

@section('content')
<div class="py-3 py-md-4">
    <!-- Stats Cards Row -->
    <div class="row g-3 g-md-4 mb-4">
        <div class="col-6 col-md-4">
            <div class="card-glass h-100 p-3 p-md-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="bi bi-box-seam fs-3 text-primary"></i>
                    </div>
                    <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                        <i class="bi bi-arrow-up-short text-success"></i> +12%
                    </span>
                </div>
                <h3 class="display-6 fw-bold mb-1">{{ $totalOrders ?? 0 }}</h3>
                <p class="text-muted mb-0 small text-uppercase fw-semibold">Total Orders</p>
                <div class="mt-2">
                    <span class="text-success small">+{{ rand(5, 20) }}</span>
                    <span class="text-muted small ms-1">vs last week</span>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4">
            <div class="card-glass h-100 p-3 p-md-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="bi bi-bicycle fs-3 text-success"></i>
                    </div>
                    <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                        <i class="bi bi-arrow-up-short text-success"></i> +8%
                    </span>
                </div>
                <h3 class="display-6 fw-bold mb-1">{{ $totalRiders ?? 0 }}</h3>
                <p class="text-muted mb-0 small text-uppercase fw-semibold">Active Riders</p>
                <div class="mt-2">
                    <span class="text-success small">+{{ rand(2, 8) }}</span>
                    <span class="text-muted small ms-1">this month</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card-glass h-100 p-3 p-md-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="bi bi-currency-dollar fs-3 text-warning"></i>
                    </div>
                    <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                        <i class="bi bi-graph-up"></i> Revenue
                    </span>
                </div>
                <h3 class="display-6 fw-bold mb-1">₦{{ number_format($totalRevenue ?? 0, 2) }}</h3>
                <p class="text-muted mb-0 small text-uppercase fw-semibold">Total Revenue</p>
                <div class="mt-2">
                    <span class="text-success small">+₦{{ number_format(($totalRevenue ?? 0) * 0.12, 2) }}</span>
                    <span class="text-muted small ms-1">this period</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Stats Row -->
    <div class="row g-3 g-md-4 mb-4">
        <div class="col-12 col-lg-5">
            <div class="card-glass p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-pie-chart me-2 text-primary"></i>Orders by Status
                    </h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light rounded-pill" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-calendar-week"></i> This week
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This week</a></li>
                            <li><a class="dropdown-item" href="#">This month</a></li>
                        </ul>
                    </div>
                </div>
                <div style="height: 240px; position: relative;">
                    <canvas id="ordersStatusChart"></canvas>
                </div>
                <!-- Legend -->
                <div class="d-flex flex-wrap justify-content-center gap-3 mt-3">
                    @foreach($ordersByStatus ?? [] as $status => $count)
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle" style="width: 10px; height: 10px; background-color:
                                @switch($status)
                                    @case('pending') #0d6efd @break
                                    @case('assigned') #6f42c1 @break
                                    @case('picked_up') #198754 @break
                                    @case('in_transit') #fd7e14 @break
                                    @case('delivered') #20c997 @break
                                    @case('cancelled') #dc3545 @break
                                    @default #6c757d
                                @endswitch
                            "></div>
                            <span class="small">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                            <span class="fw-semibold small">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7">
            <div class="card-glass p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-graph-up me-2 text-primary"></i>Order Trends
                    </h5>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-primary rounded-pill me-1 active" id="btnWeek">Week</button>
                        <button type="button" class="btn btn-outline-primary rounded-pill" id="btnMonth">Month</button>
                    </div>
                </div>
                <div style="height: 240px;">
                    <canvas id="ordersTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders and Quick Actions -->
    <div class="row g-3 g-md-4">
        <div class="col-12 col-lg-8">
            <div class="card-glass p-0 overflow-hidden">
                <div class="d-flex justify-content-between align-items-center p-3 p-md-4 border-bottom">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-clock-history me-2 text-primary"></i>Recent Orders
                    </h5>
                    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none small fw-semibold">
                        View all <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
                <div class="list-group list-group-flush">
                    @forelse($recentOrders ?? [] as $o)
                        <div class="list-group-item border-0 py-3 px-3 px-md-4 hover-bg-light transition">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                <div class="d-flex align-items-center gap-3 flex-grow-1">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2" style="width: 48px; height: 48px;">
                                        <i class="bi bi-receipt text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <strong class="text-dark">{{ $o->tracking_id ?? 'N/A' }}</strong>
                                            <span class="badge rounded-pill px-2 py-1 fs-7
                                                @if($o->status == 'delivered') bg-success bg-opacity-10 text-success
                                                @elseif($o->status == 'pending') bg-warning bg-opacity-10 text-warning
                                                @elseif($o->status == 'cancelled') bg-danger bg-opacity-10 text-danger
                                                @else bg-info bg-opacity-10 text-info @endif">
                                                {{ ucfirst($o->status ?? 'Unknown') }}
                                            </span>
                                        </div>
                                        <div class="text-muted small mt-1">
                                            <i class="bi bi-person me-1"></i>{{ $o->recipient_name ?? 'N/A' }}
                                        </div>
                                        <div class="text-muted small">
                                            <i class="bi bi-geo-alt me-1"></i>{{ Str::limit($o->pickup_address ?? '', 30) }} → {{ Str::limit($o->delivery_address ?? '', 30) }}
                                        </div>
                                        <div class="text-muted small mt-1">
                                            <i class="bi bi-cash-stack me-1"></i>₦{{ number_format($o->cost ?? 0, 2) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.orders.edit', $o->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-0">No orders yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card-glass p-3 p-md-4 mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-star me-2 text-warning"></i>Quick Stats
                </h5>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Completion Rate</span>
                        <span class="fw-semibold">94%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 94%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">On-Time Delivery</span>
                        <span class="fw-semibold">87%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: 87%"></div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Pending Orders</span>
                    <span class="fw-bold">{{ $pendingOrders ?? 0 }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">In Transit</span>
                    <span class="fw-bold">{{ $inTransitOrders ?? 0 }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Today's Orders</span>
                    <span class="fw-bold">{{ $todayOrders ?? 0 }}</span>
                </div>
            </div>

            <div class="card-glass p-3 p-md-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-truck me-2 text-primary"></i>Active Riders
                </h5>
                <div class="list-group list-group-flush">
                    @forelse($activeRiders ?? [] as $rider)
                        <div class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-circle" style="width: 32px; height: 32px; font-size: 14px;">
                                    {{ substr($rider->name ?? 'R', 0, 2) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold small">{{ $rider->name ?? 'Rider' }}</div>
                                    <div class="text-muted small">{{ $rider->active_deliveries ?? 0 }} active deliveries</div>
                                </div>
                                <span class="badge bg-success rounded-pill">
                                    <i class="bi bi-circle-fill fs-8"></i> Active
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3">
                            <p class="text-muted small mb-0">No active riders</p>
                        </div>
                    @endforelse
                </div>
                <div class="mt-3">
                    <a  class="btn btn-sm btn-outline-primary w-100 rounded-pill">
                        Manage Riders <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @php
        $__statusData = array_values($ordersByStatus ?? []);
        $__statusLabels = array_keys($ordersByStatus ?? []);
        $__trendData = $weeklyTrend ?? [0,0,0,0,0,0,0];
    @endphp
    (function() {
        // Status Chart (Doughnut)
        const statusCtx = document.getElementById('ordersStatusChart');
        if (statusCtx) {
            const statusData = @json($__statusData);
            const statusLabels = @json($__statusLabels);

            // Clean labels
            const cleanLabels = statusLabels.map(label =>
                label.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
            );

            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: cleanLabels,
                    datasets: [{
                        data: statusData,
                        backgroundColor: ['#0d6efd', '#6f42c1', '#198754', '#fd7e14', '#20c997', '#dc3545'],
                        borderWidth: 0,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });
        }

        // Trend Chart (Line)
        const trendCtx = document.getElementById('ordersTrendChart');
        if (trendCtx) {
            const trendData = @json($__trendData);
            const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: days,
                    datasets: [{
                        label: 'Orders',
                        data: trendData,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.05)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#0d6efd',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#0d6efd',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        // Simple toggle for trend view (demo)
        document.getElementById('btnWeek')?.addEventListener('click', function() {
            this.classList.add('active');
            document.getElementById('btnMonth')?.classList.remove('active');
            // You can update chart data here via AJAX if needed
        });

        document.getElementById('btnMonth')?.addEventListener('click', function() {
            this.classList.add('active');
            document.getElementById('btnWeek')?.classList.remove('active');
        });
    })();
</script>

<style>
    /* Additional dashboard-specific styles */
    .fs-7 {
        font-size: 0.75rem;
    }

    .fs-8 {
        font-size: 0.5rem;
    }

    .hover-bg-light:hover {
        background-color: var(--gray-100);
        transition: all 0.2s ease;
    }

    .transition {
        transition: all 0.2s ease;
    }

    .card-glass {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-glass:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Mobile optimizations */
    @media (max-width: 768px) {
        .display-6 {
            font-size: 1.75rem;
        }

        .btn-rounded {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
        }

        .list-group-item {
            padding: 1rem;
        }
    }

    /* Animation for stats cards */
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

    .card-glass {
        animation: fadeInUp 0.4s ease-out forwards;
    }

    .card-glass:nth-child(1) { animation-delay: 0.05s; }
    .card-glass:nth-child(2) { animation-delay: 0.1s; }
    .card-glass:nth-child(3) { animation-delay: 0.15s; }
</style>
@endsection
