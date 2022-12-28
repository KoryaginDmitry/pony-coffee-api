<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileService extends BaseService
{
    public function user()
    {
        $this->data = auth()->user();

        $this->sendResponse();
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
            return $this->sendErrorResponse($validator->erros->all());
        }   

        $user = User::find(auth()->id());
        
        if($user->email != $request->email){
            if(User::where("email", $request->email)->exists()){
                return $this->sendErrorResponse(['Такой email уже занят']);
            }

            $user->email = $request->email;
            $user->email_verified_at = NULL;
        }

        if($user->phone != $request->phone){
            if(User::where("phone", $request->phone)->exists()){
                return $this->sendErrorResponse(['Такой номер телефона уже занят']);
            }

            $user->phone = $request->phone;
            $user->phone_verified_at = NULL;
        }

        $user->name = $request->name;
        $user->last_name = $request->last_name ? $request->last_name : NULL;
        $user->save();

        $this->data = [
            'user' => $user
        ];
        
        $this->sendResponse();
    }

    public function newPassword($request)
    {
        $validator = Validator::make($request->all(), [
            "password" => ["required", "between:8, 255" , "confirmed"],
        ]);

        if($validator->fails()){
            return $this->sendErrorResponse($validator->errros()->all());
        } 

        $user = auth()->user();

        $user->password = Hash::make($request->password);

        $user->save;

        $this->data = [
            "message" => "Пароль изменен"
        ];
        
        return $this->sendResponse();
    }
}