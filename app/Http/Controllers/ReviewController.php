<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ReviewServiceContract;
use App\Dto\Request\Review\ReviewDto;
use App\Http\Requests\Review\StoreRequest;
use App\Http\Requests\Review\UpdateRequest;
use App\Http\Resources\ReviewResource;
use App\Models\CoffeePot;
use App\Models\Review;
use Exception;
use Fillincode\Swagger\Attributes\FormRequest;
use Fillincode\Swagger\Attributes\Group;
use Fillincode\Swagger\Attributes\PathParameter;
use Fillincode\Swagger\Attributes\Resource;
use Fillincode\Swagger\Attributes\Summary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReviewController extends Controller
{
    public function __construct(
        protected ReviewServiceContract $service
    ) {}

    #[Group('Review')]
    #[Summary('Создание отзыва')]
    #[FormRequest(StoreRequest::class)]
    #[Resource(ReviewResource::class)]
    public function store(StoreRequest $request): ReviewResource|JsonResponse
    {
        try {
            return $this->service->store(
                ReviewDto::fromRequest($request)
            );
        } catch (Exception $exception) {
            return $this->createErrorResponse(__('errors.review.store'), $exception);
        }
    }

    #[Group('Review')]
    #[Summary('Обновление отзыва')]
    #[FormRequest(UpdateRequest::class)]
    #[PathParameter('userReview', 'integer', 'ID отзыва')]
    #[Resource(ReviewResource::class)]
    public function update(Review $userReview, UpdateRequest $request): ReviewResource|JsonResponse
    {
        try {
            return $this->service->update(
                $userReview, ReviewDto::fromRequest($request)
            );
        } catch (Exception $exception) {
            return $this->createErrorResponse(__('errors.review.update'), $exception);
        }
    }

    #[Group('Review')]
    #[Summary('Получение отзывов текущего пользователя')]
    #[Resource(ReviewResource::class)]
    public function userReviews(): AnonymousResourceCollection|JsonResponse
    {
        try {
            return $this->service->userReviews();
        } catch (Exception $exception) {
            return $this->createErrorResponse(__('errors.review.users_reviews'), $exception);
        }
    }

    #[Group('Review')]
    #[Summary('Получение отзывов кофейни')]
    #[PathParameter('coffeePot', 'integer', 'ID кофейни')]
    #[Resource(ReviewResource::class)]
    public function coffeePotReviews(CoffeePot $coffeePot): AnonymousResourceCollection|JsonResponse
    {
        try {
            return $this->service->coffeePotReviews($coffeePot);
        } catch (Exception $exception) {
            return $this->createErrorResponse(__('errors.review.coffee_pot_reviews'), $exception);
        }

    }

    #[Group('Review')]
    #[Summary('Удаление отзыва')]
    #[PathParameter('userReview', 'integer', 'ID отзыва')]
    public function destroy(Review $userReview): JsonResponse
    {
        try {
            return $this->service->destroy($userReview);
        } catch (Exception $exception) {
            return $this->createErrorResponse(__('errors.review.destroy'), $exception);
        }
    }
}
