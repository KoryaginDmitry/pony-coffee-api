<?php

namespace App\Providers;

use App\Models\Review;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteBindServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::bind('userReview', function (string $value) {
            return Review::query()->where([
                'id' => $value,
                'user_id' => auth()->id(),
            ])->firstOrFail();
        });
    }
}
