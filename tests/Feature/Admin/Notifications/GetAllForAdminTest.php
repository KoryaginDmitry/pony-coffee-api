<?php

namespace Tests\Feature\Admin\Notifications;

use App\Models\User;
use Tests\TestCase;

class GetAllForAdminTest extends TestCase
{

    /**
     * @return string
     */
    public function getRouteName(): string
    {
        return 'notification.getForAdmin';
    }

    /**
     * @return void
     */
    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('role:admin', 'api');
    }

    /**
     * @return void
     */
    public function testFromAdmin() : void
    {
        $this->callAuthorizedByUserRouteAction(User::find(1))
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testFromBarista() : void
    {
        $this->callAuthorizedByUserRouteAction(User::find(2))
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testFromUser() : void
    {
        $this->callAuthorizedByUserRouteAction(User::find(3))
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testFromGuest() : void
    {
        $this->callRouteAction()
            ->assertNotFound();
    }
}
