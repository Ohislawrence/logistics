<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order): bool
    {
        return $user->hasRole('admin') || $user->id === $order->assigned_to;
    }

    public function viewAny(User $user): bool
    {
        // Admins can view all orders; riders can view their assigned orders list
        return $user->hasRole('admin') || $user->hasRole('rider');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Order $order): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Order $order): bool
    {
        return $user->hasRole('admin');
    }

    public function assign(User $user, Order $order): bool
    {
        return $user->hasRole('admin');
    }

    public function updateStatus(User $user, Order $order): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('rider') && $order->assigned_to === $user->id) {
            return true;
        }

        return false;
    }
}
