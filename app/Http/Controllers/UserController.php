<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceContract;
use App\Dto\Request\User\UserPasswordDto;
use App\Dto\Request\User\UserUpdateDto;
use App\Http\Requests\User\NewPasswordRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use Exception;
use Fillincode\Swagger\Attributes\FormRequest;
use Fillincode\Swagger\Attributes\Group;
use Fillincode\Swagger\Attributes\Resource;
use Fillincode\Swagger\Attributes\Summary;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        protected UserServiceContract $service
    ) {}

    #[Group('User')]
    #[Summary('Получение данных текущего пользователя')]
    #[Resource(UserResource::class)]
    public function show(): UserResource|JsonResponse
    {
        try {
            return $this->service->user();
        } catch (Exception $exception) {
            return $this->createErrorResponse(__('errors.user.show'), $exception);
        }
    }

    #[Group('User')]
    #[Summary('Обновление данных текущего пользователя')]
    #[Resource(UserResource::class)]
    #[FormRequest(UpdateRequest::class)]
    public function update(UpdateRequest $request): UserResource|JsonResponse
    {
        try {
            return $this->service->update(
                UserUpdateDto::fromRequest($request)
            );
        } catch (Exception $exception) {
            return $this->createErrorResponse(__('errors.user.update'), $exception);
        }
    }

    #[Group('User')]
    #[Summary('Обновление пароля текущего пользователя')]
    #[FormRequest(NewPasswordRequest::class)]
    public function newPassword(NewPasswordRequest $request): JsonResponse
    {
        try {
            return $this->service->newPassword(
                UserPasswordDto::fromRequest($request)
            );
        } catch (Exception $exception) {
            return $this->createErrorResponse(__('errors.user.new_password'), $exception);
        }
    }

    #[Group('User')]
    #[Summary('Удаление текущего пользователя')]
    public function destroy(): JsonResponse
    {
        try {
            return $this->service->destroy();
        } catch (Exception $exception) {
            return $this->createErrorResponse(__('errors.user.destroy'), $exception);
        }
    }
}
