<?php

namespace Tests\Feature\Api\Review;

use App\Models\CoffeePot;
use Fillincode\Tests\Contracts\ParametersContract;
use Tests\Feature\BaseApiTestCase;

class CoffeePotReviewsTest extends BaseApiTestCase implements ParametersContract
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'api.review.coffeePot';
    }

    /**
     * {@inheritDoc}
     */
    public function getMiddleware(): array
    {
        return ['api', 'auth'];
    }

    public function parameters(string $user_key): array
    {
        return [
            'coffeePot' => CoffeePot::query()->inRandomOrder()->value('id'),
        ];
    }
}
