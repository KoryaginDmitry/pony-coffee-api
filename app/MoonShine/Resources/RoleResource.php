<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Components\Link;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Fields\Field;
use MoonShine\Fields\ID;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use Spatie\Permission\Models\Role;

/**
 * @extends ModelResource<Role>
 */
class RoleResource extends ModelResource
{
    protected string $model = Role::class;

    protected string $column = 'name';

    public function title(): string
    {
        return __('moonshine::ui.resource.roles');
    }

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make(__('moonshine::ui.fields.name'), 'name'),
            BelongsToMany::make(__('moonshine::ui.fields.users'), 'users', resource: new UserResource)
                ->onlyLink(),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make(__('moonshine::ui.fields.name'), 'name'),
            BelongsToMany::make(__('moonshine::ui.fields.users'), 'users', resource: new UserResource)
                ->inLine(' ', true, fn (User $user) => Link::make(
                    (new UserResource)->detailPageUrl($user), $user->email
                )),
        ];
    }

    public function formFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make(__('moonshine::ui.fields.name'), 'name'),
            BelongsToMany::make(__('moonshine::ui.fields.users'), 'users', resource: new UserResource)
                ->selectMode()
                ->asyncSearch(),
        ];
    }

    /**
     * @param  Role  $item
     * @return array<string, string[]|string>
     *
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
