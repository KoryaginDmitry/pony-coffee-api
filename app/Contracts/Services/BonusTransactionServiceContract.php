<?php

namespace App\Contracts\Services;

use App\Dto\Request\Bonus\BonusTransactionDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface BonusTransactionServiceContract
{
    public function getTransactions(): AnonymousResourceCollection;

    public function make(BonusTransactionDto $dto): JsonResponse;

    public function use(BonusTransactionDto $dto): JsonResponse;
}
