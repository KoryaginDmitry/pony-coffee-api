<?php

/**
 * Statistic controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Http\Controllers;

use App\Services\StatisticService;
use Illuminate\Http\JsonResponse;

/**
 * StatisticController class
 * 
 * @method JsonResponse barista()
 * @method JsonResponse user()
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class StatisticController extends BaseController
{
    /**
     * Service connection
     *
     * @param StatisticService $service Service variable
     */
    public function __construct(protected StatisticService $service)
    {
        
    }
    
    /**
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
    
    /**
     * Return info bonuses
     *
     * @param integer $interval
     * 
     * @return JsonResponse
     */
    public function userTimeInterval(int $interval) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->userTimeInterval($interval)
        );
    }
}
