<?php

namespace Database\Factories;

use App\Models\CoffeePot;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::withoutRole('barista')->inRandomOrder()->value('id'),
            'coffee_pot_id' => CoffeePot::query()->inRandomOrder()->value('id'),
            'grade' => fake()->numberBetween(1, 5),
            'text' => fake()->realTextBetween(150, 350),
        ];
    }
}
