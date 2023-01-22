<?php

namespace App\Http\Requests\Auth;

use App\Rules\NotBusy;
use App\Rules\Verification;
use App\Support\Helper;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $phone_regex = config('param_config.phone_regex');

        return [
            "name" => ["required", "string", "between:2, 255"],
            "phone" => ["required", "regex:/$phone_regex/", "exists:phones", new Verification, new NotBusy],
            "password" => ["required", "between:8, 255" , "confirmed"],
            "agreement" => ["required", "accepted"],
            "role_id" => ["required", "integer"]
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
                "phone" => Helper::editPhoneNumber($this->phone),
                "agreement" => $this->agreement ? '1' : '0',
                "role_id" => 3
            ]
        );
    }
}
