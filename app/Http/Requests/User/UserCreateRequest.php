<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property $name
 * @property $code
 * @property $phone
 */
class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return auth()->user()?->isBarista();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() : array
    {
        $phone_regex = config('options.regex.phone');

        return [
            'name' => ['required', 'string', 'between:2, 255'],
            'phone' => ['required', "regex:/$phone_regex/", 'unique:users'],
            'code' => ['required', 'integer', 'between:1000,9999']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() : array
    {
        return [
            'code.between' => "Поле 'Код' должно быть четырехзначным числом",
        ];
    }
}
