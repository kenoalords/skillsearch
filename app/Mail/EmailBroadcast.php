<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Transformers\SimpleUserTransformers;

class EmailBroadcast extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $subject;
    public $body;
    public $url;
    public $text;
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct(User $user, $subject, $body, $url, $text)
    {
        $this->user = $user;
        $this->subject = $subject;
        $this->body = $body;
        $this->url = $url;
        $this->text = $text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $profile = fractal()->item($this->user)
                            ->transformWith(new SimpleUserTransformers)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
        $email_subject = $this->subject;
        return $this->subject($profile['first_name'] . ', ' . $this->subject)
                    ->from(config('app.mail_from_address'), 'Keno from ' . config('app.name'))
                    ->markdown('email.notifications.broadcast')
                    ->with([
                        'body'          => $this->body,
                        'url'           => $this->url,
                        'button_text'   => $this->text,
                        'email'         => $this->user->email,
                        'sub'           => $email_subject,
                    ]);
    }
}
