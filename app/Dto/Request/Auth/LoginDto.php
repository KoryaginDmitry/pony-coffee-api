<?php

namespace App\Dto\Request\Auth;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class LoginDto extends DataTransferObject
{
    public string $email;

    public string $password;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(Request $request): static
    {
        return new self([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);
    }
}
