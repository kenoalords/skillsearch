<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactInviteBroadcast extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $subject;
    public $body;
    public $url;
    public $text;
    public $email;
    public $sender;

    public function __construct($subject, $body, $url, $text, $email, $sender)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->url = $url;
        $this->text = $text;
        $this->email = $email;
        $this->sender = $sender;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject( $this->subject )
                    ->from(config('app.mail_from_address'), config('app.name') . ' Team.')
                    ->markdown('invites.broadcast')
                    ->with([
                        'body'          => $this->body,
                        'url'           => $this->url,
                        'button_text'   => $this->text,
                        'email'         => $this->email,
                        'sub'           => $this->subject,
                        'sender'        => $this->sender,
                    ]);
    }
}
