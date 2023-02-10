<?php

namespace App\Services;

use App\Http\Requests\Bonus\BonusRequest;
use App\Models\Bonus;
use App\Models\User;
use Carbon\Carbon;

/**
 * BonusService class
 *
 * @category Services
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class BonusService extends BaseService
{
    /**
     * Get information about the authenticated user's bonuses
     *
     * @return array
     */
    public function getInfoBonuses() : array
    {
        $user = User::find(auth()->id());

        $userBonuses = $user->activeBonuses()
            ->orderBy('created_at')
            ->get();

        if ($userBonuses->count()) {
            $dateBurnt = Carbon::create(
                $userBonuses->pluck('created_at')->first()
            )->addDays(Bonus::getLifetime())
            ->format("d-m-Y");
        } else {
            $dateBurnt = null;
        }

        $this->data = [
            "count" => $userBonuses->count(),
            "dateBurn" => $dateBurnt
        ];

        return $this->sendResponse();
    }

    /**
     * Create from 1 to 10 bonuses for the user
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
            "count" => $user->activeBonuses()->count(),
        ];

        $this->code = 201;

        return $this->sendResponse();
    }

    /**
     * Writes off bonuses from the user
     *
     * @param BonusRequest $request
     * @param User         $user
     *
     * @return array
     */
    public function wrote(BonusRequest $request, User $user) : array
    {
        $countBonuses = Bonus::getWriteOffQuantity() * $request->count;

        $bonuses = $user->activeBonuses()
            ->orderBy("created_at")
            ->limit($countBonuses);

        if ($bonuses->get()->count() === $countBonuses) {
            $bonuses->update(
                [
                    'usage' => '1',
                    'user_id_wrote' => auth()->id()
                ]
            );

            $this->data = [
                "count" => $user->activeBonuses()->count(),
            ];

            return $this->sendResponse();
        }

        return $this->sendErrorResponse(['Недостаточно бонусов']);
    }
}
