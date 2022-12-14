<?php
/**
 * BonusController class
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */

 namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\BonusService;
use Illuminate\Http\JsonResponse;

/**
 * BonusController class
 * 
 * @method JsonResponse getInfoBonuses()
 * @method JsonResponse search()
 * @method JsonResponse create()
 * @method JsonResponse wrote()
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 */
class BonusController extends BaseController
{
    /**
     * Method connection service class
     *
     * @param BonusService $service param service class
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
     * Method search user
     *
     * @param Request $request object Request class
     * 
     * @return JsonResponse
     */
    public function search(Request $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->search($request)
        );
    }

    /**
     * Method create bonus for user
     *
     * @param int $id id user
     * 
     * @return jsonResponse
     */
    public function create(int $id) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->create($id)
        );
    }

    /**
     * Method wrote users bonuses
     *
     * @param int $id id user
     * 
     * @return JsonResponse
     */
    public function wrote(int $id) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->wrote($id)
        );
    }
}
