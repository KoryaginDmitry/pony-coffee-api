<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(
            function ($user, string $token) {
                return 'https://example.com/reset-password?token='.$token;
            }
        );

        Passport::loadKeysFrom(__DIR__.'/../../storage/oauth');

        Gate::define(
            'access-to-appeal',
            function (User $user, Feedback $feedback) {
                return $user->isAdmin() || $user->id === $feedback->user_id
                    ? Response::allow()
                    : Response::denyWithStatus(404);
            }
        );
    }
}
