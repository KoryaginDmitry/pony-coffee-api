<?php
/**
 * Home controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Http\Controllers;

use App\Service\HomeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * HomeController class
 * 
 * @method JsonResponse get()
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 */
class HomeController extends BaseController
{
    /**
     * Constuct method
     * 
     * Connection service class
     *
     * @param HomeService $service param service class
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
