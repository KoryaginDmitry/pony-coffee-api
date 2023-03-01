<?php

namespace Tests\Feature\Admin\Barista;

use App\Models\User;
use Tests\TestCase;

class DeleteBaristaTest extends TestCase
{
    /**
     * Data for route
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
        return 'barista.delete';
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
        $this->callRouteAction(parameters: $this->parameters)
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testDeleteBaristaThatDoesNotExist() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(2),
            parameters: ['barista' => 13]
        )->assertNotFound();
    }
}
