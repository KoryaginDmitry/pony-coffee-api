<?php

namespace App\Http\Requests\Review;

use Fillincode\Swagger\Attributes\Property;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

#[Property('coffee_pot_id', 'integer', 'ID кофейни')]
#[Property('grade', 'integer', 'Оценка')]
#[Property('text', 'string', 'Текст отзыва')]
class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'coffee_pot_id' => ['required', 'integer', 'exists:coffee_pots,id'],
            'grade' => ['required', 'integer', 'between:1,5'],
            'text' => ['required', 'string'],
        ];
    }
}
