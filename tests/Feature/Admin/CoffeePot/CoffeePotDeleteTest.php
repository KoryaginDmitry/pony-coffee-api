<?php

namespace Tests\Feature\Admin\CoffeePot;

use App\Models\User;
use Tests\TestCase;

class CoffeePotDeleteTest extends TestCase
{
    /**
     * @var array
     */
    private array $parameters = [
        'coffeePot' => 1
    ];

    public function getRouteName(): string
    {
        return 'coffeePot.delete';
    }

    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('role:admin', 'api');
    }

    /**
     * @return void
     */
    public function testFromAdmin() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            parameters: $this->parameters
        )->assertNoContent();
    }

    /**
     * @return void
     */
    public function testFromBarista() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(2),
            parameters: $this->parameters
        )->assertNotFound();
    }

    /**
     * @return void
     */
    public function testFromUser() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            parameters: $this->parameters
        )->assertNotFound();
    }

    /**
     * @return void
     */
    public function testFromGuest() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            parameters: ['coffeePot' => '12341']
        )->assertNotFound();
    }
}
