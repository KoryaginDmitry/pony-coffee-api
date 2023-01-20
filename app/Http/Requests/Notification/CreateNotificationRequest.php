<?php

namespace App\Http\Requests\Notification;

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
            "site" => ["required_without_all:telegram", "accepted"],
            "telegram" => ["required_without_all:site", "accepted"],
            "text" => ["required", "string", "between:10, 255"]
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
                "site" => $this->site ? '1' : '0',
                "telegram" => $this->telegram ? '1' : '0',
            ]
        );
    }
}
