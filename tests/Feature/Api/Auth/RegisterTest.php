<?php

namespace Tests\Feature\Api\Auth;

use Fillincode\Tests\Contracts\CodeContract;
use Fillincode\Tests\Contracts\ValidateContract;
use Illuminate\Support\Str;
use Tests\Feature\BaseApiTestCase;

class RegisterTest extends BaseApiTestCase implements CodeContract, ValidateContract
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'api.auth.register';
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
    public function codes(string $user_key): array
    {
        return [
            'guest' => 201,
            'user' => 403,
            'barista' => 403,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function validData(string $user_key): array
    {
        $password = Str::password();

        return [
            'name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'email' => fake()->email,
            'password' => $password,
            'password_confirmation' => $password,
        ];
    }
}
