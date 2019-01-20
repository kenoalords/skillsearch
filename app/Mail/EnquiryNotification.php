<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnquiryNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;
    public $email;
    public $name;
    public $message;

    public function __construct(User $user, $name, $email, $message)
    {
        $this->user = $user;
        $this->email = $email;
        $this->name = ucwords(strtolower($name));
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->name . " sent you an enquiry on Ubanji")
                    ->from(config('app.mail_from_address'), 'Ubanji')
                    ->reply_to($this->email, $this->name)
                    ->markdown('email.notifications.enquiry');
    }
}
