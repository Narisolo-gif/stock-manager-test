<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => fake()->words(3, true),
            'description' => fake()->sentence(10),
            'price'       => fake()->randomFloat(2, 1, 999),
            'quantity'    => fake()->numberBetween(0, 100),
        ];
    }

    /**
     * État : produit en rupture de stock (utile pour tester les alertes)
     */
    public function outOfStock(): static
    {
        return $this->state(['quantity' => 0]);
    }

    /**
     * État : stock faible (≤ 5)
     */
    public function lowStock(): static
    {
        return $this->state(['quantity' => fake()->numberBetween(1, 5)]);
    }
}