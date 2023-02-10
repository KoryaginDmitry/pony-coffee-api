<?php

namespace App\Services;

use App\Models\Bonus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * StatisticService class
 *
 * @category Services
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class StatisticService extends BaseService
{
    /**
     * Get a collection of bonuses for barista statistics
     *
     * @return array
     */
    public function barista() : array
    {
        $this->data = [
            'barista' => User::where("role_id", "2")
                ->with(["bonusesCreate", "bonusesWrote"])
                ->get()
        ];

        return $this->sendResponse();
    }

    /**
     * Get a collection of bonuses for user statistics
     *
     * @return array
     */
    public function user() : array
    {
        $this->data = [
            'user' => User::where("role_id", "3")
                ->withCount(["activeBonuses", "usingBonuses", "burntBonuses"])
                ->get()
        ];

        return $this->sendResponse();
    }

    /**
     * Get user statistics for a week or month
     *
     * @param int $interval
     *
     * @return array
     */
    public function userTimeInterval(int $interval) : array
    {
        $this->data = [
            'users' => User::where("role_id", "3")
                ->withCount(
                    [
                        "activeBonuses" => function ($query) use ($interval) {
                            return $query->where(
                                DB::raw("DATEDIFF(NOW(), created_at)"), "<", $interval
                            );
                        },
                        "usingBonuses" => function ($query) use ($interval) {
                            return $query->where(
                                DB::raw("DATEDIFF(NOW(), updated_at)"), "<", $interval
                            );
                        },
                        "burntBonuses" => function ($query) use ($interval) {
                            return $query->where(
                                DB::raw(
                                    "DATEDIFF(NOW(), DATE_ADD(created_at, INTERVAL " . Bonus::getLifetime() . " DAY))"
                                ), "<", $interval
                            );
                        }
                    ]
                )->get()
        ];

        return $this->sendResponse();
    }
}
