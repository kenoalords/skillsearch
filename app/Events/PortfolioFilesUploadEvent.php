<?php

namespace App\Events;

use App\Models\Portfolio;
use App\Models\File;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PortfolioFilesUploadEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // public $portfolio;
    public $file;
    // public $default;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        // $this->portfolio = $portfolio;
        $this->file = $file;
        // $this->default = $default;
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
