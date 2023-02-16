<?php

namespace App\Http\Controllers;

use App\Services\SiteDataService;
use Illuminate\Http\JsonResponse;

/**
 * SiteDataController class
 *
 * @category Controllers
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class SiteDataController extends Controller
{
    /**
     * Service connection
     *
     * @param SiteDataService $service
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
            $this->service->header()
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

    /**
     * Get channels for user
     *
     * @return JsonResponse
     */
    public function getChannels() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getChannels()
        );
    }
}
