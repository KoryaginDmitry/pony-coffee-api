<?php

namespace Tests\Feature\User\Bonus;

use App\Models\User;
use Tests\TestCase;

class getInfoTest extends TestCase
{

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'bonus.information';
    }

    /**
     * @return void
     */
    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('role:user', 'api');
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromAdmin(): void
    {
        $this->callAuthorizedByUserRouteAction(User::find(1))
            ->assertNotFound();
    }

    /**
     * testing from barista profile
     *
     * @return void
     */
    public function testFromBarista(): void
    {
        $this->callAuthorizedByUserRouteAction(User::find(2))
            ->assertNotFound();
    }

    /**
     * testing from user profile
     *
     * @return void
     */
    public function testFromUser(): void
    {
        $this->callAuthorizedByUserRouteAction(User::find(3))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                'count',
                'dateBurn'
            ]]);
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
