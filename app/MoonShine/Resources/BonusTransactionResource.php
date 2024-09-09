<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Enums\BonusTranslationEnum;
use App\Models\BonusTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Enum;
use MoonShine\Fields\Field;
use MoonShine\Fields\ID;
use MoonShine\Fields\Number;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<BonusTransaction>
 */
class BonusTransactionResource extends ModelResource
{
    protected string $model = BonusTransaction::class;

    public function title(): string
    {
        return __('moonshine::ui.resource.bonus_transactions');
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
                BelongsTo::make(__('moonshine::ui.fields.barista'), 'barista', resource: new UserResource)->badge('primary'),
                BelongsTo::make(__('moonshine::ui.fields.coffee_pot'), 'coffeePot', resource: new CoffeePotResource)->badge('primary'),

                Enum::make(__('moonshine::ui.fields.type'), 'type', fn (BonusTransaction $transaction) => __("enums.{$transaction->type->value}"))
                    ->attach(BonusTranslationEnum::class),

                Number::make(__('moonshine::ui.fields.count'), 'count')->min(1)->max(10),
            ]),
        ];
    }

    /**
     * @param  BonusTransaction  $item
     * @return array<string, string[]|string>
     *
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'barista_id' => ['required', 'integer', 'exists:users,id'],
            'coffee_pot_id' => ['required', 'integer', 'exists:coffee_pots,id'],
            'type' => ['required', 'string', Rule::in(BonusTranslationEnum::getValues())],
            'count' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }
}
