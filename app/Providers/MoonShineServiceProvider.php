<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\BonusTransactionResource;
use App\MoonShine\Resources\CoffeePotResource;
use App\MoonShine\Resources\ReviewResource;
use App\MoonShine\Resources\RoleResource;
use App\MoonShine\Resources\UserResource;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Providers\MoonShineApplicationServiceProvider;
use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends MoonShineApplicationServiceProvider
{
    protected function menu(): array
    {
        return [
            MenuGroup::make(static fn () => __('moonshine::ui.resource.system'), [
                MenuItem::make(
                    static fn () => __('moonshine::ui.resource.admins_title'),
                    new MoonShineUserResource
                ),
                MenuItem::make(
                    static fn () => __('moonshine::ui.resource.role_title'),
                    new MoonShineUserRoleResource
                ),
            ]),

            MenuGroup::make('Мониторинг', [
                MenuItem::make('Pulse', asset(config('pulse.path'))),
                MenuItem::make('Horizon', asset(config('horizon.path'))),
                MenuItem::make('Log-viewer', asset(config('log-viewer.route_path'))),
                MenuItem::make('Telescope', asset(config('telescope.path'))),
            ]),

            MenuGroup::make('Основное', [
                MenuItem::make(__('moonshine::ui.resource.users'), new UserResource),
                MenuItem::make(__('moonshine::ui.resource.role_title'), new RoleResource),
                MenuItem::make(__('moonshine::ui.resource.coffee_pots'), new CoffeePotResource),
                MenuItem::make(__('moonshine::ui.resource.reviews'), new ReviewResource),
                MenuItem::make(__('moonshine::ui.resource.bonus_transactions'), new BonusTransactionResource),
            ]),
        ];
    }
}
