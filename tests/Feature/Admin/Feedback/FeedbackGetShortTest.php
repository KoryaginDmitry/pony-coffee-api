<?php

namespace Tests\Feature\Admin\Feedback;

use App\Models\User;
use Tests\TestCase;

class FeedbackGetShortTest extends TestCase
{
    /**
     * @var array|int[]
     */
    private array $parameters = [
        'filter' => 'users'
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'feedback.short';
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
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            parameters: $this->parameters
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
        )->assertNotFound();
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

    /**
     * testing filter coffeePot
     *
     * @return void
     */
    public function testShortCoffeePot(): void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            parameters: ['filter' => 'coffeePots']
        )->assertOk();
    }

    /**
     * testing filter coffeePot
     *
     * @return void
     */
    public function testValidateFilter(): void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            parameters: ['filter' => 'test']
        )->assertNotFound();
    }
}
