<?php

namespace Tests\Feature\MixRoles\Profile;

use App\Http\Middleware\CodeVerification;
use App\Http\Middleware\ReCaptcha;
use App\Models\User;
use Tests\TestCase;

class ProfileUpdatePhoneTest extends TestCase
{
    private array $data = [
        'phone' => '+79431233212',
        'code' => '1234'
    ];

    /**
     * @var array
     */
    private array $inValidData = [
        'phone' => '',
        'code' => 'test'
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'profile.phone';
    }

    /**
     * @return void
     */
    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware(
            'role:admin,barista,user',
            'api',
            'codeVerification',
            'reCaptcha'
        );
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromAdmin(): void
    {
        $this->withoutMiddleware([CodeVerification::class, ReCaptcha::class]);

        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            $this->data
        )->assertOk();
    }

    /**
     * testing from barista profile
     *
     * @return void
     */
    public function testFromBarista(): void
    {
        $this->withoutMiddleware([CodeVerification::class, ReCaptcha::class]);

        $this->callAuthorizedByUserRouteAction(
            User::find(2),
            $this->data
        )->assertOk();
    }

    /**
     * testing from user profile
     *
     * @return void
     */
    public function testFromUser(): void
    {
        $this->withoutMiddleware([CodeVerification::class, ReCaptcha::class]);

        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            $this->data
        )->assertOk();
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

    /**
     * @return void
     */
    public function testValidate() : void
    {
        $this->withoutMiddleware([CodeVerification::class, ReCaptcha::class]);

        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            $this->inValidData
        )
            ->assertUnprocessable()
            ->assertJsonCount('3', $this->errorPath);
    }
}
