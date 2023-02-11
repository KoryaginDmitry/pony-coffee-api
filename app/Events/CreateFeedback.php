<?php

namespace App\Events;

use App\Models\Feedback;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\Channel;

class CreateFeedback implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Event type to distribute to front-end
     *
     * @var string
     */
    public string $type;

    /**
     * Feedback and first message
     *
     * @var Feedback
     */
    public Feedback $feedback;

    /**
     * The name of the queue on which to place the broadcasting job.
     *
     * @var string
     */
    public string $queue = 'default';

    /**
     * Create a new event instance.
     *
     * @param Feedback $feedback
     *
     * @return void
     */
    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() : Channel|array
    {
        return new PrivateChannel('feedback.admin');
    }
}
