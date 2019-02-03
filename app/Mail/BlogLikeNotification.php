<?php

namespace App\Mail;

use Log;
use App\Models\Blog;
use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BlogLikeNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $ID;
    public $count;

    public function __construct($name, $ID, $count)
    {
        $this->name = $name;
        $this->ID = $ID;
        $this->count = $count;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $blog = Blog::where('id', $this->ID)->first();
        // $profile = Profile::where('user_id', $blog->user_i)
        return $this->subject($this->name . ' likes your blog post on Ubanji.')
                    ->from(config('app.mail_from_address'), config('app.name') )
                    ->markdown('email.notifications.blog-like')
                    ->with([
                        'owner' => $blog->user->profile->first_name,
                        'name'  => $this->name,
                        'count' => $this->count,
                        'blog'  => $blog,
                        'url'   => route('view_blog', ['slug'=> $blog->slug, 'blog'=> $blog->id, 'user' => $blog->user->name ]),
                    ]);
    }
}
