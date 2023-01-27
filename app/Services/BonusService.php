<?php

/**
 * Bonus service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Services;

use App\Models\Bonus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
 * @author DmitryKoryagin <kor.dima97@mail.ru>
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
        
        $userBonuses = $user->getActiveBonuses();

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
     * Return all users and bonuses
     *
     * @return array
     */
    public function getUsers() : array
    {
        $this->data = [
            'users' => User::where('role_id', 2)->bonus()->get()
        ];

        return $this->sendResponse();
    }

    /**
     * Create bonus for user
     *
     * @param User $user
     * 
     * @return array
     */
    public function create(User $user) : array
    {
        $user->bonuses()->create(
            [
                "user_id_create" => auth()->id()
            ]
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
     * @param User $user
     * 
     * @return array
     */
    public function wrote(User $user) : array
    {
        $bonuses = $user->bonuses()
            ->where("usage", "0")
            ->where(
                DB::raw("DATEDIFF(NOW(), created_at)"), "<", Bonus::getLifetime()
            )
            ->orderBy("created_at", "DESC")
            ->limit(Bonus::getWriteOffQuantity())
            ->get();
        
        if ($bonuses->count() == Bonus::getWriteOffQuantity()) {
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