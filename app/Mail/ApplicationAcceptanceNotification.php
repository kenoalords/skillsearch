<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplicationAcceptanceNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $application;
    private $title;
    private $fullname;
    private $owner_name;
    private $budget;
    private $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fullname, $title, $owner_name, $application, $budget, $message)
    {
        $this->application = $application;
        $this->title = $title;
        $this->owner_name = $owner_name;
        $this->budget = $budget;
        $this->message = $message;
        $this->fullname = $fullname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Congratulations! Your Application Was Accepted!')
                    ->markdown('email.job.accept')
                    ->with([
                        'application'   => $this->application,
                        'fullname'   => $this->fullname,
                        'owner_name'   => $this->owner_name,
                        'budget'   => $this->budget,
                        'message'   => $this->message,
                        'title'   => $this->title,
                    ]);
    }
}
