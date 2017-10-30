<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReferralNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $fullname;
    public $username;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $fullname, $username)
    {
        $this->user = $user;
        $this->fullname = $fullname;
        $this->username = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user()->profile()->first();
        $fname = ucwords($user->first_name);
        return $this->subject($fname . ', ' . $this->fullname . ' signed up using your referral code')
                    ->from(config('app.mail_from_address'), config('app.name'))
                    ->markdown('email.notifications.referralAlert')
                    ->with([
                        'user'  => $fname,
                        'fullname'  => $this->fullname,
                        'url'  => config('app.url').'/'.$this->username,
                    ]);
    }
}
