<?php

namespace Database\Seeders;

use App\Models\Leader;
use Illuminate\Database\Seeder;

class LeaderSeeder extends Seeder
{
    public function run(): void
    {
        $leaders = [
            ['name' => 'Budi Santoso', 'phone' => '081234567890', 'address' => 'Sembalun', 'fee_per_day' => 150000, 'is_active' => true],
            ['name' => 'Eko Prasetyo', 'phone' => '082345678901', 'address' => 'Senaru', 'fee_per_day' => 175000, 'is_active' => true],
            ['name' => 'Rudi Hermawan', 'phone' => '083456789012', 'address' => 'Mataram', 'fee_per_day' => 130000, 'is_active' => true],
            ['name' => 'Siti Rahayu', 'phone' => '084567890123', 'address' => 'Aikmel', 'fee_per_day' => 140000, 'is_active' => true],
            ['name' => 'Hendra Kurniawan', 'phone' => '085678901234', 'address' => 'Selong', 'fee_per_day' => 160000, 'is_active' => false],
        ];

        foreach ($leaders as $leader) {
            Leader::create($leader);
        }
    }
}
