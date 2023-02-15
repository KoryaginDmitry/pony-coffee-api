<?php

namespace App\Http\Controllers;

use App\Http\Requests\Barista\CreateRequest;
use App\Http\Requests\Barista\UpdateRequest;
use App\Models\User;
use App\Services\BaristaService;
use Illuminate\Http\JsonResponse;

/**
 * BaristaController class
 *
 * @category Controllers
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class BaristaProfileController extends Controller
{
    /**
     * Service connection
     *
     * @param BaristaService $service
     */
    public function __construct(protected BaristaService $service)
    {

    }

    /**
     * Get all barista users
     *
     * @return JsonResponse
     */
    public function getAll() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getBaristas()
        );
    }

    /**
     * Get one user barista
     *
     * @param User $barista
     *
     * @return JsonResponse
     */
    public function getBarista(User $barista) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getBarista($barista)
        );
    }

    /**
     * Create user barista
     *
     * @param CreateRequest $request
     *
     * @return JsonResponse
     */
    public function create(CreateRequest $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->create($request)
        );
    }

    /**
     * Update user barista
     *
     * @param UpdateRequest $request
     * @param User          $barista
     *
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, User $barista) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->update($request, $barista)
        );
    }

    /**
     * Delete user barista
     *
     * @param User $barista
     *
     * @return JsonResponse
     */
    public function delete(User $barista) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->delete($barista)
        );
    }
}
