<?php

namespace App\Services;

use App\Http\Requests\Bonus\BonusRequest;
use App\Models\Bonus;
use App\Models\User;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        
        $userBonuses = $user->activeBonuses()->get();

        $bonusBurnDate = $userBonuses
            ->pluck('created_at')
            ->first();

        $this->data = [
            "count" => $userBonuses->count(),
            "dateBurn" => $bonusBurnDate ? Carbon::create(
                $bonusBurnDate
            )->addDays(Bonus::getLifetime())->format("d-m-Y") : null
        ];

        return $this->sendResponse();
    }
    
    /**
     * Create bonus for user
     *
     * @param BonusRequest $request
     * @param User         $user
     * 
     * @return array
     */
    public function create(BonusRequest $request, User $user) : array
    {
        $user->bonuses()->createMany(
            array_fill(0, $request->count, ["user_id_create" => auth()->id()])
        );

        $this->data = [
            "count" => $user->getActiveBonuses()->count(),
        ];

        $this->code = 201;

        return $this->sendResponse();
    }

    /**
     * Wrote bonuses user
     *
     * @param BonusRequest $request
     * @param User         $user
     * 
     * @return array
     */
    public function wrote(BonusRequest $request, User $user) : array
    {
        $countBonuses = Bonus::getWriteOffQuantity() * $request->count;
        
        $bonuses = $user->bonuses()
            ->where("usage", "0")
            ->where(
                DB::raw("DATEDIFF(NOW(), created_at)"), "<", Bonus::getLifetime()
            )
            ->orderBy("created_at")
            ->limit($countBonuses);
    
        if ($bonuses->get()->count() == $countBonuses) {
            $bonuses->update(
                [
                    'usage' => '1',
                    'user_id_wrote' => auth()->id()
                ]
            );

            $this->data = [
                "count" => $user->getActiveBonuses()->count(),
            ];

            return $this->sendResponse();
        }
        
        return $this->sendErrorResponse(['Недостаточно бонусов']);
    }
}