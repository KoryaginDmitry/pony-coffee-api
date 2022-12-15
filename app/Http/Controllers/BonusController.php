<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

class BonusController extends Controller
{
    public function getInfoBonuses()
    {
        $user = User::find(auth('api')->id());

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

        return response()->json([
            "count" => $countActiveBonuses,
            "dateBurn" => $bonusBurnDate ? Carbon::create($bonusBurnDate->created_at)->addDays(30)->format("d-m-Y") : null,
        ], 200);
    }

}
