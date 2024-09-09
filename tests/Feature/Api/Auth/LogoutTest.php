<?php

namespace Tests\Feature\Api\Auth;

use Tests\Feature\BaseApiTestCase;

class LogoutTest extends BaseApiTestCase
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'api.auth.logout';
    }

    /**
     * {@inheritDoc}
     */
    public function getMiddleware(): array
    {
        return ['api', 'auth'];
    }
}
