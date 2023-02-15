<?php

namespace App\Http\Requests\CoffeePot;

use Illuminate\Foundation\Http\FormRequest;

class CoffeePotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() : array
    {
        return [
            "name" => ["nullable", "string", "max:255"],
            "address" => ["required", "string", "between:5,255"]
        ];
    }
}
