<?php

/**
 * Statistic controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @package Category
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 * 
 * @license http://href.com MIT
 * 
 * @link http://href.com
 */
namespace App\Http\Controllers;

use App\Service\StatisticService;
use Illuminate\Http\JsonResponse;

/**
 * StatisticController class
 * 
 * @method JsonResponse barista()
 * @method JsonResponse user()
 * 
 * @category Controllers
 * 
 * @package Category
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 * 
 * @license http://href.com MIT
 * 
 * @link http://href.com
 */
class StatisticController extends BaseController
{
    /**
     * Construct
     * 
     * Connection servcie class
     *
     * @param StatisticService $service param servcie class
     */
    public function __construct(protected StatisticService $service)
    {
        
    }
    
    /**
     * Barista
     * 
     * Get statistic baristas
     *
     * @return JsonResponse
     */
    public function barista() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->barista()
        );
    }

    /**
     * User
     * 
     * Get statistic users
     *
     * @return JsonResponse
     */
    public function user() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->user()
        );
    }
}
