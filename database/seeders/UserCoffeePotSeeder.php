<?php

namespace Database\Seeders;

use App\Models\UserCoffeePot;
use Illuminate\Database\Seeder;

class UserCoffeePotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        UserCoffeePot::factory()->create(
            [
                'user_id' => 2,
                'coffee_pot_id' => 2
            ]
        );
    }
}
