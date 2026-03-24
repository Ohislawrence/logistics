<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use App\Notifications\RiderCreated;
use Illuminate\Validation\Rules\Password;

class RiderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $riders = User::role('rider')->paginate(20);

        // Active riders: riders with at least one assigned order not delivered/cancelled
        $activeRiders = Order::whereIn('status', ['assigned', 'collected', 'picked_up', 'in_transit'])
            ->distinct()
            ->count('assigned_to');

        // Total deliveries: number of orders marked delivered
        $totalDeliveries = Order::where('status', 'delivered')->count();

        return view('admin.riders.index', compact('riders', 'activeRiders', 'totalDeliveries'));
    }

    public function show(User $rider)
    {
        // Summary stats for rider
        $riderId = $rider->id;

        $totalAssigned = Order::where('assigned_to', $riderId)->count();
        $totalDelivered = Order::where('assigned_to', $riderId)->where('status', 'delivered')->count();
        $totalTrips = $totalDelivered; // interpreted as completed trips

        $amountCollected = (float) Order::where('paid', true)
            ->where('paid_by', $riderId)
            ->sum('cost');

        $inTransit = Order::where('assigned_to', $riderId)->where('status', 'in_transit')->count();
        $pending = Order::where('assigned_to', $riderId)->whereIn('status', ['assigned', 'pending', 'collected', 'picked_up'])->count();

        $completionRate = $totalAssigned > 0 ? round(($totalDelivered / $totalAssigned) * 100, 1) : 0;

        $recentDeliveries = Order::where('assigned_to', $riderId)
            ->where('status', 'delivered')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.riders.show', compact(
            'rider',
            'totalAssigned',
            'totalDelivered',
            'totalTrips',
            'amountCollected',
            'inTransit',
            'pending',
            'completionRate',
            'recentDeliveries'
        ));
    }

    public function create()
    {
        return view('admin.riders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('rider');

        // notify the rider by email about their new account
        $user->notify(new RiderCreated($data['password']));

        return redirect()->route('admin.riders.index')->with('success', 'Rider created.');
    }

    public function edit(User $rider)
    {
        return view('admin.riders.edit', compact('rider'));
    }

    public function update(Request $request, User $rider)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $rider->id,
            'password' => ['nullable', Password::min(6)->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        $rider->name = $data['name'];
        $rider->email = $data['email'];
        if (!empty($data['password'])) {
            $rider->password = Hash::make($data['password']);
        }
        $rider->save();

        return redirect()->route('admin.riders.index')->with('success', 'Rider updated.');
    }

    public function destroy(User $rider)
    {
        // remove role and delete user
        $rider->removeRole('rider');
        $rider->delete();

        return redirect()->route('admin.riders.index')->with('success', 'Rider deleted.');
    }
}
