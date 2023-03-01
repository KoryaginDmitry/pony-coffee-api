<?php

namespace Tests\Feature\Guest\SendCode;

use App\Http\Middleware\ReCaptcha;
use App\Models\User;
use App\Support\Classes\SendCode\EmailCode;
use Mockery\MockInterface;
use Tests\TestCase;
use Mockery;

class EmailTest extends TestCase
{
    /**
     * @var array
     */
    private array $data = [
        'email' => ''
    ];

    /**
     * @var array|string[]
     */
    private array $invalidData = [
        'email' => ''
    ];

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
        return 'emailCode.guest';
    }

    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('api', 'reCaptcha', 'role:guest');
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
        $this->withoutMiddleware(ReCaptcha::class);

        $this->getEmail();

        $this->instance(
            EmailCode::class,
            Mockery::mock(EmailCode::class, static function (MockInterface $mock) {
                $mock->shouldReceive('sendCode')->once();
            })
        );

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
            ->assertJsonCount('1', 'errors.message');
    }
}
