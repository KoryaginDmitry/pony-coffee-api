<?php

namespace Tests\Feature\User\Feedback;

use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CreateMessageTest extends TestCase
{
    /**
     * @var array
     */
    private array $data = [
        'text' => 'test text'
    ];

    /**
     * @var array
     */
    private array $parameters = [
        'feedback' => 1
    ];

    /**
     * @var array
     */
    private array $invalidData = [
        'text' => ''
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'feedback.createMessage';
    }

    /**
     * @return void
     */
    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('role:user', 'api');
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
            $this->data,
            $this->parameters
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
            $this->data,
            $this->parameters
        )->assertNotFound();
    }

    /**
     * testing from user profile
     *
     * @return void
     */
    public function testFromUser(): void
    {
        Event::fake();

        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            $this->data,
            $this->parameters
        )->assertCreated();
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromGuest(): void
    {
        $this->callRouteAction(
            $this->data,
            $this->parameters
        )->assertNotFound();
    }

    /**
     * @return void
     */
    public function testValidate() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            $this->invalidData,
            $this->parameters
        )
            ->assertUnprocessable()
            ->assertJsonCount('1', $this->errorPath);
    }

    /**
     * @return void
     */
    public function testInvalidParameters() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            $this->data,
            ['feedback' => 123]
        )->assertNotFound();
    }
}
