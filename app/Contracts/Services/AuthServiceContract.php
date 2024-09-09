<?php

namespace App\Contracts\Services;

use App\Dto\Request\Auth\LoginDto;
use App\Dto\Request\Auth\RegisterDto;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

interface AuthServiceContract
{
    public function login(LoginDto $dto): UserResource|JsonResponse;

    public function register(RegisterDto $dto): UserResource;

    public function logout(): JsonResponse;
}
