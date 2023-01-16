<?php

/**
 * Bonus service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Service;

use App\Models\Bonus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * BonusService class
 * 
 * @method array getInfoBonuses()
 * @method array search(object $request)
 * @method array create(int id)
 * @method array wrote(int $id)
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 */
class BonusService extends BaseService
{
    /**
     * Get information about auth user bonuses
     *
     * @return array
     */
    public function getInfoBonuses() : array
    {
        $user = User::find(auth()->id());

        $countActiveBonuses = $user->bonuses()
            ->where("usage", "0")
            ->get()
            ->where('burnt', '0')
            ->count();

        $bonusBurnDate = Bonus::select("created_at")
            ->where(
                [
                    "user_id" => auth()->id(),
                    "usage" => "0"
                ]
            )
            ->orderBy("created_at", "DESC")
            ->get()
            ->where('burnt', '0')
            ->first();

        $this->data = [
            "count" => $countActiveBonuses,
            "dateBurn" => $bonusBurnDate ? Carbon::create(
                $bonusBurnDate->created_at
            )->addDays(30)->format("d-m-Y") : null,
        ];

        return $this->sendResponse();
    }

    /**
     * Serch user
     *
     * @param object $request object Request class
     * 
     * @return array
     */
    public function search(object $request) : array
    {
        if (!empty($request->value)) {
            $validator = Validator::make(
                $request->all(), [
                    "value" => ["required", "string", "min:1", "max:12"]
                ]
            );

            if ($validator->fails()) {
                return $this->sendErrorResponse($validator->errors()->all());
            }

            $user = User::where("role_id", "3")
                ->where("id", $request->value)
                ->orWhere("phone", $request->value)
                ->with(
                    [
                        'bonuses' => function ($query) {
                            $query->where("usage", "0")
                                ->where(
                                    DB::raw("DATEDIFF(NOW(), created_at)"), "<", "30"
                                );
                        }
                    ]
                )
                ->get();
        } else {
            $user = User::where("role_id", 3)->with(
                [
                    'bonuses' => function ($query) {
                        $query->where("usage", "0")
                            ->where(
                                DB::raw("DATEDIFF(NOW(), created_at)"), "<", "30"
                            );
                    }
                ]
            )
            ->get();
        }

        $this->data = [
            "user" => $user
        ];

        return $this->sendResponse();
    }

    /**
     * Create bonus for user
     *
     * @param int $id id user
     * 
     * @return array
     */
    public function create(int $id) : array
    {
        $user = User::where("role_id", 3)->find($id);

        if (!$user) {
            return $this->sendErrorResponse(['Такого пользователя нет']);
        }

        $user->bonuses()->create(
            [
            "user_id_create" => auth()->id()
            ]
        );

        $this->data = [
            "count" => $user->countActiveBonuses(),
            "id" => $id
        ];

        $this->code = 201;

        return $this->sendResponse();
    }

    /**
     * Wrote bonuses user
     *
     * @param int $id id user
     * 
     * @return array
     */
    public function wrote(int $id) : array
    {
        $user = User::where("role_id", 3)->find($id);

        if (!$user) {
            return $this->sendErrorResponse(['Такого пользователя нет']);
        }
        
        $bonuses = $user->bonuses()
            ->where("usage", "0")
            ->where(DB::raw("DATEDIFF(NOW(), created_at)"), "<", "30")
            ->orderBy("created_at", "DESC")
            ->limit(3)
            ->get();
        
        if ($bonuses->count() == 3) {
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