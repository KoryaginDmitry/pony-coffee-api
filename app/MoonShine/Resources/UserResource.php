<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use MoonShine\Components\Link;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Fields\Date;
use MoonShine\Fields\Email;
use MoonShine\Fields\Field;
use MoonShine\Fields\ID;
use MoonShine\Fields\Password;
use MoonShine\Fields\PasswordRepeat;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\Fields\Text;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use Spatie\Permission\Models\Role;

/**
 * @extends ModelResource<User>
 */
class UserResource extends ModelResource
{
    protected string $model = User::class;

    protected string $column = 'email';

    public function title(): string
    {
        return __('moonshine::ui.resource.users');
    }

    /**
     * @return list<Field>
     */
    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make(__('moonshine::ui.fields.user_name'), formatted: fn (User $user) => "$user->name $user->last_name"),
            Email::make(__('moonshine::ui.fields.email'), 'email'),
            Date::make(__('moonshine::ui.fields.email_verified_at'), 'email_verified_at'),

            BelongsToMany::make(__('moonshine::ui.fields.roles'), 'roles')
                ->inLine(' ', true, fn (Role $role) => Link::make(
                    (new RoleResource)->detailPageUrl($role), __("ui.roles.$role->name")
                )),

            HasMany::make(__('moonshine::ui.fields.reviews'), 'reviews', resource: new ReviewResource)
                ->onlyLink(),

            HasMany::make(__('moonshine::ui.fields.bonusTransactions'), 'bonusTransactions', resource: new BonusTransactionResource)
                ->onlyLink(),
        ];
    }

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function formFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make(__('moonshine::ui.fields.name'), 'name'),
            Text::make(__('moonshine::ui.fields.last_name'), 'last_name'),
            Email::make(__('moonshine::ui.fields.email'), 'email'),
            Date::make(__('moonshine::ui.fields.email_verified_ad'), 'email_verified_at'),

            Password::make(__('moonshine::ui.resource.password'), 'password')
                ->customAttributes(['autocomplete' => 'new-password'])
                ->eye(),

            PasswordRepeat::make(__('moonshine::ui.resource.repeat_password'), 'password_repeat')
                ->customAttributes(['autocomplete' => 'confirm-password'])
                ->eye(),

            BelongsToMany::make(__('moonshine::ui.fields.roles'), 'roles')
                ->inLine(' ', true, fn (Role $role) => Link::make(
                    (new RoleResource)->detailPageUrl($role), __("ui.roles.$role->name")
                )),

            HasMany::make(__('moonshine::ui.fields.reviews'), 'reviews', resource: new ReviewResource)
                ->creatable(),

            HasMany::make(__('moonshine::ui.fields.bonusTransactions'), 'bonusTransactions', resource: new BonusTransactionResource)
                ->creatable(),
        ];
    }

    /**
     * @return list<Field>
     */
    public function detailFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make(__('moonshine::ui.fields.name'), formatted: fn (User $user) => "$user->name $user->last_name"),
            Email::make(__('moonshine::ui.fields.email'), 'email'),
            Date::make(__('moonshine::ui.fields.email_verified_ad'), 'email_verified_at'),

            BelongsToMany::make(__('moonshine::ui.fields.roles'), 'roles')
                ->inLine(' ', true, fn (Role $role) => Link::make(
                    (new RoleResource)->detailPageUrl($role), __("ui.roles.$role->name")
                )),

            HasMany::make(__('moonshine::ui.fields.reviews'), 'reviews', resource: new ReviewResource),

            HasMany::make(__('moonshine::ui.fields.bonusTransactions'), 'bonusTransactions', resource: new BonusTransactionResource),
        ];
    }

    /**
     * @param  User  $item
     * @return array<string, string[]|string>
     *
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($item->id), 'max:255'],
            'email_verified_at' => ['nullable', 'date'],
            'password' => $item->exists
                ? ['sometimes', 'nullable', 'min:6', 'required_with:password_repeat', 'same:password_repeat']
                : ['required', 'min:6', 'required_with:password_repeat', 'same:password_repeat'],
        ];
    }

    public function import(): ?ImportHandler
    {
        return null;
    }

    public function export(): ?ExportHandler
    {
        return null;
    }
}
