<?php

namespace Tests\Feature\Barista\User;

use App\Http\Middleware\CodeVerification;
use App\Models\User;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    private array $data = [
        'name' => 'testUser',
        'phone' => '+79621233212',
        'code' => 1241
    ];

    private array $notValidateData = [
        'name' => 'asd12335',
        'phone' => '9541234354',
        'code' => '1241241'
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'barista.user.create';
    }

    /**
     * @return void
     */
    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('role:barista', 'api', 'codeVerification');
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
        $this->withoutMiddleware(CodeVerification::class);

        $this->callAuthorizedByUserRouteAction(
            User::find(2),
            $this->data
        )->assertCreated();
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

    /**
     * Test validate
     *
     * @return void
     */
    public function testValidated() : void
    {
        $this->withoutMiddleware(CodeVerification::class);

        $this->callAuthorizedByUserRouteAction(
            User::find(2),
            $this->notValidateData
        )
            ->assertUnprocessable()
            ->assertJsonCount('2', 'errors.message');

    }
}
