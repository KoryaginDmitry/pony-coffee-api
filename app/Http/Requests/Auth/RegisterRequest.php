<?php

namespace App\Http\Requests\Auth;

use App\Support\Traits\DataPrepareTrait;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property $name
 * @property $phone
 * @property $phone_verified_at
 * @property $code
 * @property $password
 * @property $agreement
 * @property $role_id
 */
class RegisterRequest extends FormRequest
{
    use DataPrepareTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return !auth()->check();
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
            "name" => ["required", "string", "between:2,255", "alpha"],
            "phone" => ["required", "regex:/$phone_regex/", "unique:users"],
            'phone_verified_at' => ["required", "date"],
            "code" => ["required", "integer", "between:1000,9999"],
            "password" => ["required", "between:8,255" , "confirmed"],
            "agreement" => ["required", "accepted"],
            "role_id" => ["required", "integer"]
        ];
    }

    /**
     * Prepare data for validation.
     *
     * @return void
     */
    public function prepareForValidation() : void
    {
        $this->merge(
            [
                "phone" => $this->editPhoneNumber($this->phone),
                "phone_verified_at" => Carbon::now(),
                "agreement" => $this->agreement ? '1' : '0',
                "role_id" => 3
            ]
        );
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() : array
    {
        return [
            'code.between' => "Поле 'Код' должно быть четырхзначным",
        ];
    }
}
