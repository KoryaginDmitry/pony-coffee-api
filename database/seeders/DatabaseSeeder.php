<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Phone;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        User::factory()->create(
            [
                'password' => Hash::make('adminadmin'),
                'phone' => '+79999999999',
                'agreement' => '1',
                'role_id' => 1
            ]
        );

        User::factory()->create(
            [
                'password' => Hash::make('baristabarista'),
                'phone' => '+79998888888',
                'agreement' => '1',
                'role_id' => 2
            ]
        );

        User::factory()->create(
            [
                'password' => Hash::make('useruser'),
                'phone' => "+79997777777",
                'agreement' => '1',
                'role_id' => 3
            ]
        );
    }
}
