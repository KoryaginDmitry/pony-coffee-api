<?php

namespace App\Service;

use App\Models\CoffeePot;
use App\Models\Feedback;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;

class FeedbackService extends BaseService
{   
    private function getAdminFeedback($coffeePot_id)
    {
        if($coffeePot_id != 0){
            $coffeePot = CoffeePot::find($coffeePot_id);
            
            if(!$coffeePot){
                return null;
            }

            return Feedback::where("coffee_pot_id", $coffeePot_id)
                ->with('messages')
                ->get();
        }
        else{
            return Feedback::with("messages")->get();
        }
    }

    public function getFeedback($coffeePot_id)
    {
        if(auth()->user()->role->name == 'admin'){
            $feedbacks = $this->getAdminFeedback($coffeePot_id);
        }
        else{
            $feedbacks = Feedback::where('user_id', auth('api')->id())
                ->with("messages")
                ->get();
        }

        $this->data = $feedbacks;

        return $this->sendResponse();
    }

    public function create($request)
    {
        $validator = Validator::make($request->all(),[
            "coffeePot" => ["required", "exists:coffee_pots,id"],
            "grade" => ["nullable", "min:1", "max:5"],
            "text" => ["required", "string", "min:15"]
        ]);
        
        if($validator->fails()){
            return $this->sendErrorResponse($validator->errors()->all());
        }
        
        $feedback = Feedback::create([
            "grade" => $request->grade,
            "user_id" => auth()->id(),
            "coffee_pot_id" => $request->coffeePot
        ]);

        $message = Message::create([
            "text" => $request->text,
            "user_id" => auth()->id(),
            "feedback_id" => $feedback->id
        ]);

        $this->data = [
            "feedback" => $feedback,
            "message" => $message
        ];

        $this->code = 201;
        
        return $this->sendResponse();
    }

    public function createMessage($id, $request)
    {
        $validator = Validator::make($request->all(),[
            "text" => ["required", "string", "min:5"]
        ]);

        if($validator->fails()){
            return $this->sendErrorResponse($validator->errors()->all());
        }

        if(auth()->user()->role->name == 'admin'){
            $feedback = Feedback::find($id);
        }       
        else{
            $feedback = Feedback::where("user_id", auth()->id())->find($id);
        } 

        if(!$feedback){
            return $this->sendErrorResponse(['Проверьтеданные, которые вы передаете']);
        }

        $message = Message::create([
            "text" => $request->text,
            "user_id" => auth('api')->id(),
            "feedback_id" => $feedback->id
        ]);

        $this->data = $message;
        
        return $this->sendResponse();
    }
}