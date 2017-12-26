<?php

namespace App\Mail;

use App\Models\Portfolio;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FeaturedPortfolioNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $title;
    public $username;
    public $thumbnail;
    public $url;
    public $fname;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $username, $thumbnail, $url, $fname)
    {
        $this->title = $title;
        $this->username = $username;
        $this->thumbnail = $thumbnail;
        $this->url = $url;
        $this->fname = $fname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Congratulations! Your work is now featured on ' . config('app.name') )
                    ->markdown('email.notifications.featured-work')
                    ->with([
                        'title' => $this->title,
                        'fname' => $this->fname,
                        'url' => $this->url,
                        'thumbnail' => $this->thumbnail,
                        'share' => config('app.url') . '/profile/portfolio/add',
                    ]);
    }
}
