<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserCreateRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserControler extends BaseController
{
    /**
     * Service connection
     *
     * @param UserService $service Stores in a service
     */
    public function __construct(protected UserService $service)
    {
        
    }

    /**
     * Return users and relationship bonuses
     * 
     * @return JsonResponse
     */
    public function users() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->users()
        );
    }

    /**
     * Create user
     *
     * @param UserCreateRequest $request
     * 
     * @return JsonResponse
     */
    public function userCreate(UserCreateRequest $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->userCreate($request)
        );
    }
}
