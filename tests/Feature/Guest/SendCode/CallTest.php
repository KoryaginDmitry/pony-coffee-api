<?php

namespace Tests\Feature\Guest\SendCode;

use App\Http\Middleware\ReCaptcha;
use App\Models\User;
use App\Support\Classes\SendCode\PhoneCode;
use Mockery\MockInterface;
use Tests\TestCase;
use Mockery;

class CallTest extends TestCase
{
    /**
     * @var array|string[]
     */
    private array $data = [
        'phone' => '+79998888888'
    ];

    /**
     * @var array|string[]
     */
    private array $invalidData = [
        'phone' => '96541233212'
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'sendLoginCode';
    }

    /**
     * @return void
     */
    public function testMiddleware(): void
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

        $this->instance(
            PhoneCode::class,
            Mockery::mock(PhoneCode::class, static function (MockInterface $mock) {
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
            ->assertUnprocessable();
    }
}
