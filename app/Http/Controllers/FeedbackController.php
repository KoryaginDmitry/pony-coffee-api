<?php

namespace App\Http\Controllers;

use App\Http\Requests\Feedback\CreateMessageRequest;
use App\Http\Requests\Feedback\CreateRequest;
use App\Models\CoffeePot;
use App\Models\Feedback;
use App\Models\User;
use App\Services\FeedbackService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

/**
 * FeedbackController class
 *
 * @category Controllers
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class FeedbackController extends Controller
{
    /**
     * Service connection
     *
     * @param FeedbackService $service
     */
    public function __construct(protected FeedbackService $service)
    {

    }

    /**
     * Get short information about users or coffee shops
     *
     * @param string $filter
     * @return JsonResponse
     */
    public function getShortFeedback(string $filter) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getShortFeedback($filter)
        );
    }
    /**
     * Get feedbacks
     *
     * @return JsonResponse
     */
    public function getFeedbacks() : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getFeedbacks()
        );
    }

    /**
     * Gets one feedback
     *
     * @param Feedback $feedback
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getFeedback(Feedback $feedback) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getFeedback($feedback)
        );
    }

    /**
     * Gets a coffee shop feedback
     *
     * @param CoffeePot $coffeePot
     *
     * @return JsonResponse
     */
    public function getFeedbackCoffeePot(CoffeePot $coffeePot) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getFeedbackCoffeePot($coffeePot)
        );
    }

    /**
     * Get user feedbacks
     *
     * @param User $user
     * @return JsonResponse
     */
    public function getFeedbacksUser(User $user) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getFeedbackUser($user)
        );
    }

    /**
     * Create feedback
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
     * Create message for feedback
     *
     * @param Feedback             $feedback
     * @param CreateMessageRequest $request
     *
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function createMessage(Feedback $feedback, CreateMessageRequest $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->createMessage($feedback, $request)
        );
    }
}
