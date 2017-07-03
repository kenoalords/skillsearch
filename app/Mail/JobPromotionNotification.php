<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobPromotionNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $tasks;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('app.mail_from_address'), 'Jobs via ' . config('app.name'))
                    ->subject('Latest Jobs on ' . config('app.name'))
                    ->markdown('email.job.promo')
                    ->with('tasks', $this->tasks);
    }
}
