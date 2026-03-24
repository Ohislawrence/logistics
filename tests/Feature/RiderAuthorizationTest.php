<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;

class RiderAuthorizationTest extends TestCase
{
    public function test_rider_can_view_and_update_assigned_order(): void
    {
        $rider = User::factory()->create();
        $rider->assignRole('rider');

        $order = Order::factory()->create(['assigned_to' => $rider->id]);

        $this->actingAs($rider);

        $res = $this->get(route('rider.orders.show', $order));
        $res->assertStatus(200);

        $update = $this->post(route('rider.orders.update_status', $order), [
            'status' => 'in_transit',
        ]);

        $update->assertRedirect(route('rider.orders.show', $order));
    }
}
