<?php

namespace Tests\Feature\Barista\Bonus;

use App\Models\User;
use Tests\TestCase;

class WroteTest extends TestCase
{
    /**
     * @var array|int[]
     */
    private array $parameters = [
        'user' => 3
    ];

    private array $data = [
        'count' => 1
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'bonus.wrote';
    }

    /**
     * @return void
     */
    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('role:barista', 'api');
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
            $this->data,
            $this->parameters
        )->assertNotFound();
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
            $this->data,
            $this->parameters
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
            $this->data,
            $this->parameters
        )->assertNotFound();
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromGuest(): void
    {
        $this->callRouteAction(parameters: $this->parameters)
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testValidateWhenCountNotValidate() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(2),
            ['count' => 15],
            $this->parameters
        )->assertUnprocessable();
    }
}
