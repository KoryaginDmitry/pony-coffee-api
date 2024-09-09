<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\CoffeePot;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Components\Link;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Fields\Field;
use MoonShine\Fields\ID;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<CoffeePot>
 */
class CoffeePotResource extends ModelResource
{
    protected string $model = CoffeePot::class;

    protected string $column = 'address';

    public function title(): string
    {
        return __('moonshine::ui.resource.coffee_pots');
    }

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make(__('moonshine::ui.fields.name'), 'name'),
            Text::make(__('moonshine::ui.fields.address'), 'address'),
            HasMany::make(__('moonshine::ui.fields.reviews'), 'reviews')->onlyLink(),
            BelongsToMany::make(__('moonshine::ui.fields.employers'), 'employers', resource: new UserResource)->onlyLink(),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make(__('moonshine::ui.fields.name'), 'name'),
            Text::make(__('moonshine::ui.fields.address'), 'address'),
            HasMany::make(__('moonshine::ui.fields.reviews'), 'reviews')->creatable(),
            BelongsToMany::make(__('moonshine::ui.fields.employers'), 'employers', resource: new UserResource)
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
            Text::make(__('moonshine::ui.fields.address'), 'address'),
            HasMany::make(__('moonshine::ui.fields.reviews'), 'reviews')->creatable(),
            BelongsToMany::make(__('moonshine::ui.fields.employers'), 'employers', resource: new UserResource)
                ->selectMode()
                ->asyncSearch(asyncSearchQuery: fn (Builder $builder) => $builder->whereHas('roles', function (Builder $query) {
                    $query->where('name', 'barista');
                })),
        ];
    }

    /**
     * @param  CoffeePot  $item
     * @return array<string, string[]|string>
     *
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
        ];
    }
}
