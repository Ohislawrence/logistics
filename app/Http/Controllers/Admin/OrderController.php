<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProgress;
use App\Models\User;
use App\Notifications\OrderAssigned;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
        $this->authorizeResource(\App\Models\Order::class, 'order');
    }

    public function index()
    {
        $orders = Order::with('assignedTo')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $riders = User::role('rider')->get();
        return view('admin.orders.create', compact('riders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'nullable|string|max:50',
            'pickup_address' => 'nullable|string',
            'delivery_address' => 'nullable|string',
            'notes' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $order = Order::create(array_merge($data, [
            'status' => $data['assigned_to'] ? 'assigned' : 'created',
        ]));

        if (!empty($data['assigned_to'])) {
            OrderProgress::create([
                'order_id' => $order->id,
                'status' => 'assigned',
                'notes' => 'Order assigned to rider.',
                'reported_by' => auth()->id(),
            ]);

            // Notify rider
            $rider = User::find($data['assigned_to']);
            if ($rider) {
                $rider->notify(new OrderAssigned($order));
            }
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order created.');
    }

    public function edit(Order $order)
    {
        $riders = User::role('rider')->get();
        return view('admin.orders.edit', compact('order', 'riders'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'nullable|string|max:50',
            'pickup_address' => 'nullable|string',
            'delivery_address' => 'nullable|string',
            'notes' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $oldAssigned = $order->assigned_to;

        $order->update(array_merge($data, [
            'status' => $data['assigned_to'] ? 'assigned' : $order->status,
        ]));

        if (!empty($data['assigned_to']) && $oldAssigned != $data['assigned_to']) {
            OrderProgress::create([
                'order_id' => $order->id,
                'status' => 'assigned',
                'notes' => 'Order assigned to rider (updated).',
                'reported_by' => auth()->id(),
            ]);

            // Notify new rider
            $newRider = User::find($data['assigned_to']);
            if ($newRider) {
                $newRider->notify(new OrderAssigned($order));
            }
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order updated.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted.');
    }

    public function assign(Request $request, Order $order)
    {
        $data = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $rider = User::findOrFail($data['assigned_to']);

        // Ensure user is a rider
        if (! $rider->hasRole('rider')) {
            return back()->withErrors(['assigned_to' => 'Selected user is not a rider.']);
        }

        $order->assigned_to = $rider->id;
        $order->status = 'assigned';
        $order->save();

        OrderProgress::create([
            'order_id' => $order->id,
            'status' => 'assigned',
            'notes' => 'Order assigned to rider via assign action.',
            'reported_by' => auth()->id(),
        ]);

        // Notify rider
        $rider->notify(new OrderAssigned($order));

        return redirect()->route('admin.orders.index')->with('success', 'Order assigned to rider.');
    }

    public function markPaid(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        if ($order->paid) {
            return back()->with('error', 'Order is already marked as paid.');
        }

        $order->paid = true;
        $order->paid_at = now();
        $order->paid_by = auth()->id();
        $order->save();

        OrderProgress::create([
            'order_id' => $order->id,
            'status' => 'paid',
            'notes' => 'Marked as paid by admin.',
            'reported_by' => auth()->id(),
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Order marked as paid.');
    }
}
