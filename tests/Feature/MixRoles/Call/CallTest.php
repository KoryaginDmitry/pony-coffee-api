<?php

namespace Tests\Feature\MixRoles\Call;

use App\Models\User;
use App\Support\Classes\SendCode\PhoneCode;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery\MockInterface;
use Tests\TestCase;
use Mockery;

class CallTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * @var array|string[]
     */
    private array $data = [
        'phone' => '+79121234312'
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
        return 'call';
    }

    /**
     * @return void
     */
    public function testMiddleware(): void
    {
        $this->assertRouteHasExactMiddleware('api', 'reCaptcha');
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromAdmin(): void
    {
        $this->instance(
            PhoneCode::class,
            Mockery::mock(PhoneCode::class, static function (MockInterface $mock) {
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
        $this->instance(
            PhoneCode::class,
            Mockery::mock(PhoneCode::class, static function (MockInterface $mock) {
                $mock->shouldReceive('sendCode')->once();
            })
        );

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
        $this->instance(
            PhoneCode::class,
            Mockery::mock(PhoneCode::class, static function (MockInterface $mock) {
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
        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            $this->invalidData
        )->assertUnprocessable();
    }
}
