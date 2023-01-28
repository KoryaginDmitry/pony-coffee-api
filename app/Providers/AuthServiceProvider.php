<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Auth\Access\Response;
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

        Passport::loadKeysFrom(__DIR__.'/../../storage/oauth');
        
        Gate::define(
            'isAdmin',
            function (User $user) {
                return $user->isAdmin()
                    ? Response::allow()
                    : Response::denyWithStatus(404);
            }
        );

        Gate::define(
            'isBarista',
            function (?User $user) {
                return $user->isBarista()
                    ? Response::allow()
                    : Response::denyWithStatus(404);
            }
        );

        Gate::define(
            'isUser',
            function (?User $user) {
                return $user->isUser()
                    ? Response::allow()
                    : Response::denyWithStatus(404);
            }
        );

        Gate::define(
            'isUserOrIsAdmin',
            function (User $user) {
                return $user->isAdmin() || $user->isUser()
                    ? Response::allow()
                    : Response::denyWithStatus(404);
            }
        );

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
