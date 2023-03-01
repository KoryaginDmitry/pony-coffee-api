<?php

namespace Tests\Feature\MixRoles\Profile;

use App\Http\Middleware\CodeVerification;
use App\Models\User;
use Tests\TestCase;

class ProfileUpdateEmailTest extends TestCase
{
    private array $data = [
        'email' => 'test@mail.ru',
        'code' => 12345
    ];

    /**
     * @var array
     */
    private array $inValidData = [
        'email' => '',
        'code' => 'test'
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'profile.email';
    }

    /**
     * @return void
     */
    public function middleware() : void
    {
        $this->assertRouteHasExactMiddleware('role:user,admin', 'api', 'codeVerification:email');
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromAdmin(): void
    {
        $this->withoutMiddleware(CodeVerification::class);

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
        $this->withoutMiddleware(CodeVerification::class);

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
        $this->withoutMiddleware(CodeVerification::class);

        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            $this->inValidData
        )->assertUnprocessable();
    }
}
