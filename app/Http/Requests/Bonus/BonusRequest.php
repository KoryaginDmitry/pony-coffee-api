<?php

namespace App\Http\Requests\Bonus;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BonusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isBarista();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "count" => ["required", "integer", "between:1, 10"]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'count.between' => "Поле 'Количество' должно быть от 1 до 10",
        ];
    }
}
