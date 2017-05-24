<?php

namespace App\Console;

use Mail;
use App\Models\User;
use App\Models\VerifyUser;
use App\Models\ContactInvite;
use App\Mail\ContactInviteReminder;
use App\Mail\CronTestEmail;
use App\Mail\InstagramNotificationMail;
use App\Mail\VerificationReminderMail;
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
                $user = User::where('email', $item->email)->first();
                if(!$user){
                    Mail::to($item->email)->send(new ContactInviteReminder($item->invitee_name, $item->email));
                }
            });

        })->weekly()->tuesdays()->at('10:00')->timezone('Africa/Lagos');

        $schedule->call(function(){

            $verify = VerifyUser::get();
            if($verify->count()){
                $verify->each( function($item, $key) {
                    $user = User::where('id', $item->user_id)->first();
                    Mail::to($user)->send( new VerificationReminderMail( $user->name, $item->verify_key ) );
                });
            }

        })->weekly()->fridays()->at('10:00')->timezone('Africa/Lagos');


        // Instagram Notification Schedule Mail
        $schedule->call(function(){
            $users = User::get();
            if($users->count()){
                $users->each( function( $user, $key ) {
                    if($user->profile->account_type === 1){
                        Mail::to($user)->send( new InstagramNotificationMail($user) );
                    }
                });
            }
        })->weekly()->wednesdays()->at('19:30')->timezone('Africa/Lagos');
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
