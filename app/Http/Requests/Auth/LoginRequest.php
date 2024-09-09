<?php

namespace App\Http\Requests\Auth;

use Fillincode\Swagger\Attributes\Property;
use Illuminate\Foundation\Http\FormRequest;

#[Property('email', ' string', 'Почта')]
#[Property('password', 'string', 'Пароль')]
class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required', 'string'],
        ];
    }
}
