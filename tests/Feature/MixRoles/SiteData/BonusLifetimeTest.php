<?php

namespace Tests\Feature\MixRoles\SiteData;

use App\Models\User;
use Tests\TestCase;

class BonusLifetimeTest extends TestCase
{
    /**
     * Create data for response
     *
     * @return array
     */
    private function _getData() : array
    {
        return [
            'data' => [
                'lifetime' => config('options.bonus.lifetime')
            ],
            'errors' => [],
            'status' => true
        ];
    }

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'SiteData.bonus.lifetime';
    }

    /**
     * @return void
     */
    public function testMiddleware(): void
    {
        $this->assertRouteHasExactMiddleware('api');
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromAdmin(): void
    {
        $this->callAuthorizedByUserRouteAction(User::find(1))
            ->assertOk()
            ->assertJson($this->_getData());
    }

    /**
     * testing from barista profile
     *
     * @return void
     */
    public function testFromBarista(): void
    {
        $this->callAuthorizedByUserRouteAction(User::find(2))
            ->assertOk()
            ->assertJson($this->_getData());
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
            ->assertJson($this->_getData());
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromGuest(): void
    {
        $this->callRouteAction()
            ->assertOk()
            ->assertJson($this->_getData());
    }
}
