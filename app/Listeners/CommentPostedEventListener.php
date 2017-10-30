<?php

namespace App\Listeners;

use App\Events\CommentPostedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class CommentPostedEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommentPostedEvent  $event
     * @return void
     */
    public function handle(CommentPostedEvent $event)
    {
        return $event->comment;
    }
}
