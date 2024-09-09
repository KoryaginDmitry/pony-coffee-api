<?php

namespace Tests\Feature\AdminPanel\User;

use Fillincode\Tests\Contracts\CodeContract;
use Fillincode\Tests\Contracts\DocIgnoreContract;
use Fillincode\Tests\Contracts\ParametersContract;
use Fillincode\Tests\Contracts\ValidateContract;
use Illuminate\Support\Facades\DB;
use Tests\Feature\BaseAdminPanelTestCase;

class EditProcessTest extends BaseAdminPanelTestCase implements CodeContract, DocIgnoreContract, ParametersContract, ValidateContract
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'moonshine.crud.update';
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
            'resourceItem' => DB::table('users')->first()->id,
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
            'password' => "xq?d4\PuMuEV?5psDb:NOZ2{2oPVY}F#",
            'password_repeat' => "xq?d4\PuMuEV?5psDb:NOZ2{2oPVY}F#",
        ];
    }
}
