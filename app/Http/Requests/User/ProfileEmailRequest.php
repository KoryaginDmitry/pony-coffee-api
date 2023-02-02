<?php

namespace App\Http\Requests\User;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ProfileEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "email" => ["required", 'email', 'unique:users', 'max:255'],
            "code" => ['required', 'integer', 'between:10000,99999'],
            "email_verified_at" => ['required', 'date']
        ];
    }

    /**
     * Prepare data for validation.
     *
     * @return void
     */
    public function prepareForValidation()
    {
        $this->merge(
            [
                'email_verified_at' => Carbon::now()
            ]
        );
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'code.between' => "Поле 'Код' должно быть пятизначным числом",
        ];
    }
}
