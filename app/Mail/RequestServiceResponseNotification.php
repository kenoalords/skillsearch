<?php

namespace App\Mail;

use App\Models\User;
use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestServiceResponseNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $service;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ServiceRequest $service, User $user)
    {
        $this->service = $service;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.notifications.response')->with([
            'subject'   => $this->service->subject,
            'name'      => $this->user->profile->first_name,
            'url'       => config('app.url').'/profile/requests',
        ]);
    }
}
