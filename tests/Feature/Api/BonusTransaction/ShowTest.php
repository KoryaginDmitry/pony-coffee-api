<?php

namespace Tests\Feature\Api\BonusTransaction;

use Tests\Feature\BaseApiTestCase;

class ShowTest extends BaseApiTestCase
{
    /**
     * {@inheritDoc}
     */
    public function getRouteName(): string
    {
        return 'api.transaction.show';
    }

    /**
     * {@inheritDoc}
     */
    public function getMiddleware(): array
    {
        return ['api', 'auth'];
    }
}
