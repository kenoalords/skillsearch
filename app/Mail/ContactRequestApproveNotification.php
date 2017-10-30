<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactRequestApproveNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $fullname;
    public $username;
    public $phone;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fullname, $username, $phone)
    {
        $this->fullname = ucwords($fullname);
        $this->username = $username;
        $this->phone    = $phone;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->username . ' has approved your contact request')
                    ->from(config('app.mail_from_address'), config('app.name') . ' Notification')
                    ->markdown('email.notifications.approve')
                    ->with([
                        'fullname'  => $this->fullname,
                        'username'  => $this->username,
                        'phone'     => $this->phone,
                    ]);
    }
}
