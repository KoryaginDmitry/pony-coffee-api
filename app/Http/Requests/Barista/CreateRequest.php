<?php

namespace App\Http\Requests\Barista;

use App\Support\Helper;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $phone_regex = config('param_config.phone_regex');

        return [
            "name" => ["required", "string", "between:5, 255"],
            "last_name" => ["nullable", "string", "between:5, 255"],
            "phone" => ["required", "regex:/$phone_regex/", "unique:users"],
            "phone_verified_at" => ["required", "date"],
            "password" => ["required", "string", "confirmed", "between:8, 255"],
            "coffeePot_id" => ["required", "exists:coffee_pots,id"],
            "agreement" => ["required", "integer"],
            "role_id" => ["required", "integer"]
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
                'phone' => Helper::editPhoneNumber($this->phone),
                'phone_verified_at' => Carbon::now(),
                'agreement' => '1',
                'role_id' => 2
            ]
        );
    }
}
