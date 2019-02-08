<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class PortfolioCommentLikeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */


    private $comment;
    private $portfolio;
    private $name;
    private $url;


    public function __construct($comment, $portfolio, $name)
    {
        $this->comment = $comment;
        $this->name = $name;
        $this->portfolio = $portfolio;
        $this->url = route('view_portfolio', [ 'user' => $portfolio->user->name, 'portfolio' => $portfolio->uid ]);
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
                    ->subject('👍🏽 ' . $this->name . ' likes your comment')
                    ->line($this->name . ' likes a comment you posted on ' . $this->portfolio->title)
                    ->action('View comment', url($this->url));
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title($this->name . ' likes your comment')
            ->image(url($this->portfolio->thumbnail))
            ->body($this->name . ' likes a comment you posted on ' . $this->portfolio->title )
            ->action('View', url($this->url));
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
