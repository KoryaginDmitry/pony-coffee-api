<?php

namespace Tests\Feature\MixRoles\SiteData;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    /**
     * @param User|null $user
     * @return array
     */
    private function _getData(User $user = null) : array
    {
        $role = $user ? $user->getRole() : 'guest';

        $channels = config("options.Channels." . $role);

        if ($role === 'user') {
            $channels['channel'] = Str::replace('{id}', $user->id, Arr::get($channels, 'channel'));
        }

        return [
            'data' => [
                'channels' => $channels,
            ],
            'errors' => null,
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
        return 'SiteData.channels';
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
        $user = User::find(1);

        $this->callAuthorizedByUserRouteAction($user)
            ->assertOk()
            ->assertJson($this->_getData($user));
    }

    /**
     * testing from barista profile
     *
     * @return void
     */
    public function testFromBarista(): void
    {
        $user = User::find(2);

        $this->callAuthorizedByUserRouteAction($user)
            ->assertOk()
            ->assertJson($this->_getData($user));
    }

    /**
     * testing from user profile
     *
     * @return void
     */
    public function testFromUser(): void
    {
        $user = User::find(1);

        $this->callAuthorizedByUserRouteAction($user)
            ->assertOk()
            ->assertJson($this->_getData($user));
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
