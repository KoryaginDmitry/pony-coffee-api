<?php

namespace App\Rules;

use App\Models\CoffeePot;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Translation\PotentiallyTranslatedString;

class UserIsAnEmployee implements ValidationRule
{
    public function __construct(
        protected User $user
    ) {}

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exist = CoffeePot::query()
            ->where('id', $value)
            ->whereHas('employers', function (Builder $builder) {
                $builder->where('users.id', $this->user->id);
            })
            ->exists();

        if (! $exist) {
            $fail(__('coffee_pot.employer'));
        }
    }
}
