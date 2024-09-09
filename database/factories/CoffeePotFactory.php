<?php

namespace Database\Factories;

use App\Models\CoffeePot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CoffeePot>
 */
class CoffeePotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'address' => fake()->address,
        ];
    }
}
