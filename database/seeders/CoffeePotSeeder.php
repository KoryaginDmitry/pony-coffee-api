<?php

namespace Database\Seeders;

use App\Models\CoffeePot;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class CoffeePotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var Collection<CoffeePot> $coffeePots */
        $coffeePots = CoffeePot::factory(3)->create();
        $baristas = User::role('barista')->get();

        foreach ($coffeePots as $coffeePot) {
            $coffeePot->employers()->sync($baristas);
        }
    }
}
