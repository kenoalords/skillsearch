<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactInviteReminder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $name;
    private $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email)
    {
        $this->name = ucwords(strtolower($name));
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), $this->name . ' via ' . config('app.name'))
                    ->subject($this->name . ' is waiting for you to join ' . config('app.name'))
                    ->markdown('invites.reminder')
                    ->with([
                        'url'   => config('app.url').'/?utm_source=email&utm_medium=contact_invite&utm_campaign=website_invite&utm_term=Invitation&utm_content=email_invites',
                        'name'  => $this->name,
                        'unsubscribe'   => config('app.url').'/unsubscribe/invite-reminder/?email='.urlencode($this->email),
                        'email' => $this->email,
                        'subject' => $this->subject,
                    ]);
    }
}
