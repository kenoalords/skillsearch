<?php

namespace App\Mail;

use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerificationReminderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $user;
    private $key;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $key)
    {
        $this->user = $user;
        $this->key = $key;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(ucfirst($this->user) . ' Please Verify Your Account at ' . config('app.name'))
                    ->markdown('email.user.verification-reminder')
                    ->with([
                        'name'  => ucfirst($this->user),
                        'key'   => $this->key,
                        'url'   => route('verify_user', ['verify_key'=>$this->key])
                    ]);
    }
}
