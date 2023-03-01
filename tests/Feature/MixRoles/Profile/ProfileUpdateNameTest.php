<?php

namespace Tests\Feature\MixRoles\Profile;

use App\Models\User;
use Tests\TestCase;

class ProfileUpdateNameTest extends TestCase
{
    private array $data = [
        'name' => 'qwerty'
    ];

    /**
     * @var array
     */
    private array $inValidData = [
        'name' => ''
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'profile.name';
    }

    /**
     * @return void
     */
    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('role:user,admin', 'api');
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromAdmin(): void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            $this->data
        )->assertOk();
    }

    /**
     * testing from barista profile
     *
     * @return void
     */
    public function testFromBarista(): void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(2),
            $this->data
        )->assertNotFound();
    }

    /**
     * testing from user profile
     *
     * @return void
     */
    public function testFromUser(): void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            $this->data
        )->assertOk();
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromGuest(): void
    {
        $this->callRouteAction($this->data)
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testValidate() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            $this->inValidData
        )
            ->assertUnprocessable()
            ->assertJsonCount('1', 'errors.message');
    }
}
