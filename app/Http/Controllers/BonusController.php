<?php
/**
 * BonusController class
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */

 namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BonusService;
use Illuminate\Http\JsonResponse;

/**
 * BonusController class
 * 
 * @method JsonResponse getInfoBonuses()
 * @method JsonResponse search(Request $request)
 * @method JsonResponse create(int $id)
 * @method JsonResponse wrote(int $id)
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class BonusController extends BaseController
{
    /**
     * Service connection
     *
     * @param BonusService $service Service variable
     */
    public function __construct(protected BonusService $service)
    {
        
    }
    
    /**
     * Method get information about users bonuses
     *
     * @return JsonResponse
     */
    public function getInfoBonuses() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getInfoBonuses()
        );
    }

    /**
     * Return all users
     *
     * @return JsonResponse
     */
    public function getUsers() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getUsers()
        );
    }

    /**
     * Method create bonus for user
     *
     * @param User $user user object
     * 
     * @return jsonResponse
     */
    public function create(User $user) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->create($user)
        );
    }

    /**
     * Method wrote users bonuses
     *
     * @param User $user user object
     * 
     * @return JsonResponse
     */
    public function wrote(User $user) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->wrote($user)
        );
    }
}
