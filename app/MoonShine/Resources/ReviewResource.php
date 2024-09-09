<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Field;
use MoonShine\Fields\ID;
use MoonShine\Fields\Number;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<Review>
 */
class ReviewResource extends ModelResource
{
    protected string $model = Review::class;

    public function title(): string
    {
        return __('moonshine::ui.resource.reviews');
    }

    /**
     * @return list<Field>
     */
    public function fields(): array
    {
        return [
            Block::make('', [
                ID::make()->sortable(),
                BelongsTo::make(__('moonshine::ui.fields.user'), 'user', resource: new UserResource)->badge('primary'),
                BelongsTo::make(__('moonshine::ui.fields.coffee_pot'), 'coffeePot', resource: new CoffeePotResource)->badge('primary'),
                Number::make(__('moonshine::ui.fields.grade'), 'grade')
                    ->stars()
                    ->min(1)
                    ->max(5),
                Text::make(__('moonshine::ui.fields.review'), 'text'),
            ]),
        ];
    }

    /**
     * @param  Review  $item
     * @return array<string, string[]|string>
     *
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'coffee_pot_id' => ['required', 'integer', 'exists:coffee_pots,id'],
            'grade' => ['required', 'integer', 'min:1', 'max:5'],
            'text' => ['required', 'string'],
        ];
    }
}
