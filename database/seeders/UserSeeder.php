<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        User::factory()->create(
            [
                'password' => Hash::make('admin-admin'),
                'phone' => '+79999999999',
                'role_id' => 1
            ]
        );

        User::factory()->create(
            [
                'password' => Hash::make('barista-barista'),
                'phone' => '+79998888888',
                'role_id' => 2
            ]
        );

        User::factory()->create(
            [
                'password' => Hash::make('user-user'),
                'phone' => "+79997777777",
                'role_id' => 3
            ]
        );

        User::factory()->create(
            [
                'password' => Hash::make('user-user-user'),
                'phone' => "+79996666666",
                'role_id' => 3
            ]
        );
    }
}
