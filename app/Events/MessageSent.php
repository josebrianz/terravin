<?php

namespace App\Events;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $sender;
    public $receiverId;

    public function __construct(ChatMessage $message, User $sender, $receiverId)
    {
        $this->message = $message;
        $this->sender = $sender;
        $this->receiverId = $receiverId;
    }

    public function broadcastOn()
    {
        // Private channel for the receiver
        return new PrivateChannel('chat.' . $this->receiverId);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'created_at' => $this->message->created_at->toDateTimeString(),
        ];
    }
}
