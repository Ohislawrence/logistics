{{-- resources/views/admin/riders/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Rider Overview - ' . ($rider->name ?? 'Rider'))

@section('header')
    <div>
        <h1 class="h2 fw-bold mb-1">Rider: {{ $rider->name }}</h1>
        <p class="text-muted mb-0">360° view — deliveries, collections and recent activity</p>
    </div>
    <div class="mt-3 mt-sm-0">
        <a href="{{ route('admin.riders.index') }}" class="btn btn-outline-secondary btn-rounded">Back to Riders</a>
    </div>
@endsection

@section('content')
<div class="py-3 py-md-4">
    <div class="row g-3 g-md-4 mb-4">
        <div class="col-6 col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex p-2 mb-2">
                    <i class="bi bi-box-seam fs-4 text-primary"></i>
                </div>
                <h3 class="h4 fw-bold mb-0">{{ $totalAssigned ?? 0 }}</h3>
                <p class="text-muted small mb-0">Assigned Orders</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex p-2 mb-2">
                    <i class="bi bi-check-circle fs-4 text-success"></i>
                </div>
                <h3 class="h4 fw-bold mb-0">{{ $totalDelivered ?? 0 }}</h3>
                <p class="text-muted small mb-0">Delivered</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex p-2 mb-2">
                    <i class="bi bi-credit-card fs-4 text-warning"></i>
                </div>
                <h3 class="h4 fw-bold mb-0">₦{{ number_format($amountCollected ?? 0, 2) }}</h3>
                <p class="text-muted small mb-0">Amount Collected</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card-glass p-3 text-center">
                <div class="rounded-circle bg-info bg-opacity-10 d-inline-flex p-2 mb-2">
                    <i class="bi bi-repeat fs-4 text-info"></i>
                </div>
                <h3 class="h4 fw-bold mb-0">{{ $totalTrips ?? 0 }}</h3>
                <p class="text-muted small mb-0">Trips</p>
            </div>
        </div>
    </div>

    <div class="row g-3 g-md-4 mb-4">
        <div class="col-12 col-lg-8">
            <div class="card-glass p-3 p-md-4">
                <h5 class="fw-bold mb-3">Recent Deliveries</h5>
                @if($recentDeliveries->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tracking</th>
                                    <th>Recipient</th>
                                    <th>Cost</th>
                                    <th>Status</th>
                                    <th>Paid</th>
                                    <th class="text-end">Delivered At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentDeliveries as $o)
                                    <tr>
                                        <td>{{ $o->id }}</td>
                                        <td><a href="{{ route('admin.orders.edit', $o->id) }}">{{ $o->tracking_id }}</a></td>
                                        <td>{{ $o->recipient_name }}</td>
                                        <td>₦{{ number_format($o->cost ?? 0, 2) }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $o->status)) }}</td>
                                        <td>
                                            @if($o->paid)
                                                <span class="badge bg-success">Yes</span>
                                            @else
                                                <span class="badge bg-warning">No</span>
                                            @endif
                                        </td>
                                        <td class="text-end">{{ optional($o->updated_at)->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">No deliveries recorded yet</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card-glass p-3 p-md-4">
                <h6 class="fw-bold mb-3">Rider Summary</h6>
                <div class="mb-2 d-flex justify-content-between">
                    <span class="text-muted">In Transit</span>
                    <strong>{{ $inTransit ?? 0 }}</strong>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <span class="text-muted">Pending</span>
                    <strong>{{ $pending ?? 0 }}</strong>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <span class="text-muted">Completion Rate</span>
                    <strong>{{ $completionRate ?? 0 }}%</strong>
                </div>
                <hr>
                <div class="mb-2">
                    <div class="text-muted small">Email</div>
                    <div>{{ $rider->email }}</div>
                </div>
                @if(isset($rider->phone))
                <div class="mb-2">
                    <div class="text-muted small">Phone</div>
                    <div>{{ $rider->phone }}</div>
                </div>
                @endif
                <div class="mt-3">
                    <a href="{{ route('admin.riders.edit', $rider) }}" class="btn btn-sm btn-outline-primary w-100 rounded-pill">Edit Rider</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
