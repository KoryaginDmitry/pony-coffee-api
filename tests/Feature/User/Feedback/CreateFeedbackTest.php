<?php

namespace Tests\Feature\User\Feedback;

use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CreateFeedbackTest extends TestCase
{
    /**
     * @var array
     */
    private array $data = [
        'text' => 'all good',
        'grade' => '4',
        'coffee_pot_id' => 1
    ];

    /**
     * @var array
     */
    private array $invalidData = [
        'text' => '',
        'grade' => 'adw',
        'coffee_pot_id' => 124
    ];

    /**
     * Getting the route name
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return 'feedback.create';
    }

    /**
     * @return void
     */
    public function testMiddleware() : void
    {
        $this->assertRouteHasExactMiddleware('role:user', 'api');
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromAdmin(): void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(1),
            $this->data
        )->assertNotFound();
    }

    /**
     * testing from barista profile
     *
     * @return void
     */
    public function testFromBarista(): void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(2),
            $this->data
        )->assertNotFound();
    }

    /**
     * testing from user profile
     *
     * @return void
     */
    public function testFromUser(): void
    {
        Event::fake();

        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            $this->data
        )->assertCreated();
    }

    /**
     * testing from admin profile
     *
     * @return void
     */
    public function testFromGuest(): void
    {
        $this->callRouteAction(
            $this->data
        )->assertNotFound();
    }

    /**
     * @return void
     */
    public function testValidate() : void
    {
        $this->callAuthorizedByUserRouteAction(
            User::find(3),
            $this->invalidData
        )
            ->assertUnprocessable()
            ->assertJsonCount('3', 'errors.message');
    }
}
