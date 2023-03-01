<?php

namespace Tests\Feature\Admin\Barista;

use App\Models\User;
use Tests\TestCase;

class GetOneBaristaTest extends TestCase
{
    /**
     * Parameters for routes
     *
     * @var array|int[]
     */
    private array $parameters = [
        'barista' => 2,
    ];

    /**
     * @return string
     */
    public function getRouteName(): string
    {
        return 'barista.getOne';
    }

    /**
     * @return void
     */
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
        )->assertOk();
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
        $this->callRouteAction(parameters: $this->parameters)
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testGetBaristaThatDoesNotExist() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            parameters: ['barista' => 25]
        )->assertNotFound();
    }

}
