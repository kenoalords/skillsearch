<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Task;
use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobApplicationResponseNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $sender;
    private $receiver;
    private $task;
    private $application;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $sender, User $receiver, Task $task, Application $application)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->task = $task;
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $sender_name = ucfirst(strtolower($this->sender->profile->first_name));
        return $this->from(config('app.mail_from_address'), $sender_name . ' via ' . config('app.name'))
                    ->subject('You Have a New Job Application Response')
                    ->markdown('email.job.response')
                    ->with([
                        'receiver'  => $this->receiver->profile->first_name,
                        'sender'    => $sender_name,
                        'application'   => $this->application,
                        'task'      => $this->task
                    ]);
    }
}
