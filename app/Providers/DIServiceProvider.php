<?php

namespace App\Providers;

use App\Contracts\Repositories\BonusTransactionRepositoryContract;
use App\Contracts\Services\AuthServiceContract;
use App\Contracts\Services\BonusTransactionServiceContract;
use App\Contracts\Services\ReviewServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Repositories\BonusTransactionRepository;
use App\Services\AuthService;
use App\Services\BonusTransactionService;
use App\Services\ReviewService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class DIServiceProvider extends ServiceProvider
{
    public array $bindings = [
        // services
        AuthServiceContract::class => AuthService::class,
        BonusTransactionServiceContract::class => BonusTransactionService::class,
        ReviewServiceContract::class => ReviewService::class,
        UserServiceContract::class => UserService::class,
        // repositories
        BonusTransactionRepositoryContract::class => BonusTransactionRepository::class,
    ];
}
