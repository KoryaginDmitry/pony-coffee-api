<?php

namespace App\Http\Requests\User;

use App\Support\Helper;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ProfilePhoneRequest extends FormRequest
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
        $phone_regex = config('options.regex.phone');

        return [
            "phone" => ["required", "regex:/$phone_regex/", "uniques:users"],
            'phone_verified_at' => ['required', 'date'],
            "code" => ["required", "integer", "between:1000,9999"]
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
                'phone' => Helper::editPhoneNumber($this->phone),
                'phone_verified_at' => Carbon::now()
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
            'code.between' => "Поле 'Код' должно быть четырехзначным числом",
        ];
    }
}
