<?php

/**
 * Profile controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileEmailRequest;
use App\Http\Requests\Profile\ProfileNameRequest;
use App\Http\Requests\Profile\ProfilePasswordRequest;
use App\Http\Requests\Profile\ProfilePhoneRequest;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;

/**
 * NotificationController class
 * 
 * @method JsonResponse getUser()
 * @method JsonResponse updateName(ProfileNameRequest $request)
 * @method JsonResponse updatePhone(ProfilePhoneRequest $request)
 * @method JsonResponse updateEmail(ProfileEmailRequest $request)
 * @method JsonResponse newPassword(ProfilePasswordRequest $request)
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class ProfileController extends BaseController
{
    /**
     * Service connection
     *
     * @param ProfileService $service Service variable
     */
    public function __construct(protected ProfileService $service)
    {
        
    }

    /**
     * Get auth user
     *
     * @return JsonResponse
     */
    public function getUser() : JsonResponse
    {   
        return $this->sendResponse(
            $this->service->user()
        );
    }

    /**
     * Update name auth user
     *
     * @param ProfileNameRequest $request object ProfileNameRequest
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
     * @param ProfilePhoneRequest $request object ProfilePhoneRequest
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
     * @param ProfileEmailRequest $request object ProfileEmailRequest
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
     * @param ProfilePasswordRequest $request object ProfilePasswordRequest
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
