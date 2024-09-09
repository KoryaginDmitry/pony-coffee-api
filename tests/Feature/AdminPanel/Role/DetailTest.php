<?php

namespace Tests\Feature\AdminPanel\Role;

use Fillincode\Tests\Contracts\CodeContract;
use Fillincode\Tests\Contracts\DocIgnoreContract;
use Fillincode\Tests\Contracts\ParametersContract;
use Fillincode\Tests\Contracts\ValidateContract;
use Illuminate\Support\Facades\DB;
use Tests\Feature\BaseAdminPanelTestCase;

class DetailTest extends BaseAdminPanelTestCase implements CodeContract, DocIgnoreContract, ParametersContract, ValidateContract
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'moonshine.resource.page';
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
            'admin' => 200,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function parameters(string $user_key): array
    {
        return [
            'resourceUri' => 'role-resource',
            'pageUri' => 'detail-page',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function validData(string $user_key): array
    {
        return [
            'resourceItem' => DB::table('roles')->first()->id,
        ];
    }
}