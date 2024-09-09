<?php

namespace App\Http\Requests\Bonus;

use App\Rules\UserIsAnEmployee;
use Fillincode\Swagger\Attributes\Property;
use Illuminate\Foundation\Http\FormRequest;

#[Property('count', 'integer', 'Количество бонусов')]
#[Property('user_id', 'integer', 'ID пользователя')]
#[Property('coffee_pot_id', 'integer', 'ID кофейни')]
class BonusTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('barista');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'count' => ['required', 'integer', 'between:1,10'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'coffee_pot_id' => ['required', 'integer', 'exists:coffee_pots,id', new UserIsAnEmployee($this->user())],
        ];
    }
}
