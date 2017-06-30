<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobApprovalNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $task;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Approved: Your Job Has Been Approved!')
                    ->markdown('email.job.approve')
                    ->with([
                        'task' => $this->task,
                        'fullname' => $this->task->user->name,
                        'url'   => route('task', [ 'task'=>$this->task->id, 'slug'=>$this->task->slug ]) . '?utm_source=email&utm_medium=job_broadcast_notification&utm_campaign=job_broadcast&utm_term=job_broadcast&utm_content=job_broadcast_via_email'
                    ]);
    }
}
