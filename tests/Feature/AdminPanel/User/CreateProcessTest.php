<?php

namespace Tests\Feature\AdminPanel\User;

use Fillincode\Tests\Contracts\CodeContract;
use Fillincode\Tests\Contracts\DocIgnoreContract;
use Fillincode\Tests\Contracts\ParametersContract;
use Fillincode\Tests\Contracts\ValidateContract;
use Tests\Feature\BaseAdminPanelTestCase;

class CreateProcessTest extends BaseAdminPanelTestCase implements CodeContract, DocIgnoreContract, ParametersContract, ValidateContract
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'moonshine.crud.store';
    }

    /**
     * {@inheritDoc}
     */
    public function getMiddleware(): array
    {
        return ['moonshine', 'MoonShine\Http\Middleware\Authenticate'];
    }

    /**
     * {@inheritDoc}
     */
    public function codes(string $user_key): array
    {
        return [
            'guest' => 401,
            'admin' => 302,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function parameters(string $user_key): array
    {
        return [
            'resourceUri' => 'user-resource',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function validData(string $user_key): array
    {
        return [
            'name' => str(fake()->realTextBetween(1, 255))->replace(["'", ';', '  ', '"'], '')->limit(255, ''),
            'last_name' => '',
            'email' => fake()->email(),
            'email_verified_at' => '',
            'password' => 'd848fBq1f36|zP_C!)[~-L:42%Alv4&w',
            'password_repeat' => 'd848fBq1f36|zP_C!)[~-L:42%Alv4&w',
        ];
    }
}
