<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRole = Role::query()->where('name', 'user')->first();
        $baristaRole = Role::query()->where('name', 'barista')->first();

        User::factory(3)->hasAttached($userRole)->create();
        User::factory(2)->hasAttached($baristaRole)->create();
    }
}
