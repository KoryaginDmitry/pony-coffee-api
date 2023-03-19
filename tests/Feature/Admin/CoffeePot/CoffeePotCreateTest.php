<?php

namespace Tests\Feature\Admin\CoffeePot;

use App\Models\User;
use Tests\TestCase;

class CoffeePotCreateTest extends TestCase
{
    /**
     * @var array|string[]
     */
    private array $data = [
        'address' => 'testAddress',
        'name' => 'testCoffeePot'
    ];

    /**
     * @var array|string[]
     */
    private array $notValidateData = [
        'address' => '',
        'name' => 'asd wad awd'
    ];

    public function getRouteName(): string
    {
        return 'coffeePot.create';
    }

    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('role:admin', 'api');
    }

    public function testFromAdmin() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            $this->data
        )->assertCreated();
    }

    public function testFromBarista() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(2),
            $this->data
        )->assertNotFound();
    }

    public function testFromUser() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            $this->data
        )->assertNotFound();
    }

    public function testFromGuest() : void
    {
        $this->callRouteAction(
            $this->data
        )->assertNotFound();
    }

    public function testValidate() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            $this->notValidateData
        )
            ->assertUnprocessable()
            ->assertJsonCount('1', $this->errorPath);
    }
}
