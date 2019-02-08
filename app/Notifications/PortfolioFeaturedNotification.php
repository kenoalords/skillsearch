<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class PortfolioFeaturedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $portfolio;
    private $url;

    public function __construct($portfolio)
    {
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
                    ->subject('⭐️ '. $this->portfolio->title .' is now featured on Ubanji')
                    ->greeting('Hello ' . $this->portfolio->user->profile->first_name)
                    ->line('We loved your work so much we decided to mark it as featured.')
                    ->line('Keep sharing your beautiful work and inspire others.')
                    ->action('View featured work', url($this->url))
                    ->line('Thank you for using Ubanji!');
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title($this->portfolio->title . ' is now featured on Ubanji')
            ->image(url($this->portfolio->thumbnail))
            ->body('Congrats!! More people will get to see your work.')
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
