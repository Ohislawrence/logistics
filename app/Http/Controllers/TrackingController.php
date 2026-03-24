<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class TrackingController extends Controller
{
    /**
     * Display tracking form and optionally show results.
     */
    public function index(Request $request)
    {
        $order = null;

        if ($request->filled('tracking_id')) {
            // Honeypot: simple bot trap and time-based check
            if ($request->filled('hp_name')) {
                abort(429, 'Too many requests.');
            }

            if ($request->filled('hp_time')) {
                $submitted = (int) $request->input('hp_time');
                if (now()->timestamp - $submitted < 3) {
                    // Submitted too quickly — likely a bot
                    abort(429, 'Too many requests.');
                }
            }

            $data = $request->validate([
                'tracking_id' => 'required|string',
            ]);

            $order = Order::with(['progresses.reporter', 'assignedTo'])
                ->where('tracking_id', $data['tracking_id'])
                ->first();
        }

        return view('track-order.index', compact('order'));
    }
}
