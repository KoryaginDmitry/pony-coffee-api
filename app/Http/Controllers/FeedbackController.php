<?php
/**
 * Feedback controller
 * php version 8.1.2
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Http\Controllers;

use App\Service\FeedbackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * FeedbackController class
 * 
 * @method JsonResponse getFeedback(int $id = 0)
 * @method JsonResponse create(Request $request)
 * @method JsonResponse createMessage(int $id, Request $request)
 * 
 * @category Controllers
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 */
class FeedbackController extends BaseController
{
    /**
     * Method connection service class
     *
     * @param FeedbackService $service param service class
     */
    public function __construct(protected FeedbackService $service)
    {
        
    }

    /**
     * Method get feedbacks
     *
     * @param int $id id coffee pot
     * 
     * @return JsonResponse
     */
    public function getFeedback(int $id = 0) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->getFeedback($id)
        );
    }

    /**
     * Create feedback
     *
     * @param Request $request object Request class
     * 
     * @return JsonResponse
     */
    public function create(Request $request) : JsonResponse
    {
        return $this->sendResponse(
            $this->service->create($request)
        );
    }

    /**
     * Create message for feedback
     *
     * @param int     $id      id feedback
     * @param Request $request object Request class
     * 
     * @return JsonResponse
     */
    public function createMessage(int $id, Request $request) : JsonResponse
    {   
        return $this->sendResponse(
            $this->service->createMessage($id, $request)
        );
    }
}
