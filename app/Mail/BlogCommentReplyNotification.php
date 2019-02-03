<?php

namespace App\Mail;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BlogCommentReplyNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $comment;
    public $user;
    public $reply;
    public $blog;

    public function __construct(Comment $comment, User $user, Comment $reply, Blog $blog)
    {
        $this->comment = $comment;
        $this->user = $user;
        $this->reply = $reply;
        $this->blog = $blog;
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
                    ->markdown('email.notifications.blog-comment-reply-notification')
                    ->with([ 'comment'=> $this->comment, 'user'=> $this->user, 'reply'=> $this->reply, 'blog'=> $this->blog, 'url'=> route('view_blog', ['slug'=> $this->blog->slug, 'blog'=> $this->blog->id, 'user' => $this->blog->user->name, 'utm_source'=>'Notification', 'utm_medium'=> 'Email', 'utm_campaign'=>'comment_like_notification' ]) ]);
    }
}
