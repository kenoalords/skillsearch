<?php

namespace App\Console;

use Mail;
use App\Models\ContactInvite;
use App\Mail\ContactInviteReminder;
use App\Mail\CronTestEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        // Send out reminder emails for invites
        $schedule->call(function(){

            $reminder = ContactInvite::getSentInvites()->get();
            $reminder->each(function($item, $key){
                Mail::to($item->email)->send(new ContactInviteReminder($item->invitee_name, $item->email));
            });

        })->weekly()->tuesdays()->at('10:00')->timezone('Africa/Lagos');

        //->weekly()->tuesdays()->at('10:00')->timezone('Africa/Lagos');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
