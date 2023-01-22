<?php

namespace App\Rules;

use App\Models\Phone;
use Illuminate\Contracts\Validation\InvokableRule;

class NotBusy implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $phone = Phone::where(
            [
                'phone' => $value,
                'user_id' => null
            ]
        )->first();

        if (!$phone) {
            $fail(':attribute уже занят');
        }
    }
}
