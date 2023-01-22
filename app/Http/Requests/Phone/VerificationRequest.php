<?php

namespace App\Http\Requests\Phone;

use App\Rules\NotVerification;
use App\Support\Helper;
use Illuminate\Foundation\Http\FormRequest;

class VerificationRequest extends FormRequest
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
            "phone" => ["required", "regex:/$phone_regex/", "exists:phones", new NotVerification],
            "code" => ["required", "string", "exists:phone_codes"]
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
                "phone" => Helper::editPhoneNumber($this->phone)
            ]
        );
    }
}
