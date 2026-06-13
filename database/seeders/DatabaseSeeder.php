<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       // L'ordre est important si tu as des clés étrangères
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
            ClientSeeder::class,
        ]);
    }
}
