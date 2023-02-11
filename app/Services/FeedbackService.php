<?php

namespace App\Services;

use App\Events\CreateFeedback;
use App\Events\CreateMessage;
use App\Http\Requests\Feedback\CreateMessageRequest;
use App\Http\Requests\Feedback\CreateRequest;
use App\Models\CoffeePot;
use App\Models\Feedback;
use Illuminate\Support\Facades\Gate;

/**
 * FeedbackService class
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
                !auth()->user()?->isAdmin(),
                function ($query) {
                    return $query->where('user_id', auth()->id());
                }
            )
            ->with(['messages', 'coffeePot', 'user'])
            ->get()
        ];

        return $this->sendResponse();
    }

    /**
     * Get one feedback
     *
     * @param Feedback $feedback
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getFeedback(Feedback $feedback) : array
    {
        Gate::authorize('access-to-appeal', $feedback);

        $this->data = [
            'feedback' => $feedback->fresh(['messages', 'coffeePot', 'user'])
        ];

        return $this->sendResponse();
    }

    /**
     * Get a coffee shop feedback
     *
     * @param CoffeePot $coffeePot
     *
     * @return array
     */
    public function getFeedbackCoffeePot(CoffeePot $coffeePot) : array
    {
        $this->data = [
            'feedbacks' => Feedback::when(
                !auth()->user()?->isAdmin(),
                function ($query) {
                    return $query->where('user_id', auth()->id());
                }
            )
            ->where('coffee_pot_id', $coffeePot->id)
            ->with(['messages', 'coffeePot', 'user'])
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

        broadcast(new CreateFeedback($feedback->fresh('messages')));

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
        Gate::authorize('access-to-appeal', $feedback);

        $message = $feedback->messages()->create(
            $request->validated()
        );

        broadcast(new CreateMessage($message, $feedback, auth()->user()->isAdmin()));

        $this->data = [
            'message' => $message
        ];

        return $this->sendResponse();
    }
}
