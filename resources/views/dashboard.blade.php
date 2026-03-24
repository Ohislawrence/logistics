<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Orders</h5>
                            <p class="display-6">{{ $totalOrders ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Riders</h5>
                            <p class="display-6">{{ $totalRiders ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Orders by Status</h5>
                            <canvas id="ordersStatusChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Recent Orders</h5>
                            <ul class="list-group">
                                @foreach($recentOrders as $o)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $o->tracking_id }}</strong> — {{ $o->recipient_name }}
                                            <div class="small text-muted">{{ $o->pickup_address }} → {{ $o->delivery_address }}</div>
                                        </div>
                                        <span class="badge bg-secondary">{{ ucfirst($o->status) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Quick Stats</h5>
                            <p>Orders: <strong>{{ $totalOrders ?? 0 }}</strong></p>
                            <p>Riders: <strong>{{ $totalRiders ?? 0 }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function(){
            const ctx = document.getElementById('ordersStatusChart');
            if (!ctx) return;
            const data = @json(array_values($ordersByStatus ?? []));
            const labels = @json(array_keys($ordersByStatus ?? []));

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: ['#0d6efd','#6f42c1','#198754','#fd7e14','#dc3545'],
                    }]
                },
                options: {responsive: true, maintainAspectRatio: false}
            });
        })();
    </script>
</x-app-layout>
