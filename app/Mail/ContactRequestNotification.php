<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request; 

class ContactRequestNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($user, $name)
    {
        $this->user = $user;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject( ucwords($this->name) . ' Requested Your Contact Details' )
                    ->from(config('app.mail_from_address'), config('app.name') . ' Notification')
                    ->markdown('email.notifications.contactrequestnotifications')
                    ->with([
                        'user'  => ucwords($this->user),
                        'request_name'  => ucwords($this->name),
                        'url'   => route('user_contact_requests'),
                    ]);
    }
}
