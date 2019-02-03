<?php

namespace App\Mail;

use App\Models\Blog;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BlogSubscriptionNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $blog;

    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $count = Subscriber::where('user_id', $this->blog->user->id)->count();
        return $this->subject('🎉 You have a new subscriber')
                    ->from(config('app.mail_from_address'), config('app.name'))
                    ->markdown('email.notifications.blog-subscription-notification')
                    ->with([ 'blog' => $this->blog, 'count' => $count ]);
    }
}
