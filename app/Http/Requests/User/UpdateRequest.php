<?php

namespace App\Http\Requests\User;

use Fillincode\Swagger\Attributes\Property;
use Illuminate\Foundation\Http\FormRequest;

#[Property('name', 'string', 'Имя')]
#[Property('last_name', 'string', 'Фамилия')]
class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
        ];
    }
}
