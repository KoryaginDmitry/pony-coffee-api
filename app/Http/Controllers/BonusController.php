<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bonus\BonusRequest;
use App\Models\User;
use App\Services\BonusService;
use Illuminate\Http\JsonResponse;

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
     * Return information users bonuses
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
     * Method create bonus for user
     *
     * @param BonusRequest $request
     * @param User         $user
     * 
     * @return jsonResponse
     */
    public function create(BonusRequest $request, User $user) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->create($request, $user)
        );
    }

    /**
     * Method wrote users bonuses
     *
     * @param BonusRequest $request
     * @param User         $user
     * 
     * @return JsonResponse
     */
    public function wrote(BonusRequest $request, User $user) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->wrote($request, $user)
        );
    }
}
