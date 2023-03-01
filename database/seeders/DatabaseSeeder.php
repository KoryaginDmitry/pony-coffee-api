<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() : void
    {
        $this->call(
            [
                RoleSeeder::class,
                UserSeeder::class,
                CoffeePotSeeder::class,
                UserCoffeePotSeeder::class,
                NotificationSeeder::class,
                BonusSeeder::class,
                FeedbackSeeder::class,
                MessageSeeder::class
            ]
        );
    }
}
