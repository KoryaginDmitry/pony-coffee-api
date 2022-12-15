<?php

namespace App\Service;

use App\Models\Bonus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BonusService
{
    public function getInfoBonuses()
    {
        $user = User::find(auth('api')->id());

        $countActiveBonuses = $user->bonuses()->where("usage", "0")
        ->where(DB::raw("DATEDIFF(NOW(), created_at)"), "<", "30")
        ->get()
        ->count();

        $bonusBurnDate = Bonus::select("created_at")
            ->where([
                "user_id" => auth()->id(),
                "usage" => "0"
            ])->where(DB::raw("DATEDIFF(NOW(), created_at)"), "<", "30")
            ->orderBy("created_at", "DESC")
            ->first();

        return [
            "body" => [
                "count" => $countActiveBonuses,
                "dateBurn" => $bonusBurnDate ? Carbon::create($bonusBurnDate->created_at)->addDays(30)->format("d-m-Y") : null,
            ],
            "code" => 200
        ];
    }

    public function search($request)
    {
        if(!empty($request->value)){
            $validator = Validator::make($request->all(), [
                "value" => ["required", "string", "min:1", "max:12"]
            ]);

            if($validator->fails()){
                return [
                    "body" => $validator->errors(),
                    "code" => 422
                ];
            }

            $user = User::where("role_id", "3")
                ->where("id", $request->value)
                ->orWhere("phone", $request->value)
                ->with(['bonuses' => function($query){
                    $query->where("usage", "0")
                        ->where(DB::raw("DATEDIFF(NOW(), created_at)"), "<", "30");
                }])
                ->get();
        }
        else{
            $user = User::where("role_id", 3)->with(['bonuses' => function($query){
                    $query->where("usage", "0")
                        ->where(DB::raw("DATEDIFF(NOW(), created_at)"), "<", "30");
                }])
                ->get();
        }

        return [
            "body" => $user,
            "code" => 200
        ];
    }

    public function create($id)
    {
        $user = User::where("role_id", 3)->find($id);

        if(!$user){
            return [
                "body" => [
                    "message" => "Такого пользователя нет"
                ],
                "code" => 422
            ];
        }

        $user->bonuses()->create([
            "user_id_create" => auth('api')->id()
        ]);

        return [
            "body" => [
                "count" => $user->countActiveBonuses(),
                "id" => $id
            ],
            "code" => 201
        ];
    }

    public function wrote($id)
    {
        $user = User::where("role_id", 3)->find($id);

        if(!$user){
            return [
                "body" => [
                    "message" => "Такого пользователя нет"
                ],
                "code" => 422
            ];
        }
        
        $bonuses = $user->bonuses()
                ->where("usage", "0")
                ->where(DB::raw("DATEDIFF(NOW(), created_at)"), "<", "30")
                ->orderBy("created_at", "DESC")
                ->limit(3)
                ->get();
        
        if($bonuses->count() == 3){
            foreach($bonuses as $bonus){
                $bonus->usage = '1';
                $bonus->user_id_wrote = auth('api')->id();

                $bonus->save();
            }
        
            return [
                "body" => [
                    "count" => $user->countActiveBonuses(),
                    "id" => $id,
                    "message" => "Бонусы списаны"
                ],
                "code" => 200
            ];
        }
        else{
            return [
                "body" => [
                    "count" => $user->countActiveBonuses(),
                    "id" => $id,
                    "message" => "Недостаточно бонусов"
                ],
                "code" => 422
            ];
        }
    }
}