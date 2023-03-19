<?php

namespace Tests\Feature\Guest\Auth;

use App\Http\Middleware\CodeVerification;
use App\Http\Middleware\ReCaptcha;
use App\Models\User;
use Tests\TestCase;

class LoginEmailTest extends TestCase
{
    /**
     * @var array
     */
    private array $data = [
        'email' => '',
        'code' => 12345
    ];

    /**
     * @var array
     */
    private array $invalidData = [
        'email' => '',
        'password' => 12345
    ];

    /**
     * @return void
     */
    private function getEmail() : void
    {
        $this->data['email'] = User::find(3)->email;
    }

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'login.email';
    }

    /**
     * @return void
     */
    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('api', 'role:guest', 'reCaptcha', 'codeVerification:email');
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

        $this->getEmail();

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
            ->assertUnprocessable()
            ->assertJsonCount('2', $this->errorPath);
    }
}
