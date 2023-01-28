<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isBarista();
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
            'name' => ['required', 'string', 'between:2, 255'],
            'phone' => ['required', "regex:/$phone_regex/", 'unique:users'],
            'code' => ['required', 'integer', 'between:1000, 9999']
        ];
    }
}
