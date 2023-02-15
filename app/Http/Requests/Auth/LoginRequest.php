<?php

namespace App\Http\Requests\Auth;

use App\Support\Traits\DataPrepareTrait;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            "phone" => ["required", "regex:/$phone_regex/"],
            "password" => ["required", "string", "max:255"]
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
                'phone' => $this->editPhoneNumber($this->phone)
            ]
        );
    }
}
