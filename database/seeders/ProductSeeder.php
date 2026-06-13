<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 20 produits normaux
        Product::factory()->count(20)->create();

        // 3 produits en rupture (pour tester le badge rouge)
        Product::factory()->count(3)->outOfStock()->create();

        // 4 produits en stock faible (pour tester le dashboard)
        Product::factory()->count(4)->lowStock()->create();
    }
}