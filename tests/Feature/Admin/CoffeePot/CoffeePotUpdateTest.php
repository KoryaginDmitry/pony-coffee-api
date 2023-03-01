<?php

namespace Tests\Feature\Admin\CoffeePot;

use App\Models\User;
use Tests\TestCase;

class CoffeePotUpdateTest extends TestCase
{
    /**
     * @var array|string[]
     */
    private array $data = [
        'name' => 'TestName',
        'address' => 'TestAddress'
    ];

    /**
     * @var array|string[]
     */
    private array $notValidateData = [
        'name' => '',
        'address' => ''
    ];

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
        return 'coffeePot.update';
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
        $this->callAuthorizedByUserRouteAction(User::find(1), $this->data, $this->parameters)
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testFromBarista(): void
    {
        $this->callAuthorizedByUserRouteAction(User::find(2), $this->data, $this->parameters)
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testFromUser(): void
    {
        $this->callAuthorizedByUserRouteAction(User::find(3), $this->data, $this->parameters)
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testFromGuest(): void
    {
        $this->callRouteAction($this->data, $this->parameters)
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testValidate() : void
    {
        $this->callAuthorizedByUserRouteAction(User::find(1), $this->notValidateData, $this->parameters)
            ->assertUnprocessable()
            ->assertJsonCount('1', 'errors.message');
    }
}
