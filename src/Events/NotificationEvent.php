<?php

namespace Ranger\Notification\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class NotificationEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    private $channel;
    private $notification_channel;
    private $notification_event;

    /**
     * Create a new event instance.
     *
     * @param string $notification_channel
     * @param string $notification_event
     * @param array $data
     */
    public function __construct(string $notification_channel, string $notification_event, array $data)
    {
        $this->data  = $data;
        $this->notification_channel  = $notification_channel;
        $this->notification_event  = $notification_event;
    }

    public function broadcastAs()
    {
        return $this->notification_event;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PrivateChannel
     */
    public function broadcastOn()
    {
        $this->channel = new PrivateChannel($this->notification_channel);
        return $this->channel;
//        return [$this->notification_channel];
    }
}