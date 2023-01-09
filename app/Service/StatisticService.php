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
                    "bonusesCreate" => function ($query) {
                        $query->selectRaw("*, DATE_FORMAT(created_at, '%d-%m-%Y') AS date");
                    }, 
                    "bonusesWrote" => function ($query) {
                        $query->selectRaw("*, DATE_FORMAT(updated_at, '%d-%m-%Y') AS date");
                    }
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
            ->with(
                [
                    "bonuses" => function ($query) {
                        $query->selectRaw(
                            "*, DATE_FORMAT(created_at, '%d-%m-%Y') AS date, 
                                CASE 
                                    WHEN DATEDIFF(NOW(), created_at) < 30
                                        THEN '0'
                                    ELSE '1'
                                END AS 'burnt'"
                        );
                    }
                ]
            )
            ->get();
        
        return $this->sendResponse();
    }
}