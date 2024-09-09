<?php

namespace App\Contracts\Repositories;

use App\Dto\Request\Bonus\BonusTransactionDto;
use App\Enums\BonusTranslationEnum;
use App\Models\BonusTransaction;

interface BonusTransactionRepositoryContract
{
    public function makeTransaction(BonusTransactionDto $dto, int $barista_id, BonusTranslationEnum $enum): BonusTransaction;
}
