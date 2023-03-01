<?php

namespace Tests\Feature\MixRoles\Logout;

use App\Models\User;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'logout';
    }

    /**
     * @return void
     */
    public function testMiddleware(): void
    {
        $this->assertRouteHasExactMiddleware('api', 'auth');
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromAdmin(): void
    {
        $this->callAuthorizedByUserRouteAction(User::find(1))
            ->assertNoContent();
    }

    /**
     * testing from barista profile
     *
     * @return void
     */
    public function testFromBarista(): void
    {
        $this->callAuthorizedByUserRouteAction(User::find(2))
            ->assertNoContent();
    }

    /**
     * testing from user profile
     *
     * @return void
     */
    public function testFromUser(): void
    {
        $this->callAuthorizedByUserRouteAction(User::find(3))
            ->assertNoContent();
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromGuest(): void
    {
        $this->callRouteAction()
            ->assertUnauthorized();
    }
}
