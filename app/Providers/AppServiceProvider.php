<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Pulse\Entry;
use Laravel\Pulse\Facades\Pulse;
use Laravel\Pulse\Value;
use MoonShine\Models\MoonshineUser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Pulse::user(fn ($user) => [
            'name' => $user->name,
        ]);

        Pulse::filter(function (Entry|Value $entry) {
            return ! (auth()->user() instanceof MoonshineUser);
        });
    }
}
