<?php

namespace App\Service;

use App\Models\User;

class StatisticService
{
    public function barista()
    {
        $users = User::where("role_id", "2")
                ->with(["bonusesCreate" => function($query){
                    $query->selectRaw("*, DATE_FORMAT(created_at, '%d-%m-%Y') AS date");
                }, 
                "bonusesWrote" => function($query){
                    $query->selectRaw("*, DATE_FORMAT(updated_at, '%d-%m-%Y') AS date");
                }])
                ->get();
        
        return $users;
    }

    public function user()
    {
        $users = User::where("role_id", "3")
                ->with(["bonuses" => function($query){
                    $query->selectRaw("
                        *, DATE_FORMAT(created_at, '%d-%m-%Y') AS date, 
                            CASE 
                                WHEN DATEDIFF(NOW(), created_at) < 30
                                    THEN '0'
                                ELSE '1'
                            END AS 'burnt'");
                }])
                ->get();
        
        return $users;
    }
}