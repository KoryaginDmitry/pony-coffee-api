<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
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
