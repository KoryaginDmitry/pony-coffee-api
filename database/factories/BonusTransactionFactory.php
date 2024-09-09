<?php

namespace Database\Factories;

use App\Enums\BonusTranslationEnum;
use App\Models\BonusTransaction;
use App\Models\CoffeePot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BonusTransaction>
 */
class BonusTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::role('user')->inRandomOrder()->value('id'),
            'barista_id' => User::role('barista')->inRandomOrder()->value('id'),
            'coffee_pot_id' => CoffeePot::query()->inRandomOrder()->value('id'),
            'type' => BonusTranslationEnum::Accrual,
            'count' => fake()->numberBetween(1, 10),
        ];
    }
}
