<?php

namespace App\Http\Requests\Profile;

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
        return auth()->user()->isUser();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "email" => ["request", 'email', 'unique:users', 'max:255'],
            "email_verified_at" => ['required']
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
                'email_verified_at' => null
            ]
        );
    }
}
