<?php

namespace Tests\Feature\Api\Review;

use Fillincode\Tests\Contracts\CodeContract;
use Fillincode\Tests\Contracts\InvalidateContract;
use Fillincode\Tests\Contracts\InvalidParametersCodeContract;
use Fillincode\Tests\Contracts\InvalidParametersContract;
use Fillincode\Tests\Contracts\ParametersContract;
use Fillincode\Tests\Contracts\ValidateContract;
use Tests\Feature\BaseApiTestCase;

class UpdateTest extends BaseApiTestCase implements CodeContract, InvalidateContract, InvalidParametersCodeContract, InvalidParametersContract, ParametersContract, ValidateContract
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'api.review.update';
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
            'user' => 200,
            'barista' => 404,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function validData(string $user_key): array
    {
        return [
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
            'grade' => 7,
            'text' => 12,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function parameters(string $user_key): array
    {
        return [
            'userReview' => $this->getUser()->reviews()->first(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function invalidParameters(string $user_key): array
    {
        return [
            'userReview' => 12345,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function codesForInvalidParameters(): array
    {
        return [
            'guest' => 401,
            'user' => 404,
            'barista' => 404,
        ];
    }
}
