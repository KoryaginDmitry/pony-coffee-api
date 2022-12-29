<?php

namespace App\Service;

use App\Models\User;

/**
 * Undocumented class
 */
class StatisticService extends BaseService
{   
    /**
     * Undocumented function
     *
     * @return void
     */
    public function barista()
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
     * Undocumented function
     *
     * @return void
     */
    public function user()
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