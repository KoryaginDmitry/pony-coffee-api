<?php

namespace Tests\Feature\MixRoles\Profile;

use App\Models\User;
use Tests\TestCase;

class GetProfileTest extends TestCase
{
    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'profile';
    }

    /**
     * @return void
     */
    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('role:admin,barista,user', 'api');
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromAdmin(): void
    {
        $this->callAuthorizedByUserRouteAction(User::find(1))
            ->assertOk();
    }

    /**
     * testing from barista profile
     *
     * @return void
     */
    public function testFromBarista(): void
    {
        $this->callAuthorizedByUserRouteAction(User::find(2))
            ->assertOk();
    }

    /**
     * testing from user profile
     *
     * @return void
     */
    public function testFromUser(): void
    {
        $this->callAuthorizedByUserRouteAction(User::find(3))
            ->assertOk();
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromGuest(): void
    {
        $this->callRouteAction()
            ->assertNotFound();
    }
}
