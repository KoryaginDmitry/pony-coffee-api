<?php

namespace App\Contracts\Services;

use App\Dto\Request\Review\ReviewDto;
use App\Http\Resources\ReviewResource;
use App\Models\CoffeePot;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface ReviewServiceContract
{
    public function store(ReviewDto $dto): ReviewResource;

    public function update(Review $review, ReviewDto $dto): ReviewResource;

    public function userReviews(): AnonymousResourceCollection;

    public function coffeePotReviews(CoffeePot $coffeePot): AnonymousResourceCollection;

    public function destroy(Review $review): JsonResponse;
}
