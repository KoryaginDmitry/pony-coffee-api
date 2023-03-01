<?php

namespace Tests\Feature\MixRoles\MailSendCode;

use App\Http\Middleware\ReCaptcha;
use App\Models\User;
use App\Support\Classes\SendCode\EmailCode;
use Mockery\MockInterface;
use Tests\TestCase;
use Mockery;

class SendTest extends TestCase
{
    /**
     * @var array
     */
    private array $data = [
        'email' => 'test@mail.ru'
    ];

    /**
     * @var array
     */
    private array $invalidData = [
        'email' => ''
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'verificationEmail';
    }

    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('api', 'reCaptcha', 'role:user,admin');
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromAdmin(): void
    {
        $this->withoutMiddleware(ReCaptcha::class);

        $this->instance(
            EmailCode::class,
            Mockery::mock(EmailCode::class, static function (MockInterface $mock) {
                $mock->shouldReceive('sendCode')->once();
            })
        );

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
        $this->withoutMiddleware(ReCaptcha::class);

        $this->instance(
            EmailCode::class,
            Mockery::mock(EmailCode::class, static function (MockInterface $mock) {
                $mock->shouldReceive('sendCode')->once();
            })
        );

        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            $this->data
        )->assertCreated();
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
        $this->withoutMiddleware(ReCaptcha::class);

        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            $this->invalidData
        )
            ->assertUnprocessable()
            ->assertJsonCount('1', 'errors.message');
    }
}
