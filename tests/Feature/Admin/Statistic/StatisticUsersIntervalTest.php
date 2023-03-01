<?php

namespace Tests\Feature\Admin\Statistic;

use App\Models\User;
use Tests\TestCase;

class StatisticUsersIntervalTest extends TestCase
{
    /**
     * @var array|int[]
     */
    private array $parameters = [
        'interval' => 7
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'statistic.barista';
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
     * @return void
     */
    public function testMonthInterval() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            parameters: ['interval' => 31]
        )->assertOk();
    }

    /**
     * Testing the interval when it is not equal to seven and thirty-one
     *
     * @return void
     */
    public function TestIntervalWhenAnInvalidValueIsPassed() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            parameters: ['interval' => 15]
        )->assertNotFound();
    }
}
