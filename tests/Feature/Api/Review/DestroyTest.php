<?php

namespace Tests\Feature\Api\Review;

use Fillincode\Tests\Contracts\CodeContract;
use Fillincode\Tests\Contracts\InvalidParametersCodeContract;
use Fillincode\Tests\Contracts\InvalidParametersContract;
use Fillincode\Tests\Contracts\ParametersContract;
use Tests\Feature\BaseApiTestCase;

class DestroyTest extends BaseApiTestCase implements CodeContract, InvalidParametersCodeContract, InvalidParametersContract, ParametersContract
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'api.review.delete';
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
            'user' => 204,
            'barista' => 404,
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
