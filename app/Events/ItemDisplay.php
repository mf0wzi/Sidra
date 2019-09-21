<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Projectpage;

class ItemDisplay
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $projectpage;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Projectpage $projectpage)
    {
        $this->projectpage = $projectpage;

        event('vendor.voyager.menu.display', $projectpage);
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}