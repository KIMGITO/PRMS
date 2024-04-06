<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserWithOTPCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    // public $user;
    public $otp;
    public $email;
    public $subject;

    /**
     * Create a new event instance.
     */
    public function __construct($email, $otp, $subject)
    {
        // $this->user = $user;
        $this->otp = $otp;
        $this->email = $email;
        $this->subject = $subject;
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
