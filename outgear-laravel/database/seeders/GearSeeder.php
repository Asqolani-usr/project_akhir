<?php

namespace Database\Seeders;

use App\Models\Gear;
use Illuminate\Database\Seeder;

class GearSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Tenda Dome 2 Orang', 'category' => 'Tenda', 'category_id' => 'cat1', 'price_per_day' => 75000, 'stock' => 5, 'condition' => 'Baik', 'description' => 'Tenda dome kapasitas 2 orang, waterproof, cocok untuk segala cuaca gunung.'],
            ['name' => 'Tenda Dome 4 Orang', 'category' => 'Tenda', 'category_id' => 'cat1', 'price_per_day' => 120000, 'stock' => 3, 'condition' => 'Baik', 'description' => 'Tenda dome kapasitas 4 orang, double layer, tahan angin kencang.'],
            ['name' => 'Sleeping Bag Polar -5°C', 'category' => 'Sleeping Bag', 'category_id' => 'cat2', 'price_per_day' => 35000, 'stock' => 8, 'condition' => 'Baik', 'description' => 'Sleeping bag bahan polar cocok untuk suhu -5°C, ringan dan compressible.'],
            ['name' => 'Carrier 60L', 'category' => 'Carrier / Ransel', 'category_id' => 'cat3', 'price_per_day' => 45000, 'stock' => 6, 'condition' => 'Baik', 'description' => 'Carrier 60 liter dengan frame internal, ergonomis untuk pendakian panjang.'],
            ['name' => 'Carrier 80L', 'category' => 'Carrier / Ransel', 'category_id' => 'cat3', 'price_per_day' => 55000, 'stock' => 4, 'condition' => 'Baik', 'description' => 'Carrier 80 liter frame internal, cocok untuk pendakian lebih dari 3 hari.'],
            ['name' => 'Matras Foam', 'category' => 'Matras', 'category_id' => 'cat4', 'price_per_day' => 15000, 'stock' => 10, 'condition' => 'Baik', 'description' => 'Matras foam ringan dan nyaman untuk alas tidur di tenda.'],
            ['name' => 'Kompor Portable Gas', 'category' => 'Kompor & Masak', 'category_id' => 'cat5', 'price_per_day' => 20000, 'stock' => 7, 'condition' => 'Baik', 'description' => 'Kompor portable berbahan bakar gas kaleng, stabil dan mudah digunakan.'],
            ['name' => 'Nesting / Panci Set', 'category' => 'Kompor & Masak', 'category_id' => 'cat5', 'price_per_day' => 15000, 'stock' => 5, 'condition' => 'Cukup', 'description' => 'Set panci dan wajan aluminium ringan, cocok untuk memasak di alam.'],
            ['name' => 'Headlamp LED', 'category' => 'Penerangan', 'category_id' => 'cat6', 'price_per_day' => 10000, 'stock' => 12, 'condition' => 'Baik', 'description' => 'Headlamp LED 200 lumen, tahan air, baterai tahan lama.'],
            ['name' => 'Kompas Silva', 'category' => 'Navigasi', 'category_id' => 'cat7', 'price_per_day' => 12000, 'stock' => 4, 'condition' => 'Baik', 'description' => 'Kompas baseplate presisi tinggi untuk navigasi medan.'],
            ['name' => 'P3K Kit Lengkap', 'category' => 'Safety & P3K', 'category_id' => 'cat8', 'price_per_day' => 20000, 'stock' => 5, 'condition' => 'Baik', 'description' => 'Kit P3K lengkap untuk pendakian, berisi perban, antiseptik, plester, dll.'],
            ['name' => 'Trekking Pole (pasang)', 'category' => 'Safety & P3K', 'category_id' => 'cat8', 'price_per_day' => 25000, 'stock' => 6, 'condition' => 'Baik', 'description' => 'Trekking pole aluminium adjustable, 1 pasang, membantu keseimbangan di medan terjal.'],
            ['name' => 'Jaket Gunung Waterproof', 'category' => 'Pakaian', 'category_id' => 'cat9', 'price_per_day' => 30000, 'stock' => 10, 'condition' => 'Baik', 'description' => 'Jaket waterproof dan windproof, menjaga tubuh tetap hangat dan kering.'],
            ['name' => 'Sepatu Trekking', 'category' => 'Sepatu', 'category_id' => 'cat10', 'price_per_day' => 40000, 'stock' => 8, 'condition' => 'Baik', 'description' => 'Sepatu khusus pendakian dengan grip kuat dan perlindungan engkel.'],
            ['name' => 'Topi Rimba', 'category' => 'Topi', 'category_id' => 'cat11', 'price_per_day' => 5000, 'stock' => 15, 'condition' => 'Baik', 'description' => 'Topi rimba untuk melindungi kepala dari panas matahari dan hujan ringan.'],
        ];

        foreach ($items as $item) {
            Gear::create(array_merge($item, ['is_available' => true, 'image' => '']));
        }
    }
}
