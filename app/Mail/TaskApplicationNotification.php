<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskApplicationNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $user;
    private $applicant;
    private $task;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, User $applicant, Task $task)
    {
        $this->user = $user;
        $this->applicant = $applicant;
        $this->task = $task;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('app.mail_from_address'), $this->applicant->profile->first_name . ' via ' . config('app.name'))
                    ->subject($this->applicant->profile->first_name . ' Applied for your job via ' . config('app.name'))
                    ->markdown('email.job.apply')
                    ->with([
                        'user'  => $this->user,
                        'applicant' => $this->applicant,
                        'task'  => $this->task,
                        'url'   => route('task', ['task'=>$this->task->id, 'slug'=>$this->task->slug]). '?utm_source=email&utm_medium=job_apply_notification&utm_campaign=job_application&utm_term=application&utm_content=job_application',
                    ]);
    }
}
