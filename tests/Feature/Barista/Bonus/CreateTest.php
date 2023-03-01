<?php

namespace Tests\Feature\Barista\Bonus;

use App\Models\User;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /**
     * @var array|int[]
     */
    private array $parameters = [
        'user' => 3
    ];

    /**
     * @var array|int[]
     */
    private array $data = [
        'count' => 5
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'bonus.create';
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
        )->assertCreated();
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
        $this->callRouteAction(
            $this->data,
            $this->parameters
        )->assertNotFound();
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
