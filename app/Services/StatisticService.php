<?php

/**
 * Statistic service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Services;

use App\Models\User;

/**
 * StatisticService class
 * 
 * @method array barista()
 * @method array user()
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
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
        $this->data['barista'] = User::where("role_id", "2")
            ->with(
                [
                    "bonusesCreate",
                    "bonusesWrote"
                ]
            )
            ->get();
        
        return $this->sendResponse();
    }

    /**
     * Get a collection of bonuses for user statistics
     *
     * @return array
     */
    public function user() : array
    {
        $this->data['user'] = User::where("role_id", "3")
            ->with("bonuses")
            ->get(); 
        
        return $this->sendResponse();
    }
}