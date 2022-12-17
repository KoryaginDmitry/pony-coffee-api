<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthService
{
    public function login($request)
    {   
        $validator = Validator::make($request->all(), [
            "phone" => ["required", "regex:/(\+7)[0-9]{10}/", "exists:users"],
            "password" => ["required", "string"]
        ]);

        $user = User::where('phone', $request->phone)->first();

        if($validator->fails() || !Hash::check($request->password, $user->password)){
            return [
                "body" => [
                    "message" => "Проверьте введенные данные"
                ],
                "code" => 422
            ];
        }

        $token = $user->createToken('userToken');

        return [
            "body" => [
                "token" => $token
            ],
            "code" => 200
        ];
    }

    public function register($request)
    {
        $validator = Validator::make($request->all(),[
            "name" => ["required", "string", "max:255"],
            "phone" => ["required", "regex:/(\+7)[0-9]{10}/", "unique:users"],
            "password" => ["required", "between:8, 255" , "confirmed"],
            "agreement" => ["required", "accepted"]
        ]);

        if($validator->fails()){
            return [
                "body" => $validator->errors(),
                "code" => 422
            ];
        }

        $user = User::create([
            "name" => $request->name,
            "phone" => $request->phone,
            "password" => Hash::make($request->password),
            "agreement" => $request->agreement ? "1" : "0", 
            "role_id" => 3
        ]);

        if(!$user){
            return [
                "body" => [
                    "message" => "Ошибка регистрации"
                ],
                "code" => 500
            ];
        }

        return [
            "body" => [
                "message" => "Регистрация прошла успешно"
            ],
            "code" => 201
        ];
    }

    public function logout()
    {
        DB::table('oauth_access_tokens')->where('user_id', auth('api')->id())->delete();

        return [
            "body" => [],
            "code" => 204
        ];
    }
}