<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AuthServiceContract;
use App\Dto\Request\Auth\LoginDto;
use App\Dto\Request\Auth\RegisterDto;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use Exception;
use Fillincode\Swagger\Attributes\FormRequest;
use Fillincode\Swagger\Attributes\Group;
use Fillincode\Swagger\Attributes\Resource;
use Fillincode\Swagger\Attributes\Summary;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        protected AuthServiceContract $service
    ) {}

    #[Group('Auth')]
    #[Summary('Авторизация')]
    #[FormRequest(LoginRequest::class)]
    #[Resource(UserResource::class)]
    public function login(LoginRequest $request): UserResource|JsonResponse
    {
        try {
            return $this->service->login(
                LoginDto::fromRequest($request)
            );
        } catch (Exception $exception) {
            return $this->createErrorResponse(__('errors.auth.login'), $exception);
        }
    }

    #[Group('Auth')]
    #[Summary('Регистрация')]
    #[FormRequest(RegisterRequest::class)]
    #[Resource(UserResource::class)]
    public function register(RegisterRequest $request): UserResource|JsonResponse
    {
        try {
            return $this->service->register(
                RegisterDto::fromRequest($request)
            );
        } catch (Exception $exception) {
            return $this->createErrorResponse(__('errors.auth.register'), $exception);
        }
    }

    #[Group('Auth')]
    #[Summary('Разавторизация')]
    public function logout(): JsonResponse
    {
        try {
            return $this->service->logout();
        } catch (Exception $exception) {
            return $this->createErrorResponse(__('errors.auth.logout'), $exception);
        }

    }
}
