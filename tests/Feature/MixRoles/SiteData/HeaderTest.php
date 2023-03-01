<?php

namespace Tests\Feature\MixRoles\SiteData;

use App\Models\User;
use Tests\TestCase;

class HeaderTest extends TestCase
{
    /**
     * Create data for response
     *
     * @param string $userType
     * @return array
     */
    private function _getData(string $userType) : array
    {
        return [
            'data' => [
                'header' => config('options.header.' . $userType)
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
        return 'SiteData.header';
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
            ->assertJson($this->_getData('admin'));
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
            ->assertJson($this->_getData('barista'));
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
            ->assertJson($this->_getData('user'));
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
            ->assertJson($this->_getData('guest'));
    }
}
