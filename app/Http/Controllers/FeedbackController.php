<?php
/**
 * Feedback controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Http\Controllers;

use App\Http\Requests\Feedback\CreateMessageRequest;
use App\Http\Requests\Feedback\CreateRequest;
use App\Models\CoffeePot;
use App\Models\Feedback;
use App\Services\FeedbackService;
use Illuminate\Http\JsonResponse;

/**
 * FeedbackController class
 *  
 * @method JsonResponse getFeedbacks()
 * @method JsonResponse getFeedback(Feedback $feedback)
 * @method JsonResponse getFeedbackCoffeePot(CoffeePot $coffePot)
 * @method JsonResponse create(CreateRequest $request)
 * @method JsonResponse createMessage(Feedback $feedback, CreateMessageRequest $request)
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class FeedbackController extends BaseController
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
     * @return JsonResponse
     */
    public function createMessage(Feedback $feedback, CreateMessageRequest $request) : JsonResponse
    {  
        return $this->sendResponse(
            $this->service->createMessage($feedback, $request)
        );
    }
}
