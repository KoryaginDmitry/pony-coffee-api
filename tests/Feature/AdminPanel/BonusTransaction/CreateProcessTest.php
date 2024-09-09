<?php

namespace Tests\Feature\AdminPanel\BonusTransaction;

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
            'resourceUri' => 'bonus-transaction-resource',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function validData(string $user_key): array
    {
        return [
            'user_id' => \Illuminate\Support\Facades\DB::table('users')->select('id')->limit(1)->value('id'),
            'barista_id' => \Illuminate\Support\Facades\DB::table('users')->select('id')->limit(1)->value('id'),
            'coffee_pot_id' => \Illuminate\Support\Facades\DB::table('coffee_pots')->select('id')->limit(1)->value('id'),
            'type' => collect(['accrual', 'write-off'])->random(),
            'count' => fake()->numberBetween(1, 10),
        ];
    }
}