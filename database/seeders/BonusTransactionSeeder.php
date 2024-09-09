<?php

namespace Database\Seeders;

use App\Models\BonusTransaction;
use Illuminate\Database\Seeder;

class BonusTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BonusTransaction::factory(15)->create();
    }
}
