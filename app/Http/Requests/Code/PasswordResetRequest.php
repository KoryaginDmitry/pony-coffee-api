<?php

namespace App\Http\Requests\Code;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property $token
 * @property $email
 * @property $password
 */
class PasswordResetRequest extends FormRequest
{
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
        return [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'between:8,255', 'confirmed'],
        ];
    }
}
