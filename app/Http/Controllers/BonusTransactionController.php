<?php

namespace App\Http\Controllers;

use App\Contracts\Services\BonusTransactionServiceContract;
use App\Dto\Request\Bonus\BonusTransactionDto;
use App\Http\Requests\Bonus\BonusTransactionRequest;
use App\Http\Resources\BonusTransactionResource;
use Exception;
use Fillincode\Swagger\Attributes\FormRequest;
use Fillincode\Swagger\Attributes\Group;
use Fillincode\Swagger\Attributes\Resource;
use Fillincode\Swagger\Attributes\Summary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BonusTransactionController extends Controller
{
    public function __construct(
        protected BonusTransactionServiceContract $service
    ) {}

    #[Group('BonusTransaction')]
    #[Summary('Получение всех транзакций бонусов')]
    #[Resource(BonusTransactionResource::class)]
    public function index(): AnonymousResourceCollection|JsonResponse
    {
        try {
            return $this->service->getTransactions();
        } catch (Exception $exception) {
            return $this->createErrorResponse(__('errors.transactions.index'), $exception);
        }
    }

    #[Group('BonusTransaction')]
    #[Summary('Начисление бонусов')]
    #[FormRequest(BonusTransactionRequest::class)]
    public function make(BonusTransactionRequest $request): JsonResponse
    {
        try {
            return $this->service->make(
                BonusTransactionDto::fromRequest($request)
            );
        } catch (Exception $exception) {
            return $this->createErrorResponse(__('errors.transactions.make'), $exception);
        }
    }

    #[Group('BonusTransaction')]
    #[Summary('Списание бонусов')]
    #[FormRequest(BonusTransactionRequest::class)]
    public function use(BonusTransactionRequest $request): JsonResponse
    {
        try {
            return $this->service->use(
                BonusTransactionDto::fromRequest($request)
            );
        } catch (Exception $exception) {
            return $this->createErrorResponse(__('errors.transactions.use'), $exception);
        }
    }
}
