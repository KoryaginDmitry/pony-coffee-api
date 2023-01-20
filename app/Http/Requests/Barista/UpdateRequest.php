<?php

namespace App\Http\Requests\Barista;

use App\Support\Helper;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            "name" => ["required", "string", "between:3, 255"],
            "last_name" => ["nullable", "string", "between:3, 255"],
            "phone" => [
                "required",
                "regex:/$phone_regex/",
                Rule::unique('users')->ignore($this->barista, 'id')
            ],
            'phone_verified_at' => ["required", "date"],
            "coffeePot_id" => ["required", "exists:coffee_pots,id"]
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
                'phone_verified_at' => Carbon::now()
            ]
        );
    }
}
