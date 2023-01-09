<?php

/**
 * Statistic service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @package Category
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 * 
 * @license http://href.com MIT
 * 
 * @link http://href.com
 */
namespace App\Service;

use App\Models\User;

/**
 * StatisticService class
 * 
 * @method mixed barista()
 * @method mixed user()
 * 
 * @category Services
 * 
 * @package Category
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 * 
 * @license http://href.com MIT
 * 
 * @link http://href.com
 */
class StatisticService extends BaseService
{
    /**
     * Get a collection of bonuses for barista statistics
     *
     * @return mixed
     */
    public function barista() : mixed
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
     * @return mixed
     */
    public function user() : mixed
    {
        $this->data['user'] = User::where("role_id", "3")
            ->with("bonuses")
            ->get(); 
        
        return $this->sendResponse();
    }
}