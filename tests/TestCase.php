<?php

namespace Tests;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use MoonShine\Models\MoonshineUser;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     */
    protected bool $seed = true;

    protected function getUser(): User
    {
        return User::withoutRole('barista')->first();
    }

    protected function getBarista(): User
    {
        return User::role('barista')->first();
    }

    protected function getAdmin(): Model|MoonshineUser
    {
        return MoonshineUser::query()->first();
    }
}
