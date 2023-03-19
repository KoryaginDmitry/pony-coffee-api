<?php

namespace Tests\Feature\Admin\Barista;

use App\Models\User;
use Tests\TestCase;

class CreateBaristaTest extends TestCase
{
    /**
     * Data for create barista
     *
     * @var array|string[]
     */
    private array $data = [
        'name' => 'testName',
        'last_name' => 'testLastName',
        'password' => 'pass12345',
        'password_confirmation' => 'pass12345',
        'phone' => '+79614133813',
        'coffee_pot_id' => '1'
    ];

    /**
     * Not valid data
     *
     * @var array
     */
    private array $notValidateData = [
        'name' => 'q23',
        'last_name' => 'vas234',
        'password' => 'qwerty',
        'password_confirmation' => '12345',
        'phone' => '9614133813',
        'coffee_pot_id' => '25'
    ];

    public function getRouteName(): string
    {
        return 'barista.create';
    }

    /**
     * @return void
     */
    public function testMiddleware() : void
    {
       $this->assertRouteHasExactMiddleware('role:admin', 'api');
    }

    /**
     * Create barista from admin profile
     *
     * @return void
     */
    public function testFromAdmin() : void
    {
        $this->callAuthorizedByUserRouteAction(User::find(1), $this->data)
            ->assertCreated();
    }

    /**
     * Create barista profile from user profile
     *
     * @return void
     */
    public function testFromBarista() : void
    {
        $this->callAuthorizedByUserRouteAction(User::find(2), $this->data)
            ->assertNotFound();
    }

    /**
     * Create barista profile from barista profile
     *
     * @return void
     */
    public function testFromUser() : void
    {
        $this->callAuthorizedByUserRouteAction(User::find(3), $this->data)
            ->assertNotFound();
    }

    /**
     * Create barista profile from guest
     *
     * @return void
     */
    public function testFromGuest() : void
    {
        $this->callRouteAction($this->data)->assertNotFound();
    }

    /**
     * @return void
     */
    public function testValidate() : void
    {
        $this->callAuthorizedByUserRouteAction(User::find(1), $this->notValidateData)
            ->assertUnprocessable()
            ->assertJsonCount('6', $this->errorPath);
    }
}
