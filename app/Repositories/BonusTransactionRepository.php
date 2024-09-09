<?php

namespace App\Repositories;

use App\Contracts\Repositories\BonusTransactionRepositoryContract;
use App\Dto\Request\Bonus\BonusTransactionDto;
use App\Enums\BonusTranslationEnum;
use App\Models\BonusTransaction;

class BonusTransactionRepository implements BonusTransactionRepositoryContract
{
    public function makeTransaction(BonusTransactionDto $dto, int $barista_id, BonusTranslationEnum $enum): BonusTransaction
    {
        return BonusTransaction::query()->create([
            'user_id' => $dto->user_id,
            'barista_id' => $barista_id,
            'coffee_pot_id' => $dto->coffee_pot_id,
            'type' => $enum,
            'count' => $dto->count,
        ]);
    }
}
