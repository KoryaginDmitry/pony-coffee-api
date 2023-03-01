<?php

namespace Tests\Feature\Admin\Barista;

use App\Models\User;
use Tests\TestCase;

class UpdateBaristaTest extends TestCase
{
    /**
     * Data for update barista profile
     *
     * @var array
     */
    private array $data = [
        'name' => 'testName',
        'last_name' => 'testLastName',
        'phone' => '79541234312',
        'coffee_pot_id' => '1'
    ];

    /**
     * @var array
     */
    private array $notValidateData = [
        'name' => 'adw1245r',
        'last_name' => 'add2432',
        'phone' => '9541234312',
        'coffee_pot_id' => '214352'
    ];
    /**
     * Data for route
     *
     * @var array
     */
    private array $parameters = [
        'barista' => 2
    ];

    /**
     * @return string
     */
    public function getRouteName(): string
    {
        return 'barista.update';
    }

    /**
     * @return void
     */
    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('role:admin', 'api');
    }

    public function testFromAdmin() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            $this->data,
            $this->parameters
        )->assertOk();
    }

    public function testFromBarista() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(2),
            $this->data,
            $this->parameters
        )->assertNotFound();
    }

    public function testFromUser() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            $this->data,
            $this->parameters
        )->assertNotFound();
    }

    public function testFromGuest() : void
    {
        $this->callRouteAction(
            $this->data,
            $this->parameters
        )->assertNotFound();
    }

    public function testValidate() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            $this->notValidateData,
            $this->parameters
        )->assertUnprocessable();
    }

    /**
     * @return void
     */
    public function testUpdateBaristaThatDoesNotExist() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            $this->data,
            ['barista' => 124]
        )->assertNotFound();
    }
}
