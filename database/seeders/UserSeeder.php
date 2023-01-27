<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create(
            [
                'password' => Hash::make('adminadmin'),
                'phone' => '+79999999999',
                'role_id' => 1
            ]
        );

        User::factory()->create(
            [
                'password' => Hash::make('baristabarista'),
                'phone' => '+79998888888',
                'role_id' => 2
            ]
        );

        User::factory()->create(
            [
                'password' => Hash::make('useruser'),
                'phone' => "+79997777777",
                'role_id' => 3
            ]
        );
        
        User::factory()->create(
            [
                'password' => Hash::make('useruseruser'),
                'phone' => "+79996666666",
                'role_id' => 3
            ]
        );
    }
}
