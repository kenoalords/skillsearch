<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class PortfolioLike extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $portfolio;
    private $user;
    private $url;

    public function __construct($portfolio, $user)
    {
        $this->portfolio = $portfolio;
        $this->user = $user;
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
                    ->subject($this->user . ' liked your work')
                    ->greeting('Hello ' . $this->portfolio->user->profile->first_name . ',')
                    ->line($this->user . ' liked your work ' . $this->portfolio->title )
                    ->action('View your work', url($this->url));
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title($this->user . ' liked your work ' . $this->portfolio->title)
            ->icon('/approved-icon.png')
            ->image(url($this->portfolio->thumbnail))
            ->body('Keep sharing your beautiful works!')
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
