<?php

namespace App\Services;

use App\Contracts\Repositories\BonusTransactionRepositoryContract;
use App\Contracts\Services\BonusTransactionServiceContract;
use App\Dto\Request\Bonus\BonusTransactionDto;
use App\Enums\BonusTranslationEnum;
use App\Http\Resources\BonusTransactionResource;
use App\Models\User;
use App\Notifications\AddBonusesNotify;
use App\Notifications\UseBonusesNotify;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class BonusTransactionService extends BaseService implements BonusTransactionServiceContract
{
    public function __construct(
        protected BonusTransactionRepositoryContract $repository
    ) {}

    public function getTransactions(): AnonymousResourceCollection
    {
        return BonusTransactionResource::collection(
            $this->getUser()->bonusTransactions()->with('coffeePot')->paginate()
        );
    }

    /**
     * @throws Throwable
     */
    public function make(BonusTransactionDto $dto): JsonResponse
    {
        $transaction = $this->repository->makeTransaction($dto, $this->getUserKey(), BonusTranslationEnum::Accrual);

        $transaction->user->notify(new AddBonusesNotify($dto->count));

        return $this->sendResponse(['count' => $transaction->user->fresh()->bonuses]);
    }

    /**
     * @throws Throwable
     */
    public function use(BonusTransactionDto $dto): JsonResponse
    {
        $user = User::query()->find($dto->user_id);

        if ($user->bonuses < $dto->count) {
            return $this->sendErrorResponse(__('errors.not_enough_bonuses'));
        }

        $this->repository->makeTransaction($dto, $this->getUserKey(), BonusTranslationEnum::WroteOff);

        $user->notify(new UseBonusesNotify($dto->count));

        return $this->sendResponse(['count' => $user->fresh()->bonuses]);
    }
}
