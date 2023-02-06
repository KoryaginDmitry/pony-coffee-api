<?php

namespace App\Events;

use App\Models\Feedback;
use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Event type to distribute to front-end
     *
     * @var string
     */
    public $type;

    /**
     * Message to be sent
     *
     * @var Message
     */
    public $message;

    /**
     * Feedback
     *
     * @var Feedback
     */
    public $feedback;

    /**
     * Auth user
     *
     * @var User
     */
    public $user;

    /**
     * The name of the queue on which to place the broadcasting job.
     *
     * @var string
     */
    public $queue = 'default';

    /**
     * Construct
     *
     * @param Feedback $feedback
     * @param Message  $message
     * @param User $user
     */
    public function __construct(Feedback $feedback, Message $message, User $user)
    {
        $this->type = 'message';
        $this->message = $message;
        $this->feedback = $feedback;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        if ($this->user->role_id == 3) {
            return new PrivateChannel('admin');
        }

        return new PrivateChannel('user.' . $this->feedback->user_id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'type' => $this->type,
            'message' => $this->message,
            'feedback_id' => $this->feedback->id
        ];
    }
}
