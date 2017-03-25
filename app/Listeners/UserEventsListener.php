<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\UserEvents;
use App\Mail\UserNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class UserEventsListener implements ShouldQueue
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
     * @param  UserEvents  $event
     * @return void
     */
    public function handle(UserEvents $event)
    {
        Mail::to($event->user)->send(new UserNotification($event->user));
    }

    public function fail(User $user, $ex){
        // dd($user);
    }
}
