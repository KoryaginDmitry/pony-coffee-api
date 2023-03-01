<?php

namespace Tests\Feature\Guest\Auth;

use App\Http\Middleware\CodeVerification;
use App\Http\Middleware\ReCaptcha;
use App\Models\User;
use Tests\TestCase;

class LoginPhoneTest extends TestCase
{
    /**
     * @var array
     */
    private array $data = [
        'phone' => '+79998888888',
        'code' => 1234
    ];

    /**
     * @var array
     */
    private array $invalidData = [
        'phone' => '+79998881222',
        'password' => 1234
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'login.phone';
    }

    /**
     * @return void
     */
    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('api', 'role:guest', 'reCaptcha', 'codeVerification');
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
        $this->withoutMiddleware([ReCaptcha::class, CodeVerification::class]);

        $this->callRouteAction($this->data)
            ->assertCreated();
    }

    /**
     * @return void
     */
    public function testValidate() : void
    {
        $this->withoutMiddleware([ReCaptcha::class, CodeVerification::class]);

        $this->callRouteAction($this->invalidData)
            ->assertUnprocessable();
    }
}
