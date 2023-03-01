<?php

namespace Tests\Feature\Guest\Auth;

use App\Http\Middleware\CodeVerification;
use App\Http\Middleware\ReCaptcha;
use App\Models\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * @var array
     */
    private array $data = [
        'name' => 'testUser',
        'phone' => '+79281233212',
        'code' => 1234,
        'password' => 'qwerty123',
        'password_confirmation' => 'qwerty123',
        'agreement' => 1
    ];

    /**
     * @var array
     */
    private array $invalidData = [
        'name' => 'testUser',
        'phone' => '+792812332',
        'code' => 123441,
        'password' => 'qwerty123',
        'password_confirmation' => '1qwerty123',
        'agreement' => 0
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'register';
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
