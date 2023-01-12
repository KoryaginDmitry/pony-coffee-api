<?php

/**
 * Profile controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Http\Controllers;

use App\Service\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * NotificationController class
 * 
 * @method JsonResponse getUser()
 * @method JsonResponse updateName()
 * @method JsonResponse updatePhone()
 * @method JsonResponse updateEmail()
 * @method JsonResponse newPassword()
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 */
class ProfileController extends BaseController
{
    /**
     * Construct method
     * 
     * Connection service class
     *
     * @param ProfileService $service param service class
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
     * @param Request $request object Request class
     * 
     * @return JsonResponse
     */
    public function updateName(Request $request) : JsonResponse
    {   
        return $this->sendResponse(
            $this->service->updateName($request)
        );
    }
    
    /**
     * Update phone auth user
     *
     * @param Request $request object Request class
     * 
     * @return JsonResponse
     */
    public function updatePhone(Request $request) : JsonResponse
    {   
        return $this->sendResponse(
            $this->service->updatePhone($request)
        );
    }

    /**
     * Update email auth user
     *
     * @param Request $request object Request class
     * 
     * @return JsonResponse
     */
    public function updateEmail(Request $request) : JsonResponse
    {   
        return $this->sendResponse(
            $this->service->updateEmail($request)
        );
    }

    /**
     * New password for auth user
     *
     * @param Request $request object Request class
     * 
     * @return JsonResponse
     */
    public function newPassword(Request $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->newPassword($request)
        );
    }
}
