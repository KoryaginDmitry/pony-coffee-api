<?php

namespace Tests\Feature\AdminPanel\MoonShineUser;

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
            'resourceUri' => 'moon-shine-user-resource',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function validData(string $user_key): array
    {
        return [
            'name' => str('name')->contains('id') ? 1 : \Illuminate\Support\Str::random(12),
            'moonshine_user_role_id' => str('moonshine_user_role_id')->contains('id') ? 1 : \Illuminate\Support\Str::random(12),
            'email' => fake()->email(),
            'password' => "qk[n4H/U_h,#q7d42%Z*Nk*mU3,t\:",
            'password_repeat' => "qk[n4H/U_h,#q7d42%Z*Nk*mU3,t\:",
        ];
    }
}
