<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected bool $seed = true;

    /**
     * Getting the route name
     *
     * @return string
     */
    abstract public function getRouteName(): string;

    /**
     * Testing middleware for route
     *
     * @return void
     */
    abstract public function testMiddleware() : void;

    /**
     * testing from admin profile
     *
     * @return void
     */
    abstract public function testFromAdmin(): void;

    /**
     * testing from barista profile
     *
     * @return void
     */
    abstract public function testFromBarista(): void;

    /**
     * testing from user profile
     *
     * @return void
     */
    abstract public function testFromUser(): void;

    /**
     * testing from admin profile
     *
     * @return void
     */
    abstract public function testFromGuest(): void;

    /**
     * Getting a route object by route name
     *
     * @return \Illuminate\Routing\Route
     */
    private function getRouteByName(): \Illuminate\Routing\Route
    {
        $route = Route::getRoutes()
            ->getByName($this->getRouteName());

        if (!$route) {
            $this->fail("Route with name \"{$this->getRouteName()}\" not found!");
        }

        return $route;
    }

    /**
     * Checking if the route contains passed middleware
     *
     * @param ...$names
     * @return $this
     */
    private function assertRouteContainsMiddleware(...$names) : self
    {
        $route = $this->getRouteByName();

        foreach ($names as $name) {
            $this->assertContains(
                $name,
                $route->middleware(),
                "Route doesn't contain middleware \"$name\""
            );
        }

        return $this;
    }

    /**
     * Checking if the route contains only passed middleware
     *
     * @param ...$names
     * @return $this
     */
    protected function assertRouteHasExactMiddleware(...$names) : self
    {
        $route = $this->getRouteByName();

        $this->assertRouteContainsMiddleware(...$names);
        $this->assertCount(
            count($names),
            $route->middleware(),
            'Route contains not the same amount of middleware.'
        );

        return $this;
    }

    /**
     * Execution of a request
     *
     * @param array $data
     * @param array $parameters
     * @return TestResponse
     */
    protected function callRouteAction(array $data = [], array $parameters = []): TestResponse
    {
        $route = $this->getRouteByName();
        $method = $route->methods()[0];
        $url = route($this->getRouteName(), $parameters);

        return $this->json($method, $url, $data);
    }

    /**
     * Making a request from an authorized user
     *
     * @param User $user
     * @param array $data
     * @param array $parameters
     * @return TestResponse
     */
    protected function callAuthorizedByUserRouteAction(User $user, array $data = [], array $parameters = []): TestResponse
    {
        $this->actingAs($user, 'api');

        return $this->callRouteAction($data, $parameters);
    }
}
