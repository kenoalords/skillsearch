<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Comment;
use App\Models\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BlogCommentLikeNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $blog;
    public $comment;
    public $user;

    public function __construct(Blog $blog, Comment $comment, User $user)
    {
        $this->blog = $blog;
        $this->comment = $comment;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject( '👍🏽 ' . $this->user->profile->first_name . ' liked your comment on ' . $this->blog->title )
                    ->from(config('app.mail_from_address'), config('app.name') )
                    ->markdown('email.notifications.blog-comment-like-notification')
                    ->with([ 'user'=> $this->user, 'comment'=> $this->comment, 'blog'=> $this->blog, 'url'=> route('view_blog', ['slug'=> $this->blog->slug, 'blog'=> $this->blog->id, 'user' => $this->blog->user->name, 'utm_source'=>'Notification', 'utm_medium'=> 'Email', 'utm_campaign'=>'comment_like_notification' ]) ]);
    }
}
