<?php

namespace Tests\Feature\Api\BonusTransaction;

use App\Models\CoffeePot;
use App\Models\User;
use Fillincode\Tests\Contracts\CodeContract;
use Fillincode\Tests\Contracts\InvalidateContract;
use Fillincode\Tests\Contracts\ValidateContract;
use Tests\Feature\BaseApiTestCase;

class UseTest extends BaseApiTestCase implements CodeContract, InvalidateContract, ValidateContract
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'api.transaction.use';
    }

    /**
     * {@inheritDoc}
     */
    public function getMiddleware(): array
    {
        return ['api', 'auth'];
    }

    /**
     * {@inheritDoc}
     */
    public function codes(string $user_key): array
    {
        return [
            'guest' => 401,
            'user' => 403,
            'barista' => 200,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function validData(string $user_key): array
    {
        return [
            'count' => 1,
            'user_id' => User::query()->inRandomOrder()->value('id'),
            'coffee_pot_id' => CoffeePot::query()->inRandomOrder()->value('id'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function invalidData(string $user_key): array
    {
        return [
            'count' => 100,
            'user_id' => 1234,
            'coffee_pot_id' => 1234,
        ];
    }
}
