<?php

namespace App\Services;

use App\Contracts\Services\AuthServiceContract;
use App\Dto\Request\Auth\LoginDto;
use App\Dto\Request\Auth\RegisterDto;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService implements AuthServiceContract
{
    protected function makeResource(User $user): UserResource
    {
        $resource = new UserResource($user);
        $resource->setToken(
            $user->createToken('user_token')->accessToken
        );

        return $resource;
    }

    public function login(LoginDto $dto): UserResource|JsonResponse
    {
        $user = User::query()->where('email', $dto->email)->first();

        if (! $user || ! Hash::check($dto->password, $user->password)) {
            return $this->sendErrorResponse('Проверьте введенные данные');
        }

        return $this->makeResource($user);
    }

    public function register(RegisterDto $dto): UserResource
    {
        $user = User::query()->create($dto->toArray());

        return $this->makeResource($user);
    }

    public function logout(): JsonResponse
    {
        $this->getUser()->token()->delete();

        return $this->sendResponse();
    }
}
