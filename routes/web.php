<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Rider\OrderController as RiderOrderController;
use App\Http\Controllers\TrackingController;

Route::get('/', function () {
    return view('welcome');
});

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    if ($user->hasRole('rider')) {
        return redirect()->route('rider.dashboard');
    }

    // Fallback for other users
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', function () {
        $totalOrders = Order::count();
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $totalRiders = User::role('rider')->count();
        $recentOrders = Order::latest()->limit(5)->get();

        // Total revenue — sum of paid orders' cost
        $totalRevenue = (float) Order::where('paid', true)->sum('cost');

        return view('admin.dashboard', compact('totalOrders', 'ordersByStatus', 'totalRiders', 'recentOrders', 'totalRevenue'));
    })->name('dashboard');

    Route::resource('orders', OrderController::class)->except(['show']);
    Route::post('orders/{order}/assign', [OrderController::class, 'assign'])->name('orders.assign');
    Route::post('orders/{order}/mark-paid', [OrderController::class, 'markPaid'])->name('orders.mark_paid');
    // Riders management (admin only)
    Route::get('riders', [\App\Http\Controllers\Admin\RiderController::class, 'index'])->name('riders.index');
    Route::get('riders/create', [\App\Http\Controllers\Admin\RiderController::class, 'create'])->name('riders.create');
    Route::post('riders', [\App\Http\Controllers\Admin\RiderController::class, 'store'])->name('riders.store');
    Route::get('riders/{rider}', [\App\Http\Controllers\Admin\RiderController::class, 'show'])->name('riders.show');
    Route::get('riders/{rider}/edit', [\App\Http\Controllers\Admin\RiderController::class, 'edit'])->name('riders.edit');
    Route::put('riders/{rider}', [\App\Http\Controllers\Admin\RiderController::class, 'update'])->name('riders.update');
    Route::delete('riders/{rider}', [\App\Http\Controllers\Admin\RiderController::class, 'destroy'])->name('riders.destroy');
});

Route::middleware(['auth', 'role:rider'])->prefix('rider')->name('rider.')->group(function () {
    Route::get('dashboard', function () {
        $userId = auth()->id();

        $assignedCount = Order::where('assigned_to', $userId)->count();
        $recentAssigned = Order::where('assigned_to', $userId)->latest()->limit(5)->get();

        // Pending pickup: assigned but not yet collected/picked
        $pendingPickup = Order::where('assigned_to', $userId)
            ->whereIn('status', ['assigned', 'pending'])
            ->count();

        // In transit
        $inTransit = Order::where('assigned_to', $userId)
            ->where('status', 'in_transit')
            ->count();

        // Completed today (delivered today)
        $completedToday = Order::where('assigned_to', $userId)
            ->where('status', 'delivered')
            ->whereDate('updated_at', now()->toDateString())
            ->count();

        // Today's earnings: sum of costs for orders marked paid today
        $todayEarnings = (float) Order::where('assigned_to', $userId)
            ->where('paid', true)
            ->whereDate('paid_at', now()->toDateString())
            ->sum('cost');

        return view('rider.dashboard', compact('assignedCount', 'recentAssigned', 'pendingPickup', 'inTransit', 'completedToday', 'todayEarnings'));
    })->name('dashboard');

    Route::get('orders', [RiderOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [RiderOrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/status', [RiderOrderController::class, 'updateStatus'])->name('orders.update_status');
    Route::post('orders/{order}/mark-paid', [RiderOrderController::class, 'markPaid'])->name('orders.mark_paid');
});

// Public tracking page with basic rate limiting
Route::get('/track-order', [TrackingController::class, 'index'])
    ->middleware('throttle:10,1')
    ->name('track.order');

// Accept POST submissions from landing page tracking forms
Route::post('/track-order', [TrackingController::class, 'index'])
    ->middleware('throttle:10,1')
    ->name('track.order.post');


require __DIR__.'/auth.php';
