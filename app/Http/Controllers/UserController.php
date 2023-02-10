<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ProfileEmailRequest;
use App\Http\Requests\User\ProfileNameRequest;
use App\Http\Requests\User\ProfilePasswordRequest;
use App\Http\Requests\User\ProfilePhoneRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

/**
 * UserController class
 *
 * @category Controllers
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class UserController extends BaseController
{
    /**
     * Service connection
     *
     * @param UserService $service
     */
    public function __construct(protected UserService $service)
    {

    }

    /**
     * Get users and relationship bonuses for barista profile
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
     * Creating a user through a barista profile
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

    /**
     * Get auth user
     *
     * @return JsonResponse
     */
    public function authUser() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->authUser()
        );
    }

    /**
     * Update name auth user
     *
     * @param ProfileNameRequest $request
     *
     * @return JsonResponse
     */
    public function updateName(ProfileNameRequest $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->updateName($request)
        );
    }

    /**
     * Update phone auth user
     *
     * @param ProfilePhoneRequest $request
     *
     * @return JsonResponse
     */
    public function updatePhone(ProfilePhoneRequest $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->updatePhone($request)
        );
    }

    /**
     * Update email auth user
     *
     * @param ProfileEmailRequest $request
     *
     * @return JsonResponse
     */
    public function updateEmail(ProfileEmailRequest $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->updateEmail($request)
        );
    }

    /**
     * New password for auth user
     *
     * @param ProfilePasswordRequest $request
     *
     * @return JsonResponse
     */
    public function newPassword(ProfilePasswordRequest $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->newPassword($request)
        );
    }
}
