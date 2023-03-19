<?php

namespace Tests\Feature\MixRoles\Profile;

use App\Models\User;
use Tests\TestCase;

class ProfileUpdatePasswordTest extends TestCase
{
    private array $data = [
        'password' => 'qwerty12345',
        'password_confirmation' => 'qwerty12345'
    ];

    /**
     * @var array
     */
    private array $inValidData = [
        'password' => 'qwerty12345',
        'password_confirmation' => '12345qwerty'
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'profile.password';
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
        )->assertOk();
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
            ->assertJsonCount('1', $this->errorPath);
    }
}
