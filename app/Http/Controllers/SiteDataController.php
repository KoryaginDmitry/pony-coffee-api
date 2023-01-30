<?php
/**
 * SiteData controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Http\Controllers;

use App\Services\SiteDataService;
use Illuminate\Http\JsonResponse;

/**
 * SiteDataController class
 * 
 * @method JsonResponse header()
 * @method JsonResponse bonusLifetime()
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class SiteDataController extends BaseController
{
    /**
     * Service connection
     *
     * @param HomeService $service
     */
    public function __construct(protected SiteDataService $service)
    {
        
    }
    
    /**
     * Get header for role user
     *
     * @return JsonResponse
     */
    public function header() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->get()
        );
    }

    /**
     * Get bonus lifetime
     *
     * @return JsonResponse
     */
    public function bonusLifetime() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->bonusLifetime()
        );
    }
}
