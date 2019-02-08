<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class BlogCommentLikeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $blog;
    private $comment;
    private $name;
    private $url;

    public function __construct($blog, $comment, $name)
    {
        $this->blog = $blog;
        $this->name = $name;
        $this->comment = $comment;
        $this->url = route('view_blog', [ 'user' => $blog->user->name, 'blog' => $blog->id, 'slug' => $blog->slug ]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', WebPushChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('👍 ' . $this->name . ' likes your comment')
                    ->line($this->name . ' likes your comment on ' . $this->blog->title . '.')
                    ->action('View likes', url($this->url));
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('👍 ' . $this->name . ' likes your comment')
            ->image(url($this->blog->image))
            ->body($this->name . ' likes your comment on ' . $this->blog->title . '. Click to view likes')
            ->action('View subscribers', url( $this->url ));
            // ->data(['id' => $notification->id])
            // ->badge()
            // ->dir()
            // ->lang()
            // ->renotify()
            // ->requireInteraction()
            // ->tag()
            // ->vibrate()
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
