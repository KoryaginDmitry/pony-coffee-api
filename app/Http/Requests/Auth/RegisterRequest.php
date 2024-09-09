<?php

namespace App\Http\Requests\Auth;

use Fillincode\Swagger\Attributes\Property;
use Illuminate\Foundation\Http\FormRequest;

#[Property('name', ' string', 'Имя')]
#[Property('last_name', ' string', 'Фамилия')]
#[Property('email', ' string', 'Почта')]
#[Property('password', 'string', 'Пароль')]
#[Property('password_confirmation', 'string', 'Подтверждение пароля')]
class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'between:2,255', 'alpha'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'between:8,255', 'confirmed'],
        ];
    }
}
