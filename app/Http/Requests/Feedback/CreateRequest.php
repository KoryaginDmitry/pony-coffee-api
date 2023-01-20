<?php

namespace App\Http\Requests\Feedback;

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
        return auth()->user()->isUser();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "user_id" => ["required", "exists:users,id"],
            "coffeePot_id" => ["required", "exists:coffee_pots,id"],
            "grade" => ["nullable", "integer", "min:1", "max:5"],
            "text" => ["required", "string", "min:15"]
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
                'user_id' => auth()->id()
            ]
        );
    }
}
