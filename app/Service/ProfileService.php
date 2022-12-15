<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ProfileService
{
    public function user()
    {
        return auth('api')->user();
    }

    public function update($request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string", "min:3"],
            "last_name" => ["nullable", "string"],
            "phone" => ["required", "regex:/(\+7)[0-9]{10}/"],
            "email" => ["nullable", "email"]
        ]);

        if($validator->fails()){
            return [
                "body" => $validator->errors(),
                "code" => 422
            ];
        }   

        $user = User::find(auth('api')->id());
        
        if($user->email != $request->email){
            if(User::where("email", $request->email)->exists()){
                return [
                    "body" => [
                        "message" => "Такой email уже занят"
                    ],
                    "code" => 422
                ];
            }

            $user->email = $request->email;
            $user->email_verified_at = NULL;
        }

        if($user->phone != $request->phone){
            if(User::where("phone", $request->phone)->exists()){
                return [
                    "body" => [
                        "message" => "Такой номер телефона уже занят"
                    ],
                    "code" => 422
                ];
            }

            $user->phone = $request->phone;
            $user->phone_verified_at = NULL;
        }

        $user->name = $request->name;
        $user->last_name = $request->last_name ? $request->last_name : NULL;
        $user->save();

        return [
            "body" => $user,
            "code" => 200
        ];
    }
}