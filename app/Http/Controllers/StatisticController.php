<?php

namespace App\Http\Controllers;

use App\Services\StatisticService;
use Illuminate\Http\JsonResponse;

/**
 * StatisticController class
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
     * @param StatisticService $service
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
     * Get user statistics for a week or month
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
