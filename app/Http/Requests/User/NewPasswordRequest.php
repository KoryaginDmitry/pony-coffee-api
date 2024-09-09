<?php

namespace App\Http\Requests\User;

use Fillincode\Swagger\Attributes\Property;
use Illuminate\Foundation\Http\FormRequest;

#[Property('password', 'string', 'Новый пароль')]
#[Property('password_confirmation', 'string', 'Подтверждение пароля')]
class NewPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'between:8,255', 'confirmed'],
        ];
    }
}
