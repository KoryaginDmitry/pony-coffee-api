<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{   
    public function getFeedback()
    {
        if(auth('api')->user()->role->name == 'admin'){
            $feedbacks = Feedback::with("messages")->get();
        }
        else{
            $feedbacks = Feedback::where('user_id', auth('api')->id())
                ->with("messages")
                ->get();
        }

        return response()->json([$feedbacks], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "coffeePot" => ["required", "exists:coffee_pots,id"],
            "grade" => ["nullable", "min:1", "max:5"],
            "text" => ["required", "string", "min:15"]
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
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

        return response()->json([
            "feedback" => $feedback,
            "message" => $message
        ],201);
    }

    public function createMessage($id, Request $request)
    {   
        $validator = Validator::make($request->all(),[
            "text" => ["required", "string", "min:5"]
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors(), 422]);
        }

        if(auth('api')->user()->role->name == 'admin'){
            $feedback = Feedback::find($id);
        }       
        else{
            $feedback = Feedback::where("user_id", auth('api')->id())->find($id);
        } 

        if(!$feedback){
            return response()->json([
                "message" => "Проверьте данные, которые вы передаете"
            ],422);
        }

        $message = Message::create([
            "text" => $request->text,
            "user_id" => auth('api')->id(),
            "feedback_id" => $feedback->id
        ]);

        return response()->json(["message" => $message], 200);
    }
}
