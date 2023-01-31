<?php

namespace App\Events;

use App\Models\Feedback;
use App\Models\Message;
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
     * User id for transferring data only for him
     *
     * @var int
     */
    public $user_id;

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
     */
    public function __construct(Feedback $feedback, Message $message)
    {
        $this->type = 'message';
        $this->message = $message;
        $this->user_id = $feedback->user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        if (auth()->user()->isUser()) {
            return new PrivateChannel('admin');
        }

        return new PrivateChannel('user.' . $this->user_id);
    }
}
