<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobRejectNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $message;
    private $task;
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($message, Task $task)
    {
        $this->message = $message;
        $this->task = $task;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Job Posting Has Been Rejected')
                    ->markdown('email.job.reject')
                    ->with([
                            'fullname'  => $this->task->user->name,
                            'task'      => $this->task,
                            'message'   => $this->message,
                        ]);
    }
}
