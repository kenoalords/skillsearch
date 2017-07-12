<?php

namespace App\Mail;

use App\Models\LinkedinContacts;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LinkedinContactMailingList extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $contact;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(LinkedinContacts $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = ($this->contact->first_name != '') ? $this->contact->first_name . ', Don\'t Hire Another Creative Person Until You\'ve Read This' : 'Don\'t Hire Another Creative Person Until You\'ve Read This';
        return $this->subject($subject)
                    ->from(config('app.mail_from_address'), 'Adedeji Stevens')
                    ->markdown('email.notifications.linkedin')
                    ->with([
                        'contact' => $this->contact,
                        'url'   => route('people') . '/?utm_source=newsletter&utm_medium=email&utm_campaign=linkedin_contact_promo&utm_content=linkedin_contact'
                    ]);
    }
}
