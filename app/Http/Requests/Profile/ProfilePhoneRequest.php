<?php

namespace App\Http\Requests\Profile;

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
        return auth()->user()->isUser();
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
            "code" => ["request", "integer", "between:1000, 9999"]
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
}