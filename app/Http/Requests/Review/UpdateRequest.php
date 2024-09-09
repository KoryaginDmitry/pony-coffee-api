<?php

namespace App\Http\Requests\Review;

use Fillincode\Swagger\Attributes\Property;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

#[Property('grade', 'integer', 'Оценка')]
#[Property('text', 'string', 'Текст отзыва')]
class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'grade' => ['required', 'integer', 'between:1,5'],
            'text' => ['required', 'string'],
        ];
    }
}
