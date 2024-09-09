<?php

namespace App\Services;

use App\Models\User;
use App\Traits\SendResponseTrait;
use Illuminate\Contracts\Auth\Authenticatable;

class BaseService
{
    use SendResponseTrait;

    private User $user;

    public function getUser(): Authenticatable|User
    {
        return $this->user ??= auth()->user();
    }

    public function getUserKey(): int
    {
        return $this->getUser()->getKey();
    }
}
