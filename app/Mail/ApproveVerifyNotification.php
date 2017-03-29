<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApproveVerifyNotification extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->user->profile->first_name . ', Your Profile Identity is Approved!')
                    ->markdown('email.notifications.approve_request')
                    ->with([
                        'name' => $this->user->profile->first_name,
                        'url'   => config('app.url').'/login',
                    ]);
    }
}
