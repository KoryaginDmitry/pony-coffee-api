<?php

namespace App\Dto\Request\Auth;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class RegisterDto extends DataTransferObject
{
    public string $name;

    public string $last_name;

    public string $email;

    public string $password;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(Request $request): static
    {
        return new self([
            'name' => $request->get('name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);
    }
}
