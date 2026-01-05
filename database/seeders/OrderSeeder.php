<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        // Create sample orders for yesterday
        $yesterday = now()->subDay();

        // Morning orders
        Order::create([
            'user_id' => $users->random()->id,
            'total' => 149.97,
            'items_count' => 3,
            'created_at' => $yesterday->copy()->setTime(9, 15, 0),
            'updated_at' => $yesterday->copy()->setTime(9, 15, 0),
        ]);

        Order::create([
            'user_id' => $users->random()->id,
            'total' => 79.99,
            'items_count' => 1,
            'created_at' => $yesterday->copy()->setTime(10, 30, 0),
            'updated_at' => $yesterday->copy()->setTime(10, 30, 0),
        ]);

        // Afternoon orders
        Order::create([
            'user_id' => $users->random()->id,
            'total' => 234.95,
            'items_count' => 5,
            'created_at' => $yesterday->copy()->setTime(14, 45, 0),
            'updated_at' => $yesterday->copy()->setTime(14, 45, 0),
        ]);

        Order::create([
            'user_id' => $users->random()->id,
            'total' => 59.98,
            'items_count' => 2,
            'created_at' => $yesterday->copy()->setTime(15, 20, 0),
            'updated_at' => $yesterday->copy()->setTime(15, 20, 0),
        ]);

        // Evening orders
        Order::create([
            'user_id' => $users->random()->id,
            'total' => 189.99,
            'items_count' => 4,
            'created_at' => $yesterday->copy()->setTime(18, 10, 0),
            'updated_at' => $yesterday->copy()->setTime(18, 10, 0),
        ]);

        Order::create([
            'user_id' => $users->random()->id,
            'total' => 129.99,
            'items_count' => 2,
            'created_at' => $yesterday->copy()->setTime(19, 55, 0),
            'updated_at' => $yesterday->copy()->setTime(19, 55, 0),
        ]);

        Order::create([
            'user_id' => $users->random()->id,
            'total' => 299.94,
            'items_count' => 6,
            'created_at' => $yesterday->copy()->setTime(20, 30, 0),
            'updated_at' => $yesterday->copy()->setTime(20, 30, 0),
        ]);

        $this->command->info('Created 7 sample orders for yesterday.');
    }
}
