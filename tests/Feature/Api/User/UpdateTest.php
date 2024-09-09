<?php

namespace Tests\Feature\Api\User;

use Fillincode\Tests\Contracts\ValidateContract;
use Tests\Feature\BaseApiTestCase;

class UpdateTest extends BaseApiTestCase implements ValidateContract
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'api.user.update';
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
    public function validData(string $user_key): array
    {
        return [
            'name' => fake()->name(),
            'last_name' => fake()->lastName(),
        ];
    }
}
