<?php

namespace App\Events;

use App\Models\Feedback;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\Channel;

class CreateMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The name of the queue on which to place the broadcasting job.
     *
     * @var string
     */
    public string $queue = 'default';

    /**
     * Construct
     *
     * @param Model    $message
     * @param Feedback $feedback
     * @param bool     $isAdmin
     */
    public function __construct(
        public Model $message,
        public Feedback $feedback,
        public bool $isAdmin)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() : Channel|array
    {
        if ($this->isAdmin) {
            return new PrivateChannel('message.user.' . $this->feedback->user_id);
        }

        return new PrivateChannel('message.admin');
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith() : array
    {
        return [
            'message' => $this->message,
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'message';
    }
}
