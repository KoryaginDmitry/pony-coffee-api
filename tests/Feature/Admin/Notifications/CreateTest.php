<?php

namespace Tests\Feature\Admin\Notifications;

use App\Models\User;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /**
     * @var array
     */
    private array $data = [
        'text' => 'bla bla bla',
        'site' => '1',
        'telegram' => '0',
        'email' => '1'
    ];

    /**
     * @var array
     */
    private array $notValidateData = [
        'text' => 'bla bla bla',
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'notification.create';
    }

    /**
     * @return void
     */
    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('role:admin', 'api');
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
        )->assertCreated();
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
        )->assertNotFound();
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
        )->assertNotFound();
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

    public function testValidate() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            $this->notValidateData
        )->assertUnprocessable();
    }
}
