<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bonus\BonusRequest;
use App\Models\User;
use App\Services\BonusService;
use Illuminate\Http\JsonResponse;

/**
 * BonusController class
 *
 * @category Controllers
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class BonusController extends Controller
{
    /**
     * Service connection
     *
     * @param BonusService $service
     */
    public function __construct(protected BonusService $service)
    {

    }

    /**
     * Get information about the authenticated user's bonuses
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
     * Create from 1 to 10 bonuses for the user
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
     * Writes off bonuses from the user
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
