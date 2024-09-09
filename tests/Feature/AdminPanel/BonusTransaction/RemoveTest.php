<?php

namespace Tests\Feature\AdminPanel\BonusTransaction;

use Fillincode\Tests\Contracts\CodeContract;
use Fillincode\Tests\Contracts\DocIgnoreContract;
use Fillincode\Tests\Contracts\ParametersContract;
use Illuminate\Support\Facades\DB;
use Tests\Feature\BaseAdminPanelTestCase;

class RemoveTest extends BaseAdminPanelTestCase implements CodeContract, DocIgnoreContract, ParametersContract
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'moonshine.crud.destroy';
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
            'resourceUri' => 'bonus-transaction-resource',
            'resourceItem' => DB::table('bonus_transactions')->first()->id,
        ];
    }
}