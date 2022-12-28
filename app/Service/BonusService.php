<?php

namespace App\Service;

use App\Models\Bonus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BonusService extends BaseService
{
    public function getInfoBonuses()
    {
        $user = User::find(auth()->id());

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

        $this->data = [
            "count" => $countActiveBonuses,
            "dateBurn" => $bonusBurnDate ? Carbon::create($bonusBurnDate->created_at)->addDays(30)->format("d-m-Y") : null,
        ];

        return $this->sendResponse();
    }

    public function search($request)
    {
        if(!empty($request->value)){
            $validator = Validator::make($request->all(), [
                "value" => ["required", "string", "min:1", "max:12"]
            ]);

            if($validator->fails()){
                return $this->sendErrorResponse($validator->errors()->all());
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

        $this->data = [
            "user" => $user
        ];

        return $this->sendResponse();
    }

    public function create($id)
    {
        $user = User::where("role_id", 3)->find($id);

        if(!$user){
            return $this->sendErrorResponse(['Такого пользователя нет']);
        }

        $user->bonuses()->create([
            "user_id_create" => auth()->id()
        ]);

        $this->data = [
            "count" => $user->countActiveBonuses(),
            "id" => $id
        ];

        $this->code = 201;

        return $this->sendResponse();
    }

    public function wrote($id)
    {
        $user = User::where("role_id", 3)->find($id);

        if(!$user){
            return $this->sendErrorResponse(['Такого пользователя нет']);
        }
        
        $bonuses = $user->bonuses()
                ->where("usage", "0")
                ->where(DB::raw("DATEDIFF(NOW(), created_at)"), "<", "30")
                ->orderBy("created_at", "DESC")
                ->limit(3);
        
        if($bonuses->get()->count() == 3){
            $bonuses->update(
                [
                    'usage' => '1',
                    'user_id_wrote' => auth()->id()
                ]
            );

            $this->data = [
                "count" => $user->countActiveBonuses(),
                "id" => $id,
            ];

            return $this->sendResponse();
        }
        
        $this->data = [
            "count" => $user->countActiveBonuses(),
            "id" => $id,
        ];

        return $this->sendErrorResponse(['Недостаточно бонусов']);
    }
}