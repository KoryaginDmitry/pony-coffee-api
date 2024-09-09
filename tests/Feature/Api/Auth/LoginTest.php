<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Fillincode\Tests\Contracts\CodeContract;
use Fillincode\Tests\Contracts\ValidateContract;
use Tests\Feature\BaseApiTestCase;

class LoginTest extends BaseApiTestCase implements CodeContract, ValidateContract
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'api.auth.login';
    }

    /**
     * {@inheritDoc}
     */
    public function getMiddleware(): array
    {
        return ['api', 'guest.api'];
    }

    /**
     * {@inheritDoc}
     */
    public function validData(string $user_key): array
    {
        return [
            'email' => User::query()->first()->email,
            'password' => 'password',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function codes(string $user_key): array
    {
        return [
            'guest' => 200,
            'user' => 403,
            'barista' => 403,
        ];
    }
}
