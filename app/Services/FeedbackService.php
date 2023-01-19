<?php

/**
 * Feedback service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Services;

use App\Models\Feedback;
use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;


/**
 * FeedbackService class
 * 
 * @method App\Models\Feedback _getAdminFeedback(int $id)
 * @method array getFeedback(int $id)
 * @method array create(object $request)
 * @method array createMessage(int $id, object $request)
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 */
class FeedbackService extends BaseService
{
    /**
     * Get all feedbacks for admin
     *
     * @param int $id id coffee pot
     * 
     * @return Collection
     */
    private function _getAdminFeedback(int $id) : Collection
    {
        return Feedback::when(
            ($id !== 0),
            function ($query) use ($id) {
                return $query->where("coffee_pot_id", $id);
            }
        )->with(
            [
                'messages',
                'coffeePot'
            ]
        )
        ->get();
    }

    /**
     * Get feedbacks
     *
     * @param int $id id coffee pot
     * 
     * @return array
     */
    public function getFeedback(int $id) : array
    {
        if (auth()->user()->isAdmin()) {
            $feedbacks = $this->_getAdminFeedback($id);
        } else {
            $feedbacks = Feedback::where('user_id', auth()->id())
                ->with(
                    [
                        'messages',
                        'coffeePot'
                    ]
                )
                ->get();
        }

        $this->data = [
            'feedbacks' => $feedbacks
        ];

        return $this->sendResponse();
    }

    /**
     * Create feedback and message
     *
     * @param object $request class Request object
     * 
     * @return array
     */
    public function create(object $request) : array
    {
        $this->validate(
            $request->all(),
            [
                "coffeePot_id" => ["required", "exists:coffee_pots,id"],
                "grade" => ["nullable", "integer", "min:1", "max:5"],
                "text" => ["required", "string", "min:15"]
            ]
        );

        $feedback = Feedback::create(
            [
                "grade" => $request->grade,
                "user_id" => auth()->id(),
                "coffee_pot_id" => $request->coffeePot_id
            ]
        );

        $message = Message::create(
            [
                "text" => $request->text,
                "user_id" => auth()->id(),
                "feedback_id" => $feedback->id
            ]
        );

        $this->data = [
            "feedback" => $feedback,
            "message" => $message
        ];

        $this->code = 201;

        return $this->sendResponse();
    }

    /**
     * Create message for feedback
     * 
     * @param int    $id      id feedback
     * @param object $request class Request object
     * 
     * @return array
     */
    public function createMessage(int $id, object $request) : array
    {
        $this->validate(
            $request->all(),
            [
                'text' => ["required", "string", "min:5"]
            ]
        );

        if (auth()->user()->isAdmin()) {
            $feedback = Feedback::findOrFail($id);
        } else {
            $feedback = Feedback::where("user_id", auth()->id())->findOrFail($id);
        }

        $message = Message::create(
            [
                "text" => $request->text,
                "user_id" => auth()->id(),
                "feedback_id" => $feedback->id
            ]
        );

        $this->data = [
            'message' => $message
        ];

        return $this->sendResponse();
    }
}
