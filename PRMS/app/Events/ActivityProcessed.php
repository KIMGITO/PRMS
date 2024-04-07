<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityProcessed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $description;
    public $action;
    public $status;
    /**
     * Create a new event instance.
     */
    public function __construct($user, $description, $action, $status)
    {
        $this->user = $user;
        $this->description = $description;
        $this->action = $action;
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
