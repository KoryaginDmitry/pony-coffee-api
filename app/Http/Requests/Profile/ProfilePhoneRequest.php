<?php

namespace App\Http\Requests\Profile;

use App\Support\Helper;
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
        return false;
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
            "phone" => ["request", "regex:/$phone_regex/", "unique:users"]
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
                'phone' => Helper::editPhoneNumber($this->phone)
            ]
        );
    }
}
