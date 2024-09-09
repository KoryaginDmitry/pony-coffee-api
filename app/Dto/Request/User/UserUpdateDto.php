<?php

namespace App\Dto\Request\User;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UserUpdateDto extends DataTransferObject
{
    public string $name;

    public string $last_name;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(Request $request): UserUpdateDto
    {
        return new self([
            'name' => $request->get('name'),
            'last_name' => $request->get('last_name'),
        ]);
    }
}
