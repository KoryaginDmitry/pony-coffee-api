<?php

namespace App\Http\Requests\Notification;

use App\Rules\AtLeastOneIsActive;
use Illuminate\Foundation\Http\FormRequest;

class CreateNotificationRequest extends FormRequest
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
        return [
            "email" => ["required", "bool", new AtLeastOneIsActive],
            "site" => ["required", "bool"],
            "telegram" => ["required", "bool"],
            "text" => ["required", "string", "between:5,255"]
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
                'email' => $this->email ? '1' : '0',
                'site' => $this->site ? '1' : '0',
                'telegram' => $this->telegram ? '1' : '0',
            ]
        );
    }
}
