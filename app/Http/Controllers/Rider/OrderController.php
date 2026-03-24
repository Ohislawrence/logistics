<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProgress;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:rider']);
        $this->authorizeResource(\App\Models\Order::class, 'order');
    }

    public function index()
    {
        $userId = auth()->id();

        $orders = Order::where('assigned_to', $userId)->latest()->paginate(20);

        // Pending pickup: orders assigned but not yet picked up
        $pendingOrders = Order::where('assigned_to', $userId)
            ->whereIn('status', ['assigned', 'pending'])
            ->count();

        // In transit: orders currently in transit
        $inTransitOrders = Order::where('assigned_to', $userId)
            ->where('status', 'in_transit')
            ->count();

        // Completed today: delivered orders updated today
        $completedToday = Order::where('assigned_to', $userId)
            ->where('status', 'delivered')
            ->whereDate('updated_at', now()->toDateString())
            ->count();

        return view('rider.orders.index', compact('orders', 'pendingOrders', 'inTransitOrders', 'completedToday'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $progresses = $order->progresses()->latest()->get();
        return view('rider.orders.show', compact('order', 'progresses'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('updateStatus', $order);

        $data = $request->validate([
            'status' => 'required|in:assigned,collected,in_transit,delivered',
            'notes' => 'nullable|string',
        ]);

        $order->status = $data['status'];
        $order->save();

        OrderProgress::create([
            'order_id' => $order->id,
            'status' => $data['status'],
            'notes' => $data['notes'] ?? null,
            'reported_by' => auth()->id(),
        ]);

        return redirect()->route('rider.orders.show', $order)->with('success', 'Status updated.');
    }

    public function markPaid(Request $request, Order $order)
    {
        $this->authorize('updateStatus', $order);

        if ($order->paid) {
            return back()->with('error', 'Order is already marked as paid.');
        }

        // Only allow rider to mark orders assigned to them
        if ($order->assigned_to !== auth()->id()) {
            abort(403, 'Not authorized to mark this order paid.');
        }

        $order->paid = true;
        $order->paid_at = now();
        $order->paid_by = auth()->id();
        $order->save();

        OrderProgress::create([
            'order_id' => $order->id,
            'status' => 'paid',
            'notes' => 'Marked as paid by rider.',
            'reported_by' => auth()->id(),
        ]);

        return redirect()->route('rider.orders.show', $order)->with('success', 'Order marked as paid.');
    }
}
