<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactRequestResponseNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $name;
    public $sender;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fullname, $name)
    {
        $this->sender = ucwords($fullname);
        $this->name = ucwords($name);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->name . '\'s contact has been requested')
                    ->from(config('app.mail_from_address'), config('app.name') . ' Notification')
                    ->markdown('email.notifications.contactrequestresponse')
                    ->with([
                        'sender'    => $this->sender,
                        'name'      => $this->name,
                    ]);
    }
}
