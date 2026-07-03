<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin Studio',
            'email' => 'admin@opticvault.com',
            'password' => bcrypt('password123'),
        ]);

        // Seed items only
        $this->call([
            ItemSeeder::class,
        ]);
    }
}
