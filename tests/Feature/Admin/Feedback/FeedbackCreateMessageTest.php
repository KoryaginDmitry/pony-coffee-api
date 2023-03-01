<?php

namespace Tests\Feature\Admin\Feedback;

use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class FeedbackCreateMessageTest extends TestCase
{
    /**
     * @var array|string[]
     */
    private array $data = [
        'text' => 'hello'
    ];

    /**
     * @var array|int[]
     */
    private array $parameters = [
        'feedback' => 1
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'feedback.create.message';
    }

    /**
     * @return void
     */
    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('role:admin', 'api');
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromAdmin(): void
    {
        Event::fake();

        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            $this->data,
            $this->parameters
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
        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            $this->data,
            $this->parameters
        )->assertNotFound();
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
    public function testCreateMessageWhenFeedbackDoesNotExist(): void
    {
        $this->callRouteAction(
            $this->data,
            $this->parameters
        )->assertNotFound();
    }
}
