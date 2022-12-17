<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::factory()->create(
            [
                'name' => 'admin'
            ],
        );

        Role::factory()->create(
            [
                'name' => 'barista'
            ],
        );

        Role::factory()->create(
            [
                'name' => 'user'
            ],
        );
    }
}
