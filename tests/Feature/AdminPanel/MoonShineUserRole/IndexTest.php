<?php

namespace Tests\Feature\AdminPanel\MoonShineUserRole;

use Fillincode\Tests\Contracts\CodeContract;
use Fillincode\Tests\Contracts\DocIgnoreContract;
use Fillincode\Tests\Contracts\ParametersContract;
use Tests\Feature\BaseAdminPanelTestCase;

class IndexTest extends BaseAdminPanelTestCase implements CodeContract, DocIgnoreContract, ParametersContract
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
            'resourceUri' => 'moon-shine-user-role-resource',
            'pageUri' => 'index-page',
        ];
    }
}
