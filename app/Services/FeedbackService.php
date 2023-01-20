<?php

/**
 * Feedback service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Services;

use App\Http\Requests\Feedback\CreateMessageRequest;
use App\Http\Requests\Feedback\CreateRequest;
use App\Models\CoffeePot;
use App\Models\Feedback;

/**
 * FeedbackService class
 * 
 * @method JsonResponse getFeedbacks()
 * @method JsonResponse getFeedback(Feedback $feedback)
 * @method JsonResponse getFeedbackCoffeePot(CoffeePot $coffePot)
 * @method JsonResponse create(CreateRequest $request)
 * @method JsonResponse createMessage(Feedback $feedback, CreateMessageRequest $request)
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class FeedbackService extends BaseService
{
    /**
     * Get feedbacks
     * 
     * @return array
     */
    public function getFeedbacks() : array
    {
        $this->data = [
            'feedbacks' => Feedback::when(
                !auth()->user()->isAdmin(),
                function ($query) {
                    return $query->where('user_id', auth()->id);
                }
            )
            ->with(['messages', 'coffeePot'])
            ->get()
        ];

        return $this->sendResponse();
    }

    /**
     * Get feedback
     * 
     * @param Feedback $feedback object Feedback
     * 
     * @return array
     */
    public function getFeedback(Feedback $feedback) : array
    {
        $this->rightCheck($feedback);

        $this->data = [
            'feedback' => $feedback->fresh(['messages', 'coffeePot'])
        ];

        return $this->sendResponse();
    }

    /**
     * Get feedbacks for a specific coffee shop
     * 
     * @param CoffeePot $coffeePot object CoffeePot
     * 
     * @return array
     */
    public function getFeedbackCoffeePot(CoffeePot $coffeePot) : array
    {
        $this->data = [
            'feedbacks' => Feedback::when(
                !auth()->user()->isAdmin(),
                function ($query) {
                    return $query->where('user_id', auth()->id);
                }
            )
            ->where('coffee_pot_id', $coffeePot->id)
            ->with(['messages', 'coffeePot'])
            ->get()
        ];

        return $this->sendResponse();
    }

    /**
     * Create feedback and message
     *
     * @param CreateRequest $request object CreateRequest
     * 
     * @return array
     */
    public function create(CreateRequest $request) : array
    {
        $feedback = Feedback::create(
            $request->safe()->except(['text'])
        );

        $this->data = [
            "feedback" => $feedback,
            "message" => $feedback->messages()->create(
                $request->safe()->only(['text', 'user_id'])
            )
        ];

        $this->code = 201;

        return $this->sendResponse();
    }

    /**
     * Create message for feedback
     * 
     * @param Feedback             $feedback object Feedback
     * @param CreateMessageRequest $request  object CreateMessageRequest
     * 
     * @return array
     */
    public function createMessage(Feedback $feedback, CreateMessageRequest $request) : array
    {
        $this->rightCheck($feedback);
        
        $this->data = [
            'message' => $feedback->messages()->create(
                $request->validated()
            )
        ];

        return $this->sendResponse();
    }
}
