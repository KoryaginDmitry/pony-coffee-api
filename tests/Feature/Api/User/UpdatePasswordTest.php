<?php

namespace Tests\Feature\Api\User;

use Fillincode\Tests\Contracts\ValidateContract;
use Illuminate\Support\Str;
use Tests\Feature\BaseApiTestCase;

class UpdatePasswordTest extends BaseApiTestCase implements ValidateContract
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'api.user.newPassword';
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
        $password = Str::password();

        return [
            'password' => $password,
            'password_confirmation' => $password,
        ];
    }
}
