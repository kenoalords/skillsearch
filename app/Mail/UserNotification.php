<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserNotification extends Mailable
{
    use Queueable, SerializesModels;


    protected $user;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        return $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(User $user)
    {
        $key = $this->user->verifyUser()->first()->verify_key;

        $url = route('verify_user', ['verify_key' => $key]); 

        return $this->markdown('email.user.created')
                    ->with([
                        'name'  => $this->user->name,
                        'email' => $this->user->email,
                        'url'   => $url
                    ]);
    }
}
