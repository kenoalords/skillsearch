<?php

namespace App\Mail;

use App\Models\ContactInvite;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactInviteMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $invitee_name;
    private $receiver_name;
    private $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invitee_name, $receiver_name, $email)
    {
        $this->receiver_name = $receiver_name;
        $this->invitee_name = $invitee_name;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $invitee_name = ucwords(strtolower($this->invitee_name));
        
        // Update the sent flag for invitation
        $invite = ContactInvite::where('email', $this->email)->first();
        $invite->sent = true;
        $invite->save();

        // Send the invite
        return $this->from(env('MAIL_FROM_ADDRESS'), $invitee_name . ' via ' . config('app.name'))
                    ->subject($invitee_name . ' Invites you to join ' . config('app.name'))
                    ->markdown('invites.invite')
                    ->with([
                            'invitee_name'  => $invitee_name,
                            'receiver_name' => $this->receiver_name,
                            'url'           => config('app.url').'/?utm_source=email&utm_medium=contact_invite&utm_campaign=website_invite&utm_term=Invitation&utm_content=email_invites'
                        ]);
    }
}
