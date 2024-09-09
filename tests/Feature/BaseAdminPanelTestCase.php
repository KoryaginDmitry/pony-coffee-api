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
use ReflectionException;

abstract class BaseAdminPanelTestCase extends BaseFillincodeTestCase
{
    protected string $config_key = 'admin_panel';

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
     * Creating a request from an authorized Admin
     *
     * @throws ReflectionException
     */
    private function callAuthorizedByAdminRouteAction($user, array $data = [], array $parameters = []): TestResponse
    {
        $this->be($user, 'moonshine');

        return $this->callRouteAction('admin', $data, $parameters);
    }

    /**
     * Execute a request from an authorized user
     *
     * @throws ReflectionException
     */
    public function testFromAdmin(): void
    {
        $this->callAuthorizedByAdminRouteAction(
            $this->getAdmin(),
            $this->getValidData('admin'),
            $this->getParameters('admin')
        )->assertStatus($this->getCode('admin'));

        $this->callJobsMethod('admin');
        $this->callNotifyMethod('admin');
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
     * Sending invalid data from an authorized Admin
     *
     * @throws ReflectionException
     */
    public function testSendFromAdminNotValidData(): void
    {
        if (! $this->checkContract(InvalidateContract::class)) {
            $this->markTestSkipped('Тест пропущен, так как вызываемый класс не реализует интерфейс передачи невалидных данных');
        }

        $this->callAuthorizedByAdminRouteAction(
            $this->getAdmin(),
            $this->getInvalidData('admin'),
            $this->getParameters('admin')
        )->assertStatus($this->getInvalidDataCode('admin'));
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
     * Executes a request transmitting invalid data from an authorized Admin
     *
     * @throws ReflectionException
     */
    public function testSendInvalidParametersFromAdmin(): void
    {
        if (! $this->checkContract(InvalidParametersContract::class)) {
            $this->markTestSkipped('Тест пропущен, так как вызываемый класс не реализует интерфейс передачи невалидных параметров');
        }

        $this->callAuthorizedByAdminRouteAction(
            $this->getAdmin(),
            $this->getValidData('admin'),
            $this->getInvalidParameters('admin')
        )->assertStatus($this->getInvalidParametersCode('admin'));
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
