<?php

namespace App\Mail;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BlogCommentNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $blog;
    public $user;
    public $comment;

    public function __construct(Blog $blog, User $user, Comment $comment)
    {
        $this->blog = $blog;
        $this->user = $user;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('🔔 ' . $this->user->profile->first_name . ' commented on your blog post')
                    ->from(config('app.mail_from_address'), config('app.name') )
                    ->markdown('email.notifications.blog-comment-notification')
                    ->with([ 'blog' => $this->blog, 'user' => $this->user, 'comment' => $this->comment, 'url' => route('view_blog', ['slug'=> $this->blog->slug, 'blog'=> $this->blog->id, 'user' => $this->blog->user->name, 'utm_source'=>'Notification', 'utm_medium'=> 'Email', 'utm_campaign'=>'comment_like_notification' ]) ]);
    }
}
