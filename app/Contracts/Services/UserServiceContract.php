<?php

namespace App\Contracts\Services;

use App\Dto\Request\User\UserPasswordDto;
use App\Dto\Request\User\UserUpdateDto;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

interface UserServiceContract
{
    public function user(): UserResource;

    public function update(UserUpdateDto $dto): UserResource;

    public function newPassword(UserPasswordDto $dto): JsonResponse;

    public function destroy(): JsonResponse;
}
