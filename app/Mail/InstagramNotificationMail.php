<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InstagramNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $user;
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
        $first_name = ucfirst(strtolower($this->user->profile->first_name));
        return $this->from(config('app.mail_from_address'), 'Keno via ' . config('app.name'))
                    ->subject($first_name . ', Connect Your Instagram Account on ' . config('app.name'))
                    ->markdown('email.notifications.instagram')
                    ->with('user', $this->user);
    }
}
