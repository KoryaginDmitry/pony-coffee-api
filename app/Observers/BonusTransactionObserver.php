<?php

namespace App\Observers;

use App\Enums\BonusTranslationEnum;
use App\Models\BonusTransaction;

class BonusTransactionObserver
{
    /**
     * Handle the BonusTransaction "created" event.
     */
    public function created(BonusTransaction $bonusTransaction): void
    {
        match ($bonusTransaction->type) {
            BonusTranslationEnum::Accrual => $bonusTransaction->user()->increment('bonuses', $bonusTransaction->count),
            BonusTranslationEnum::WroteOff => $bonusTransaction->user()->decrement('bonuses', $bonusTransaction->count)
        };
    }
}
