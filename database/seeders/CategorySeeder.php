<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Kacamata Minus',
            'Kacamata Plus',
            'Kacamata Silinder',
            'Lensa Kontak',
            'Lensa Replacement',
            'Frame Plastik',
            'Frame Metal',
            'Aksesoris',
            'Obat Mata',
            'Perawatan Lensa',
            'Umum',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }
}
