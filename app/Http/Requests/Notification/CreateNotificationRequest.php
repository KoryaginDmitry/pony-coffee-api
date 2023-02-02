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
            "email" => ["required_without_all:telegram,site", "sometimes", "accepted"],
            "site" => ["required_without_all:telegram,email", "sometimes", "accepted"],
            "telegram" => ["required_without_all:site,email", "sometimes", "accepted"],
            "text" => ["required", "string", "between:5,255"]
        ];
    }
}
