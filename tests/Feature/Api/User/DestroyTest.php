<?php

namespace Tests\Feature\Api\User;

use Fillincode\Tests\Contracts\CodeContract;
use Tests\Feature\BaseApiTestCase;

class DestroyTest extends BaseApiTestCase implements CodeContract
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'api.user.destroy';
    }

    /**
     * {@inheritDoc}
     */
    public function getMiddleware(): array
    {
        return ['api', 'auth'];
    }

    public function codes(string $user_key): array
    {
        return [
            'guest' => 401,
            'user' => 204,
            'barista' => 204,
        ];
    }
}
