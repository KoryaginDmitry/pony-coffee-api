<?php

namespace App\Dto\Request\User;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UserPasswordDto extends DataTransferObject
{
    public string $password;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(Request $request): UserPasswordDto
    {
        return new self([
            'password' => $request->get('password'),
        ]);
    }
}
