<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Mangku Rinjani',
            'email' => 'admin@mangkurinjani.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081000000000',
            'address' => 'Lombok',
        ]);

        // Customers
        $customers = [
            ['name' => 'Andi Wijaya', 'email' => 'andi@example.com', 'phone' => '081111111111', 'address' => 'Lombok'],
            ['name' => 'Budi Susanto', 'email' => 'budi@example.com', 'phone' => '082222222222', 'address' => 'Surabaya'],
            ['name' => 'Citra Dewi', 'email' => 'citra@example.com', 'phone' => '083333333333', 'address' => 'Jakarta'],
        ];

        foreach ($customers as $c) {
            $user = User::create([
                'name' => $c['name'],
                'email' => $c['email'],
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => $c['phone'],
                'address' => $c['address'],
            ]);

            Customer::create([
                'user_id' => $user->id,
                'name' => $c['name'],
                'email' => $c['email'],
                'phone' => $c['phone'],
                'address' => $c['address'],
                'join_date' => now()->subMonths(rand(1, 12)),
                'total_transactions' => 0,
            ]);
        }
    }
}
