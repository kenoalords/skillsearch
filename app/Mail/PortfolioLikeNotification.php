<?php

namespace App\Mail;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PortfolioLikeNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $user;
    private $portfolio;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Portfolio $portfolio)
    {
        $this->user = $user;
        $this->portfolio = $portfolio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $owner_name = $this->portfolio->user->profile->first_name;
        $liker_name = ucwords(strtolower($this->user->profile->first_name . ' ' . $this->user->profile->last_name));
        $url = config('app.url') . '/' . $this->portfolio->user->name . '/portfolio/' . $this->portfolio->uid;
        return $this->from(env('MAIL_FROM_ADDRESS'), $liker_name . ' via ' . config('app.name'))
                    ->subject($liker_name . ' likes your portfolio')
                    ->markdown('email.notifications.like')
                    ->with([
                        'name'  => $owner_name,
                        'like_name' => $liker_name,
                        'url'   => $url,
                        'title' => $this->portfolio->title,
                    ]);
    }
}
