<?php

namespace App\Http\Requests\Barista;

use App\Support\Traits\DataPrepareTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property $name
 * @property $last_name
 * @property $phone
 * @property $coffee_pot_id
 * @property $barista
 */
class UpdateRequest extends FormRequest
{
    use DataPrepareTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return auth()->user()?->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() : array
    {
        $phone_regex = config('options.regex.phone');

        return [
            "name" => ["required", "string", "between:2,255", 'alpha'],
            "last_name" => ["nullable", "string", "between:2,255", 'alpha'],
            "phone" => [
                "required",
                "regex:/$phone_regex/",
                Rule::unique('users')->ignore($this->barista)
            ],
            "coffee_pot_id" => ["required", "exists:coffee_pots,id"]
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
                'phone' => $this->editPhoneNumber($this->phone),
            ]
        );
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() : array
    {
        return [
            'coffee_pot_id.required' => "Выберите кофейню",
        ];
    }
}
