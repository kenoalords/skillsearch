<?php

namespace App\Events;

use App\Models\Portfolio;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PortfolioImageUploadEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $portfolio;
    public $thumbnail;
    public $default;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Portfolio $portfolio, $thumbnail, $default=null)
    {
        $this->portfolio = $portfolio;
        $this->thumbnail = $thumbnail;
        $this->default = $default;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [];
    }
}
