<?php

namespace App\Http\Requests\Barista;

use App\Support\Traits\DataPrepareTrait;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    use DataPrepareTrait;

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
        $phone_regex = config('options.regex.phone');

        return [
            "name" => ["required", "string", "between:2,255", "alpha"],
            "last_name" => ["nullable", "string", "between:2,255", "alpha"],
            "coffee_pot_id" => ["required", "exists:coffee_pots,id"],
            "phone" => ["required", "regex:/$phone_regex/", "unique:users"],
            'phone_verified_at' => ['required', 'date'],
            "password" => ["required", "string", "confirmed", "between:8,255"],
            "agreement" => ["required", "integer"],
            "role_id" => ["required", "integer"]
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
                'phone_verified_at' => Carbon::now(),
                'agreement' => '1',
                'role_id' => 2
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
