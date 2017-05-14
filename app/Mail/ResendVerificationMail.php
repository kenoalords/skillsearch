<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResendVerificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $name;
    private $key;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $key)
    {
        $this->name = $name;
        $this->key = $key;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verify Your Account')
                    ->markdown('email.user.verification')
                    ->with([
                        'name'  => $this->name,
                        'key'   => route('verify_user', ['verify_key'=>$this->key]),
                    ]);
    }
}
