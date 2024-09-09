<?php

namespace App\Services;

use App\Contracts\Services\ReviewServiceContract;
use App\Dto\Request\Review\ReviewDto;
use App\Http\Resources\ReviewResource;
use App\Models\CoffeePot;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReviewService extends BaseService implements ReviewServiceContract
{
    public function store(ReviewDto $dto): ReviewResource
    {
        return ReviewResource::make(
            $this->getUser()->reviews()->create($dto->toArray())
        );
    }

    public function update(Review $review, ReviewDto $dto): ReviewResource
    {
        $review->update(
            $dto->except('coffee_pot_id')->toArray()
        );

        return ReviewResource::make($review);
    }

    public function userReviews(): AnonymousResourceCollection
    {
        return ReviewResource::collection(
            $this->getUser()->reviews()->paginate()
        );
    }

    public function coffeePotReviews(CoffeePot $coffeePot): AnonymousResourceCollection
    {
        return ReviewResource::collection(
            $coffeePot->reviews()->paginate()
        );
    }

    public function destroy(Review $review): JsonResponse
    {
        $review->delete();

        return $this->sendResponse(code: 204);
    }
}
