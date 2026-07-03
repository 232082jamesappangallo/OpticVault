<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // Kamera
            [
                'name' => 'Canon EOS R5',
                'description' => 'Professional mirrorless camera dengan sensor full-frame 45MP',
                'category' => 'Kamera',
                'quantity' => 2,
                'location' => 'Studio A',
                'condition' => 'Baik'
            ],
            [
                'name' => 'Nikon Z9',
                'description' => 'Premium mirrorless dengan 8K video recording',
                'category' => 'Kamera',
                'quantity' => 1,
                'location' => 'Studio B',
                'condition' => 'Baik'
            ],
            [
                'name' => 'Sony A7IV',
                'description' => 'Full-frame mirrorless camera dengan 61MP resolution',
                'category' => 'Kamera',
                'quantity' => 3,
                'location' => 'Studio A',
                'condition' => 'Baik'
            ],
            
            // Lensa
            [
                'name' => 'Canon RF 24-70mm f/2.8',
                'description' => 'Professional zoom lens untuk landscape dan portrait',
                'category' => 'Lensa',
                'quantity' => 2,
                'location' => 'Studio A',
                'condition' => 'Baik'
            ],
            [
                'name' => 'Nikon Z 85mm f/1.8',
                'description' => 'Prime lens untuk portrait dengan fokus tajam',
                'category' => 'Lensa',
                'quantity' => 1,
                'location' => 'Studio B',
                'condition' => 'Baik'
            ],
            
            // Lighting
            [
                'name' => 'Godox SL-60W',
                'description' => 'LED studio light 60W dengan color temperature adjustable',
                'category' => 'Lighting',
                'quantity' => 4,
                'location' => 'Studio A',
                'condition' => 'Baik'
            ],
            [
                'name' => 'Aputure MC 4-Light Kit',
                'description' => 'Portable LED lighting kit untuk location shooting',
                'category' => 'Lighting',
                'quantity' => 1,
                'location' => 'Storage',
                'condition' => 'Baik'
            ],
            
            // Tripod & Stand
            [
                'name' => 'Manfrotto MT055XPRO3',
                'description' => 'Professional aluminum tripod dengan ball head',
                'category' => 'Tripod',
                'quantity' => 3,
                'location' => 'Studio A',
                'condition' => 'Baik'
            ],
            [
                'name' => 'Light Stand Neewer 2M',
                'description' => 'Adjustable light stand untuk lighting equipment',
                'category' => 'Tripod',
                'quantity' => 5,
                'location' => 'Studio B',
                'condition' => 'Baik'
            ],
            
            // Background
            [
                'name' => 'Seamless Paper Background White',
                'description' => 'Seamless background paper 2.72m x 11m warna putih',
                'category' => 'Background',
                'quantity' => 2,
                'location' => 'Storage',
                'condition' => 'Baik'
            ],
            [
                'name' => 'Backdrop Stand Kit',
                'description' => 'Professional backdrop stand system dengan background roller',
                'category' => 'Background',
                'quantity' => 1,
                'location' => 'Studio A',
                'condition' => 'Baik'
            ],
            
            // Audio
            [
                'name' => 'Shure SM7B Microphone',
                'description' => 'Professional cardioid dynamic microphone',
                'category' => 'Audio',
                'quantity' => 1,
                'location' => 'Studio B',
                'condition' => 'Baik'
            ],
            [
                'name' => 'Rode Wireless GO',
                'description' => 'Compact wireless microphone system',
                'category' => 'Audio',
                'quantity' => 2,
                'location' => 'Studio A',
                'condition' => 'Baik'
            ],
            
            // Aksesoris
            [
                'name' => 'Polarizing Filter 77mm',
                'description' => 'Polarizing filter untuk mengurangi refleksi dan saturasi warna',
                'category' => 'Aksesoris',
                'quantity' => 3,
                'location' => 'Storage',
                'condition' => 'Baik'
            ],
            [
                'name' => 'Memory Card SanDisk 128GB',
                'description' => 'High-speed SD card untuk recording video 4K',
                'category' => 'Aksesoris',
                'quantity' => 8,
                'location' => 'Studio A',
                'condition' => 'Baik'
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
