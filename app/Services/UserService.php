<?php

namespace App\Services;

use App\Contracts\Services\UserServiceContract;
use App\Dto\Request\User\UserPasswordDto;
use App\Dto\Request\User\UserUpdateDto;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class UserService extends BaseService implements UserServiceContract
{
    public function user(): UserResource
    {
        return UserResource::make($this->getUser());
    }

    public function update(UserUpdateDto $dto): UserResource
    {
        $this->getUser()->update($dto->toArray());

        return UserResource::make($this->getUser());
    }

    public function newPassword(UserPasswordDto $dto): JsonResponse
    {
        $this->getUser()->update($dto->toArray());

        return $this->sendResponse();
    }

    public function destroy(): JsonResponse
    {
        $this->getUser()->delete();

        return $this->sendResponse(code: 204);
    }
}
