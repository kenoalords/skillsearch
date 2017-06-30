<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobBroadcastNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $user;
    private $task;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Task $task)
    {
        $this->user = $user;
        $this->task = $task;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $profile = $this->user->profile;
        return $this->subject(ucfirst($profile->first_name) . ', We found a job for you!')
                    ->from(config('app.mail_from_address'), 'Jobs via ' . config('app.name'))
                    ->markdown('email.job.notify')->with([
                            'name'  => $profile->first_name,
                            'task'  => $this->task,
                            'url'   => route('task', [ 'task'=>$this->task->id, 'slug'=>$this->task->slug ]) . '?utm_source=email&utm_medium=job_broadcast_notification&utm_campaign=job_broadcast&utm_term=job_broadcast&utm_content=job_broadcast_via_email'
                        ]);
    }
}
