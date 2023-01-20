<?php
/**
 * Home controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * HomeController class
 * 
 * @method JsonResponse get()
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class HomeController extends BaseController
{
    /**
     * Service connection
     *
     * @param HomeService $service Stores in a service
     */
    public function __construct(protected HomeService $service)
    {
        
    }
    
    /**
     * Get header for role user
     *
     * @return JsonResponse
     */
    public function get() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->get()
        );
    }
}
