<?php

namespace Tests\Feature;

use Fillincode\Swagger\Parser\TestParser;
use Fillincode\Tests\BaseFillincodeTestCase;
use Fillincode\Tests\Contracts\DocIgnoreContract;
use Fillincode\Tests\Contracts\InvalidateContract;
use Fillincode\Tests\Contracts\InvalidParametersContract;
use Fillincode\Tests\Contracts\JobContract;
use Fillincode\Tests\Contracts\NotificationContract;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Testing\TestResponse;
use Laravel\Passport\Passport;
use ReflectionException;

abstract class BaseApiTestCase extends BaseFillincodeTestCase
{
    protected string $config_key = 'api';

    /**
     * Выполнение запроса
     *
     * @throws ReflectionException
     */
    private function callRouteAction(string $user_key, array $data = [], array $parameters = []): TestResponse
    {
        $route = $this->getRouteByName();
        $method = $route->methods()[0];
        $uri = route($this->getRouteName(), $parameters);

        if ($this->checkContract(JobContract::class)) {
            Queue::fake();
        }

        if ($this->checkContract(NotificationContract::class)) {
            Notification::fake();
        }

        $this->callSeedMethod($user_key);
        $this->callMockMethod($user_key);

        $testResponse = $this->json($method, $uri, $data);

        if (! $this->checkContract(DocIgnoreContract::class)) {
            (new TestParser)->makeAutoDoc($testResponse);
        }

        return $testResponse;
    }

    /**
     * Creating a request from an authorized User
     *
     * @throws ReflectionException
     */
    private function callAuthorizedByUserRouteAction($user, array $data = [], array $parameters = []): TestResponse
    {
        Passport::actingAs($user, ['*']);

        return $this->callRouteAction('user', $data, $parameters);
    }

    /**
     * Creating a request from an authorized Barista
     *
     * @throws ReflectionException
     */
    private function callAuthorizedByBaristaRouteAction($user, array $data = [], array $parameters = []): TestResponse
    {
        Passport::actingAs($user, ['*']);

        return $this->callRouteAction('barista', $data, $parameters);
    }

    /**
     * Execute a request from an authorized user
     *
     * @throws ReflectionException
     */
    public function testFromUser(): void
    {
        $this->callAuthorizedByUserRouteAction(
            $this->getUser(),
            $this->getValidData('user'),
            $this->getParameters('user')
        )->assertStatus($this->getCode('user'));

        $this->callJobsMethod('user');
        $this->callNotifyMethod('user');
    }

    /**
     * Execute a request from an authorized user
     *
     * @throws ReflectionException
     */
    public function testFromBarista(): void
    {
        $this->callAuthorizedByBaristaRouteAction(
            $this->getBarista(),
            $this->getValidData('barista'),
            $this->getParameters('barista')
        )->assertStatus($this->getCode('barista'));

        $this->callJobsMethod('barista');
        $this->callNotifyMethod('barista');
    }

    /**
     * Fulfilling a request from a guest
     *
     * @throws ReflectionException
     */
    public function testFromGuest(): void
    {
        $this->callRouteAction(
            'guest',
            $this->getValidData('guest'),
            $this->getParameters('guest')
        )->assertStatus($this->getCode('guest'));

        $this->callJobsMethod('guest');
        $this->callNotifyMethod('guest');
    }

    /**
     * Тестирование промежуточного ПО маршрута
     */
    public function testMiddleware(): void
    {
        $this->assertRouteHasExactMiddleware(
            $this->getMiddleware()
        );
    }

    /**
     * Sending invalid data from an authorized User
     *
     * @throws ReflectionException
     */
    public function testSendFromUserNotValidData(): void
    {
        if (! $this->checkContract(InvalidateContract::class)) {
            $this->markTestSkipped('Тест пропущен, так как вызываемый класс не реализует интерфейс передачи невалидных данных');
        }

        $this->callAuthorizedByUserRouteAction(
            $this->getUser(),
            $this->getInvalidData('user'),
            $this->getParameters('user')
        )->assertStatus($this->getInvalidDataCode('user'));
    }

    /**
     * Sending invalid data from an authorized Barista
     *
     * @throws ReflectionException
     */
    public function testSendFromBaristaNotValidData(): void
    {
        if (! $this->checkContract(InvalidateContract::class)) {
            $this->markTestSkipped('Тест пропущен, так как вызываемый класс не реализует интерфейс передачи невалидных данных');
        }

        $this->callAuthorizedByBaristaRouteAction(
            $this->getBarista(),
            $this->getInvalidData('barista'),
            $this->getParameters('barista')
        )->assertStatus($this->getInvalidDataCode('barista'));
    }

    /**
     * Sending invalid data from a guest
     *
     * @throws ReflectionException
     */
    public function testSendFromGuestNotValidData(): void
    {
        if (! $this->checkContract(InvalidateContract::class)) {
            $this->markTestSkipped('Тест пропущен, так как вызываемый класс не реализует интерфейс передачи невалидных данных');
        }

        $this->callRouteAction(
            'guest',
            $this->getInvalidData('guest'),
            $this->getParameters('guest')
        )->assertStatus($this->getInvalidDataCode('guest'));
    }

    /**
     * Executes a request transmitting invalid data from an authorized User
     *
     * @throws ReflectionException
     */
    public function testSendInvalidParametersFromUser(): void
    {
        if (! $this->checkContract(InvalidParametersContract::class)) {
            $this->markTestSkipped('Тест пропущен, так как вызываемый класс не реализует интерфейс передачи невалидных параметров');
        }

        $this->callAuthorizedByUserRouteAction(
            $this->getUser(),
            $this->getValidData('user'),
            $this->getInvalidParameters('user')
        )->assertStatus($this->getInvalidParametersCode('user'));
    }

    /**
     * Executes a request transmitting invalid data from an authorized Barista
     *
     * @throws ReflectionException
     */
    public function testSendInvalidParametersFromBarista(): void
    {
        if (! $this->checkContract(InvalidParametersContract::class)) {
            $this->markTestSkipped('Тест пропущен, так как вызываемый класс не реализует интерфейс передачи невалидных параметров');
        }

        $this->callAuthorizedByBaristaRouteAction(
            $this->getBarista(),
            $this->getValidData('barista'),
            $this->getInvalidParameters('barista')
        )->assertStatus($this->getInvalidParametersCode('barista'));
    }

    /**
     * Performs a request transmitting invalid data from an unauthorized user
     *
     * @throws ReflectionException
     */
    public function testSendInvalidParametersFromGuest(): void
    {
        if (! $this->checkContract(InvalidParametersContract::class)) {
            $this->markTestSkipped('Тест пропущен, так как вызываемый класс не реализует интерфейс передачи невалидных параметров');
        }

        $this->callRouteAction(
            'guest',
            $this->getValidData('guest'),
            $this->getInvalidParameters('guest')
        )->assertStatus($this->getInvalidParametersCode('guest'));
    }
}
