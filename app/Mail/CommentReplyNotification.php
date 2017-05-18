<?php

namespace App\Mail;

use App\Models\Portfolio;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentReplyNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $portfolio;
    protected $user;
    protected $owner;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Portfolio $portfolio, $user, User $owner)
    {
        $this->portfolio = $portfolio;
        $this->user = $user;
        $this->owner = $owner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::where('id', $this->user)->first();
        $name = ucwords(strtolower($user->profile->getFullname()));
        return $this->from(config('app.mail_from_address'), $name . ' via ' . config('app.name'))
                    ->subject($name . ' replied to your comment on ' . $this->portfolio->title)
                    ->markdown('email.comment.replynotification')
                    ->with([
                        'name'  => $name,
                        'owner' => $this->owner->profile->getFullname(),
                        'url'   => config('app.url') . '/' . $this->owner->name . '/portfolio/' . $this->portfolio->uid,
                        'portfolio' => $this->portfolio,
                    ]);
    }
}
