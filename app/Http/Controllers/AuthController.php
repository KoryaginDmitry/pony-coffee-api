<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "phone" => ["required", "regex:/(\+7)[0-9]{10}/", "exists:users"],
            "password" => ["required", "string"]
        ]);

        $user = User::where('phone', $request->phone)->first();

        if($validator->fails() || !Hash::check($request->password, $user->password)){
            return response()->json([
                "login" => false,
                "message" => "Проверьте введенные данные"
            ], 422);
        }

        $token = $user->createToken('userToken');

        return response()->json([
            "login" => true,
            "token" => $token
        ], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name" => ["required", "string", "max:255"],
            "phone" => ["required", "regex:/(\+7)[0-9]{10}/", "unique:users"],
            "password" => ["required", "between:8, 255" , "confirmed"],
            "agreement" => ["required", "accepted"]
        ]);

        if($validator->fails()){
            return response()->json(["errors" => $validator->errors()->all()], 422);
        }

        $user = User::create([
            "name" => $request->name,
            "phone" => $request->phone,
            "password" => Hash::make($request->password),
            "agreement" => $request->agreement ? "1" : "0", 
            "role_id" => 3
        ]);

        if(!$user){
            return response()->json([
                "register" => false, 
                "message" => "Ошибка регистрации"
            ], 500);
        }

        return response()->json([
            "register" => true,
            "message" => "Регистрация прошла успешно"
        ], 200); 
    }
}
