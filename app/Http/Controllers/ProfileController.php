<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function getUser()
    {
        return auth('api')->user();
    }

    public function update(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string", "min:3"],
            "last_name" => ["nullable", "string"],
            "phone" => ["required", "regex:/(\+7)[0-9]{10}/"],
            "email" => ["nullable", "email"]
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }   

        $user = User::find(auth('api')->id());
        
        if($user->email != $request->email){
            if(User::where("email", $request->email)->exists()){
                return response()->json([
                    'update' => false,
                    'message' => 'Такое email уже занят'
                ], 422);
            }

            $user->email = $request->email;
            $user->email_verified_at = NULL;
        }

        if($user->phone != $request->phone){
            if(User::where("phone", $request->phone)->exists()){
                return response()->json([
                    'update' => false,
                    'message' => 'Такое номер телефона уже занят'
                ], 422);
            }

            $user->phone = $request->phone;
            $user->phone_verified_at = NULL;
        }

        $user->name = $request->name;
        $user->last_name = $request->last_name ? $request->last_name : NULL;
        $user->save();

        return response()->json([
            "update" => true,
            "user" => $user
        ], 200);
    }
}
