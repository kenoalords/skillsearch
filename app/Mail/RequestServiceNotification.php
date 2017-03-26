<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestServiceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $sender;
    public $reciever;
    public $services;
    public $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $sender, User $reciever, $services, $message)
    {
        $this->sender = $sender;
        $this->reciever = $reciever;
        $this->services = $services;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->markdown('email.notifications.services')->with([
                'sender_name'   => $this->sender->profile->first_name,
                'reciever_name' => $this->reciever->profile->first_name,
                'services'      => $this->services,
                'message'       => $this->message,
                'url'           => config('app.url') . '/profile/requests'
            ]);
    }
}
