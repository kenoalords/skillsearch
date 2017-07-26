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
    private $profiles;
    private $term;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact, $profiles, $term)
    {
        $this->contact = $contact;
        $this->profiles = json_decode($profiles);
        $this->term = $term;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = ($this->contact->first_name != '') ? $this->contact->first_name . ', Don\'t Hire Another '.$this->term[1].' Until You\'ve Seen This' : 'Don\'t Hire Another '.$this->term[1].' Until You\'ve Seen This';
        return $this->subject($subject)
                    ->from(config('app.mail_from_address'), 'Adedeji Stevens')
                    ->markdown('email.notifications.linkedin')
                    ->with([
                        'contact'   => $this->contact,
                        'profiles'  => $this->profiles,
                        'term'      => $this->term,
                        'url'       => config('app.url') . '/search/?term='.urlencode($this->term[0]).'&utm_source=newsletter&utm_medium=email&utm_campaign=profile_promotion&utm_content=linkedin_contact'
                    ]);
    }
}
