<?php

namespace Tests\Feature\Api\Review;

use App\Models\CoffeePot;
use Fillincode\Tests\Contracts\CodeContract;
use Fillincode\Tests\Contracts\InvalidateContract;
use Fillincode\Tests\Contracts\ValidateContract;
use Tests\Feature\BaseApiTestCase;

class StoreTest extends BaseApiTestCase implements CodeContract, InvalidateContract, ValidateContract
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'api.review.store';
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
            'user' => 201,
            'barista' => 201,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function validData(string $user_key): array
    {
        return [
            'coffee_pot_id' => CoffeePot::query()->inRandomOrder()->value('id'),
            'grade' => fake()->numberBetween(1, 5),
            'text' => fake()->realTextBetween(150, 350),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function invalidData(string $user_key): array
    {
        return [
            'coffee_pot_id' => 12345,
            'grade' => 7,
            'text' => 12,
        ];
    }
}
