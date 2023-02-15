<?php

namespace App\Http\Requests\Code;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class EmailRequest extends FormRequest
{
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
        if (Route::currentRouteName() === 'verificationEmail') {
            return [
                'email' => ['required', 'email', 'unique:users']
            ];
        }

        return [
            'email' => ['required', 'email', 'exists:users']
        ];
    }
}
