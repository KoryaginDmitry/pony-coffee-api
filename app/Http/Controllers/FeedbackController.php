<?php
/**
 * Feedback controller
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

use App\Service\FeedbackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * FeedbackController class
 * 
 * @method array getFeedback()
 * @method array create()
 * @method array createMessage()
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
     * @return void
     */
    public function createMessage(int $id, Request $request)
    {   
        return $this->sendResponse(
            $this->service->createMessage($id, $request)
        );
    }
}
