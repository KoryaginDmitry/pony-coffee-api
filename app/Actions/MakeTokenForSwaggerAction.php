<?php

namespace App\Actions;

use App\Models\User;

class MakeTokenForSwaggerAction
{
    public function __invoke(): string
    {
        $user = User::query()->first();

        return $user->createToken('user-token')->accessToken;
    }
}
