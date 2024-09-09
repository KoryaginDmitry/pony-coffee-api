<?php

namespace Tests\Feature\Api\User;

use Tests\Feature\BaseApiTestCase;

class ShowTest extends BaseApiTestCase
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'api.user.show';
    }

    /**
     * {@inheritDoc}
     */
    public function getMiddleware(): array
    {
        return ['api', 'auth'];
    }
}
