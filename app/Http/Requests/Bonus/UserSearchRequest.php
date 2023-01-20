<?php

namespace App\Http\Requests\Bonus;

use App\Support\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UserSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isBarista();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'value' => ["sometimes", "required", "string", "between: 1, 12"]
        ];
    }
}
