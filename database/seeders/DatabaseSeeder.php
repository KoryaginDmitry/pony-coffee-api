<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('passport:install');

        $this->call([
            AdminSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            CoffeePotSeeder::class,
            ReviewSeeder::class,
            BonusTransactionSeeder::class,
        ]);
    }
}
