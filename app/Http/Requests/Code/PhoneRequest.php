<?php

namespace App\Http\Requests\Code;

use App\Support\Traits\DataPrepareTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class PhoneRequest extends FormRequest
{
    use DataPrepareTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() : array
    {
        $phone_regex = config('options.regex.phone');

        if (Route::currentRouteName() === 'sendLoginCode') {
            return [
                "phone" => ["required", "regex:/$phone_regex/", "exists:users"]
            ];
        }

        return [
            "phone" => ["required", "regex:/$phone_regex/", "unique:users"],
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
                "phone" => $this->editPhoneNumber($this->phone)
            ]
        );
    }
}
