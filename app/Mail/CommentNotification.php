<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Profile;
use App\Models\Portfolio;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $portfolio;
    protected $request;
    protected $reply_id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($portfolio, $request, $reply_id)
    {
        $this->portfolio = $portfolio;
        $this->request   = $request;
        $this->reply_id  = $reply_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = '';
        $profile = Profile::where('user_id', $this->request)->first();
        $portfolio = Portfolio::where('id', $this->portfolio)->first();
        $subject = $profile->getFullname() . ' Commented On Your Portfolio ' . ucwords(strtolower($portfolio->title));

        return $this->subject($subject)
                    ->from(config('app.mail_from_address'), $profile->getFullname() . ' via ' . config('app.name') )
                    ->markdown('email.comment.notification')
                    ->with([
                            'name'      => $profile->getFullname(),
                            'url'       => config('app.url') . '/' . $portfolio->user->name . '/portfolio/' . $portfolio->uid,
                            'portfolio' => $portfolio,
                            'request'   => $profile,
                        ]);
    }
}
