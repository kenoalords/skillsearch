<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CancelVerifyNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $message;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $message)
    {
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->user->profile->first_name . ', Your Profile Verification Update')
        ->markdown('email.notifications.cancel_request')
        ->with([
                'name'      => $this->user->profile->first_name,
                'message'   => $this->message,
                'url'       => config('app.url') . '/login'
            ]);
    }
}
