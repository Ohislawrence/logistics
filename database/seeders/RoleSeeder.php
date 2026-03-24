<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create roles
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'rider']);

        // Create an admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Administrator', 'password' => 'password']
        );
        $admin->assignRole('admin');

        // Create sample riders
        $rider1 = User::firstOrCreate(
            ['email' => 'rider1@example.com'],
            ['name' => 'Rider One', 'password' => 'password']
        );
        $rider1->assignRole('rider');

        $rider2 = User::firstOrCreate(
            ['email' => 'rider2@example.com'],
            ['name' => 'Rider Two', 'password' => 'password']
        );
        $rider2->assignRole('rider');
    }
}
