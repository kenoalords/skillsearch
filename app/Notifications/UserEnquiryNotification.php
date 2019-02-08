<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class UserEnquiryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public $enquiry;
    public $name;

    public function __construct($enquiry, $name)
    {
        $this->enquiry = $enquiry;
        $this->name = $name;
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
                    ->subject('🔔 You have a new enquiry')
                    ->line($this->name . ' sent you an enquiry, please read below.')
                    ->line('--------- message ---------')
                    ->line($this->enquiry->message)
                    ->line($this->enquiry->phone_number)
                    ->line('----------------------------')
                    ->action('Reply to ' . $this->name, 'mailto:'.$this->enquiry->email);
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title($this->name . ' sent you an enquiry')
            ->body('Check your email to view message')
            ->action('View enquiry', url('/'))
            ->renotify();
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
