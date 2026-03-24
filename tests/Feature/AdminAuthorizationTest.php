<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;

class AdminAuthorizationTest extends TestCase
{
    public function test_admin_can_create_and_delete_order(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        $response = $this->post(route('admin.orders.store'), [
            'recipient_name' => 'Test',
        ]);

        $response->assertRedirect(route('admin.orders.index'));

        $order = Order::latest()->first();

        $this->assertNotNull($order);

        $delete = $this->delete(route('admin.orders.destroy', $order));
        $delete->assertRedirect(route('admin.orders.index'));
    }
}
