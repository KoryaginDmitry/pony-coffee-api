<?php

namespace Database\Seeders;

use App\Models\CoffeePot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoffeePotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CoffeePot::factory()
            ->count(3)
            ->create();
    }
}
