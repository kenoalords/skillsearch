<?php

namespace App\Events;

use App\Models\Comment;
use App\Models\Portfolio;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Transformers\CommentTransformer;

class CommentPostedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $comment;
    public $portfolio;

    public function __construct(Comment $comment, Portfolio $portfolio)
    {
        $this->comment = fractal()->item($comment)->transformWith(new CommentTransformer)->toArray();
        $this->portfolio = $portfolio;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('portfolio.'.$this->portfolio->uid);
    }
}
