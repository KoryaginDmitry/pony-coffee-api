<?php

namespace Tests\Feature\Admin\CoffeePot;

use App\Models\User;
use Tests\TestCase;

class CoffeePotGetOneTest extends TestCase
{
    /**
     * @var array|int[]
     */
    private array $parameters = [
        'coffeePot' => 1
    ];

    /**
     * @return string
     */
    public function getRouteName(): string
    {
        return 'coffeePot.getOne';
    }

    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('role:admin', 'api');
    }

    public function testFromAdmin() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            parameters: $this->parameters
        )->assertOk();
    }

    public function testFromBarista() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(2),
            parameters: $this->parameters
        )->assertNotFound();
    }

    public function testFromUser() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            parameters: $this->parameters
        )->assertNotFound();
    }

    public function testFromGuest() : void
    {
        $this->callRouteAction(
            parameters: $this->parameters
        )->assertNotFound();
    }
}
