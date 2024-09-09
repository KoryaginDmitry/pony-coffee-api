<?php

namespace Tests\Feature\Api\Review;

use Tests\Feature\BaseApiTestCase;

class UserReviewsTest extends BaseApiTestCase
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'api.review.user';
    }

    /**
     * {@inheritDoc}
     */
    public function getMiddleware(): array
    {
        return ['api', 'auth'];
    }
}
