<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InviteAccepted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $sender_name;
    private $receiver_name;
    private $username;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sender_name, $receiver_name, $username)
    {
        $this->sender_name = $sender_name;
        $this->receiver_name = $receiver_name;
        $this->username = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(ucwords($this->receiver_name) . ' Accepted Your Invitation to Skillsearch Nigeria')
                    ->markdown('invites.accepted')
                    ->with([
                        'receiver_name' => $this->receiver_name,
                        'sender_name'   => $this->sender_name,
                        'url'           => config('app.url') . '/' . $this->username,
                    ]);
    }
}
