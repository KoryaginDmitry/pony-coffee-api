<?php

namespace Tests\Feature\Guest\Auth;

use App\Http\Middleware\ReCaptcha;
use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * @var array
     */
    private array $data = [
        'phone' => '+79998888888',
        'password' => 'barista-barista'
    ];

    /**
     * @var array
     */
    private array $invalidData = [
        'phone' => '+799988888',
        'password' => 'barista-barista'
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'login';
    }

    /**
     * @return void
     */
    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('api', 'role:guest', 'reCaptcha');
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
            User::find(1),
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
            User::find(1),
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
        $this->withoutMiddleware(ReCaptcha::class);

        $this->callRouteAction($this->data)
            ->assertCreated();
    }

    /**
     * @return void
     */
    public function testValidate() : void
    {
        $this->withoutMiddleware(ReCaptcha::class);

        $this->callRouteAction($this->invalidData)
            ->assertUnprocessable()
            ->assertJsonCount('1', $this->errorPath);
    }
}
