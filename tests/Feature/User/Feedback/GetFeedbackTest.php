<?php

namespace Tests\Feature\User\Feedback;

use App\Models\User;
use Tests\TestCase;

class GetFeedbackTest extends TestCase
{
    /**
     * @var array
     */
    private array $parameters = [
        'feedback' => 1,
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'feedback.getForUser';
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
            parameters: $this->parameters
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
            parameters: $this->parameters
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
            parameters: $this->parameters
        )->assertOk();
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromGuest(): void
    {
        $this->callRouteAction(parameters: $this->parameters)
            ->assertNotFound();
    }

    public function testInvalidParameters() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            parameters: ['feedback' => 124]
        )->assertNotFound();
    }
}
