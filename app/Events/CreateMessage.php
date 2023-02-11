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
     * Message to be sent
     *
     * @var Model
     */
    public Model $message;

    /**
     * Auth user id
     *
     * @var Feedback
     */
    public Feedback $feedback;

    /**
     * The user who sent the message is an admin or not
     *
     * @var bool
     */
    public bool $isAdmin;

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
    public function __construct(Model $message, Feedback $feedback, bool $isAdmin)
    {
        $this->message = $message;
        $this->feedback = $feedback;
        $this->isAdmin = $isAdmin;
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
}
