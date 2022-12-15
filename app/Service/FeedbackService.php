<?php

namespace App\Service;

use App\Models\CoffeePot;
use App\Models\Feedback;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;

class FeedbackService
{
    public function getFeedback($coffeePot_id)
    {
        if(auth('api')->user()->role->name == 'admin'){
            if($coffeePot_id != 0){
                $coffeePot = CoffeePot::find($coffeePot_id);
                
                if(!$coffeePot){
                    return [
                        "body" => [
                            "message" => "Такой кофе точки нет"
                        ],
                        "code" => 422
                    ];
                }

                $feedbacks = Feedback::where("coffee_pot_id", $coffeePot_id)
                    ->with('messages')
                    ->get();
            }
            else{
                $feedbacks = Feedback::with("messages")->get();
            }
        }
        else{
            $feedbacks = Feedback::where('user_id', auth('api')->id())
                ->with("messages")
                ->get();
        }

        return [
            "body" => $feedbacks,
            "code" => 200
        ];
    }

    public function create($request)
    {
        $validator = Validator::make($request->all(),[
            "coffeePot" => ["required", "exists:coffee_pots,id"],
            "grade" => ["nullable", "min:1", "max:5"],
            "text" => ["required", "string", "min:15"]
        ]);
        
        if($validator->fails()){
            return [
                "body" => $validator->errros(),
                "code" => 422
            ];
        }
        
        $feedback = Feedback::create([
            "grade" => $request->grade,
            "user_id" => auth('api')->id(),
            "coffee_pot_id" => $request->coffeePot
        ]);

        $message = Message::create([
            "text" => $request->text,
            "user_id" => auth('api')->id(),
            "feedback_id" => $feedback->id
        ]);

        return [
            "body" => [
                "feedback" => $feedback,
                "message" => $message
            ],
            "code" => 201
        ];
    }

    public function createMessage($id, $request)
    {
        $validator = Validator::make($request->all(),[
            "text" => ["required", "string", "min:5"]
        ]);

        if($validator->fails()){
            return [
                "body" => $validator->errros(),
                "code" => 422
            ];
        }

        if(auth('api')->user()->role->name == 'admin'){
            $feedback = Feedback::find($id);
        }       
        else{
            $feedback = Feedback::where("user_id", auth('api')->id())->find($id);
        } 

        if(!$feedback){
            return [
                "body" => [
                    "message" =>  "Проверьте данные, которые вы передаете"
                ],
                "code" => 422
            ];
        }

        $message = Message::create([
            "text" => $request->text,
            "user_id" => auth('api')->id(),
            "feedback_id" => $feedback->id
        ]);

        return [
            "body" => [
                "message" => $message
            ],
            "code" => 200
        ];
    }
}